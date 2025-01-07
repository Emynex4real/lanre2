<?php

    class PPCUser {
        private $db;
        private $user_id;
        private $email;
        private $username;
        private $password;
        private $coupon_code;


        public function __construct($user_id = null) {
            global $db;
            $this->db = $db;
            $this->user_id = $user_id;
        }


        public function createUser($email, $username, $coupon_code, $password, $referral_code = null) {
            $this->email = $email;
            $this->username = $username;
            $this->coupon_code = $coupon_code;
            $referred_by = null;

            // echo $referral_code;
            // Check if referral code is provided and valid
            if ($referral_code) {
                $sql = "SELECT `user_id` FROM `users` WHERE `referral_code` = :referral_code";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':referral_code' => $referral_code]);
    
                if ($stmt->rowCount() > 0) {
                    $referred_by = $stmt->fetch(PDO::FETCH_ASSOC)['user_id'];
                }
            }

            // Generate Referral Code
            $referral_code_username = substr($username, 0, 6);
			$referral_code_added_number = str_pad(rand(0, pow(10, 3)-1), 3, '0', STR_PAD_LEFT);
			$referral_code = $referral_code_username . $referral_code_added_number;
            $password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO `users` (email, username, subscription_status, income_balance, referral_code, referred_by, password, all_time_earnings) VALUES (:email, :name, :subscription_status, :balance, :referral_code, :referred_by, :password, :all_time_earnings)";
            $stmt = $this->db->prepare($sql);
            if ($stmt->execute([
                ':email' => $this->email,
                ':name' => $this->username,
                ':balance' => 200.00, // Give each user  abonus of 200 naira
                ':all_time_earnings' => 200.00, //
                ':password' => $password,
                ':referral_code' => $referral_code,
                ':referred_by' => $referred_by,
                ':subscription_status' => 1
            ])) {
                $this->user_id = $this->db->lastInsertId();

                $this->couponCodeUsed($coupon_code);
                $transaction = new PPCTransaction($this->user_id);
                $transaction->newTransaction( "Welcome Bonus", 200.00, "success", "income");

                session_start();
                $_SESSION['user'] = $this->username;
                $_SESSION['user_id'] = $this->user_id;
                $_SESSION['last_login_timestamp'] = time();

                if ($referred_by) {
                    $this->handleReferralsBonuses( $referred_by, $this->user_id);
                }

                return $this->user_id;
            } return false;
        }


        public function getUserById($user_id) {
            $sql = "SELECT * FROM `users` WHERE `user_id` = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        public function createReferralRelations($userID, $referrerID, $level, $bonus) {
            $stmt = $this->db->prepare("INSERT INTO `referrals` (`user_id`, `referred_by`, `level`, `amount_earned`) VALUES (:id, :referred_by, :level, :amount)");
            if ($stmt->execute(array(
                ":id"            =>   $userID,
                ":referred_by"   =>   $referrerID, 
                ":level"         =>   $level, 
                ":amount"        =>   $bonus
            ))) {
                $this->giveUserReferralBonus($referrerID, $bonus);
            } 
        }


        public function userLogin($username, $password) {
            $this->username = $username;
            $this->password = $password;

            $sql = "SELECT * FROM `users` WHERE `username` = :detail OR `email` = :detail LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':detail' => $username
            ]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($data) { 
                $hashed_password = $data["password"];

                if (password_verify( $password, $hashed_password)) {
                    session_start();
                    $_SESSION['user'] = $data['username'];
                    $_SESSION['user_id'] = $data['user_id'];
                    $_SESSION['last_login_timestamp'] = time();
  
                    $currentDate = date('Y-m-d'); 
                    if ($data['last_bonus_date'] !== $currentDate) {
                        $sql = "UPDATE `users` SET `last_bonus_date` = :currentDate WHERE `user_id` = :userId";
                        $stmt = $this->db->prepare($sql);
                        $stmt->execute([
                            ':currentDate' => $currentDate,
                            ':userId' => $data['user_id']
                        ]);
                        
                        $this->grantDailyLoginBonus($data['user_id']);
                        $transaction = new PPCTransaction($data['user_id']);
                        $transaction->newTransaction("Daily Login", 50.00, "success", "login"); 
                    }

                    return true;
                }

            } return false;
        }


        public function updateUserDetails($email, $username, $password) {
            $this->email = $email;
            $this->username = $username;

            if ($password) {
                $this->password = password_hash($password, PASSWORD_DEFAULT);
            } else {
                $user_details = $this->getUserDetails();
                $this->password = $user_details["password"];
            }


            $sql = "UPDATE `users` SET email = :email, username = :name, password = :password WHERE `user_id` = :id";
            $stmt = $this->db->prepare($sql);
            if ($stmt->execute([
                ':id' => $this->user_id,
                ':email' => $this->email,
                ':name' => $this->username,
                ':password' => $this->password,
            ])) {
                return true;
            }
        }


        public function payForSubscription($price) {
            $sql = "UPDATE `users` SET `deposit_balance` = deposit_balance - :price WHERE `user_id` = :user_id";
            $stmt = $this->db->prepare($sql);
            if ($stmt->execute([
                ':user_id' => $this->user_id,
                ':price'   => $price
            ])) {
            return true; }
        }


        public function couponCodeChecker($coupon = null) {
            if ($coupon) { $this->coupon_code = $coupon; }
            $sql = "SELECT * FROM `coupons` WHERE `code` = :code";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':code' => $this->coupon_code]);
            $couponData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($couponData) {
                if ($couponData["cusage"] == 1) {
                    return "used";
                } else {
                    return "not-used";
                }
            }

            return false;
        }


        public function couponCodeUsed($coupon) {
            if ($coupon) { $this->coupon_code = $coupon; }
            $sql = "UPDATE `coupons` SET `cusage` = 1 WHERE `code` = :code";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([":code" => $coupon]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        public function checkDataUniqueness($column, $data) {
            $sql = "SELECT * FROM `users` WHERE `$column` = :data";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':data' => $data]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        public function checkResetKey($key) {
            $sql = "SELECT * FROM `users` WHERE `reset_link` = :key AND `user_id` = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':key' => $key, ':id' => $this->user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        public function grantDailyLoginBonus($user_id) {
            $sql = "UPDATE `users` SET `income_balance` = income_balance + :bonus, `all_time_earnings` = all_time_earnings + :bonus WHERE `user_id` = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $user_id,
                ':bonus' => 50.00
            ]);
        }
        

        public function updateUserSubscription($user_id, $subscription_status) {
            $sql = "UPDATE `users` SET `subscription_status` = :subscription_status WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':subscription_status' => $subscription_status,
                ':user_id' => $user_id
            ]);
            return $stmt->rowCount();
        }


        public function updateUserPassword($password) {
            $this->password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "UPDATE `users` SET password = :password, `reset_link` = :link WHERE `user_id` = :id";
            $stmt = $this->db->prepare($sql);
            if ($stmt->execute([
                ':id' => $this->user_id,
                ':link' => "",
                ':password' => $this->password,
            ])) {
                return true;
            }   return false;
        }


        public function getUserDetails() {
            $sql = "SELECT * FROM users WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $this->user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        public function checkUserDetail($detial) {
            $sql = "SELECT * FROM `users` WHERE `username` = :user OR `email` = :user";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user' => $detial]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        public function sendResetLink($email) {
            $code = generateResetToken();

            $sql = "UPDATE `users` SET `reset_link` = :code WHERE `email` = :email";
            $query = $this->db->prepare($sql);
            if ($query->execute(array (
                ':code'  =>  $code,
                ':email'  =>  $email
            ))) {
                $userDetails = $this->getUserDetails();
                $reset_link = $this->user_id . "/" . $code;
                $username = ucfirst($userDetails["username"]);
                require_once("../phpmailer/forgot_password_email.php");
                return true;
            }
        }


        public function getAllUsers() {
            $sql = "SELECT * FROM users ORDER BY USER_ID";
            $stmt = $this->db->query($sql);query: 
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function giveUserReferralBonus($referrerID, $bonus) {
            $sql = "UPDATE `users` SET `income_balance` = income_balance + :bonus, `all_time_earnings` = all_time_earnings + :bonus WHERE `user_id` = :user_id";
            $stmt = $this->db->prepare($sql);
            if ($stmt->execute([
                ':bonus' => $bonus,
                ':user_id' => $referrerID
            ])) {
                $Transaction = new PPCTransaction($referrerID);
                $Transaction->anotherUserTransaction($referrerID ,"Referral Bonus", $bonus, "success", "referral");
            }
        }


        private function handleReferralsBonuses($referred_by, $userId) {
            // Define referral percentages for each level
            $level1Bonus = 500;
            $level2Bonus = 50;
    
            if ($referred_by) {
                $user = new PPCUser($referred_by);
                $user->createReferralRelations($userId, $referred_by, 1,$level1Bonus);
                    
                if ($referred_by) {
                    // Get the referrer of the Direct referral
                    $stmt = $this->db->prepare("SELECT * FROM `users` WHERE `user_id` = :id");
                    $stmt->execute(array(
                        ":id"   =>   $referred_by,
                    ));
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $level2Referrer = $result ? $result["referred_by"] : null;
    
                    if ($level2Referrer) {
                        $level2referrerID = $result["user_id"];
                        $user = new PPCUser($level2referrerID);
                        $user->createReferralRelations($userId, $level2referrerID , 2, $level2Bonus);
                    }
                }
            }
        }


        public function getUserReferralDetails() {
            $sql = "SELECT * FROM `referrals` WHERE `referred_by` = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $this->user_id]);
            $referrals =  $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Sum the 'amount_earned' values
            $totalEarned = array_sum(array_map(function($referral) {
                return $referral['amount_earned'];
            }, $referrals));

            $referral_details["referral_count"] = $stmt->rowCount();
            $referral_details["totalEarned"] = $totalEarned;
            $referral_details["referrals"] = $referrals;
            return $referral_details;
        }


        public function checkBalanceSufficiencyForWithdrawal($amount) {
            $user_details = $this->getUserDetails();
            
            if ($user_details["income_balance"] >= $amount) {
                return true;
            } return false;
        }


        public function createWithdrawalRequest($amount,  $acctNumber, $bankName, $acctName) {
            $sql = "UPDATE `users` SET `income_balance` = income_balance - :amount WHERE `user_id` = :user_id";
            $stmt = $this->db->prepare($sql);
            if ($stmt->execute([
                ':amount' => $amount,
                ':user_id' => $this->user_id
            ])) {
                $stmt = $this->db->prepare("INSERT INTO `withdrawals` (`user_id`, `account_name`, `account_number`, `transaction_id`, `bank_name`) VALUES (:id, :account_name, :account_number, :transaction_id, :amount)");
                if ($stmt->execute(array(
                    ":id"            =>   $this->user_id,
                    ":transaction_id"   =>   getTrx(),
                    ":amount"            =>   $amount,
                    ":account_number"   =>   $acctNumber, 
                    ":account_name"         =>   $acctName, 
                    ":bank_name"        =>   $bankName
                ))) {
                    $Transaction = new PPCTransaction($this->user_id);
                    $Transaction->newTransaction("Withdrawal", $amount, "success", "referral");
                    return true;
                }  
            }   return false;
        }


        public function logout() {
            session_start();
            session_destroy();
        }
    }
    

    
    class PPCAd {
        private $db;
        private $ad_id;
        private $ad_name;
        private $ad_text;
        private $status;
        private $ad_url;
        private $ad_reward;
        private $max_attempt;
        private $start_date;
        private $end_date;
    

        public function __construct() {
            global $db;
            $this->db = $db;
        }

    
        // Create a new ad
        public function createAd($ad_name, $ad_text, $ad_url, $status, $cost_per_click, $max_attempt, $start_date, $end_date) {
            $this->ad_name = $ad_name;
            $this->ad_text = $ad_text;
            $this->status = $status;
            $this->ad_url = $ad_url;
            $this->max_attempt = $max_attempt;
            $this->ad_reward = $cost_per_click;
            $this->start_date = $start_date;
            $this->end_date = $end_date;
    
            $sql = "INSERT INTO `ads` (ad_name, ad_text, status, ad_url, max_attempt, cost_per_click, start_date, end_date) 
                    VALUES (:ad_name, :ad_text, :status, :ad_url, :max_attempt, :reward, :start_date, :end_date)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':ad_name' => $this->ad_name,
                ':ad_text' => $this->ad_text,
                ':status' => $this->status,
                ':ad_url' => $this->ad_url,
                ':max_attempt' => $this->max_attempt,
                ':reward' => $this->ad_reward,
                ':start_date' => $this->start_date,
                ':end_date' => $this->end_date
            ]);
            return $this->db->lastInsertId();
        }

    
        // Get an ad by ID
        public function getAdById($ad_id) {
            $sql = "SELECT * FROM ads WHERE `ad_id` = :ad_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':ad_id' => $ad_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

    
        // Get all ads 
        public function getAds() {
            $sql = "SELECT * FROM `ads` WHERE `status` = :status";
            $stmt = $this->db->prepare(query: $sql);
            $stmt->execute([":status" => "active"]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }



    class PPCSubscribe {
        private $db;
        private $user_id;
        private $status;
        private $price;
        private $plan_id;

        public function __construct() {
            global $db;
            
            $this->db = $db;
        }

        public function subscribeNow($user_id, $plan_id) {
            $this->user_id = $user_id;
            $this->plan_id = $plan_id;
            $this->price = $this->getPlanPrice($plan_id);

            // Check if User has enough balance
            $payNow = $this->getSubscriptionFeeAndPay();

            if ($payNow) {
                $sql = "INSERT INTO `user_subscriptions` (user_id, subscription_id) VALUES (:user, :plan)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    ':user' => $this->user_id,
                    ':plan' => $this->plan_id,
                    ':status' => $this->status
                ]);
                return ["success" => true, "message" => "Subscription purchased"];
            } else {
                return ["success" => false, "message" => "Insufficient balance"];
            }
        }

        

        public function getSubscriptionPlanById($plan_id) {
            $sql = "SELECT * FROM `user_subscriptions` WHERE `user_subscription_id` = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $plan_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }



        public function getAllUserSubscriptions() {
            $sql = "SELECT * FROM `user_subscriptions` ORDER BY USER_SUBSCRIPTION_ID";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function getPlanPrice($plan_id) {
            $sql = "SELECT * FROM `subscriptions` WHERE `subscription_id` = :plan_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':plan_id' => $plan_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC)["price"];
        }


        public function getSubscriptionFeeAndPay() {
            $PPC = new PPCUser($this->user_id);
            $user = $PPC->getUserDetails();
            $user_balance = $user["deposit_balance"];

            if (($user_balance - $this->price) >= 0) {
                if ($user->payForSubscription()) {
                    return true;
                } 
            }
            
            return false;
        }
    }



    class PPCPlan {
        private $db;
        private $name;
        private $price;
        private $duration;
        private $status;
        private $daily_income;
        private $total_income;
        private $purchase_limit;
        private $subscription_id;

        public function __construct() {
            global $db;
            $this->db = $db;
        }

        public function createSubscriptionPlan($name, $price, $status, $duration, $daily_income, $purchase_limit) {
            $this->name = $name;
            $this->price = $price;
            $this->status = $status;
            $this->purchase_limit = $purchase_limit;
            $this->duration = (int) $duration;
            $this->daily_income = (int) $daily_income;
            (int) $this->total_income =  ($this->daily_income * ($this->daily_income * 30));

            $sql = "INSERT INTO `subscriptions` (plan_name, price, duration_months, status, daily_income, total_income, purchase_limit) VALUES (:name, :price, :duration, :status, :daily, :total, :limit)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':name' => $this->name,
                ':price' => $this->price,
                ':limit' => $this->purchase_limit,
                ':duration' => $this->duration,
                ':status' => $this->status,
                ':daily' => $this->daily_income,
                ':total' => $this->total_income
            ]);
            return $this->db->lastInsertId();
        }


        public function updateSubscriptionPlan($name, $price, $status, $duration, $plan_id, $daily_income, $purchase_limit) {
            $this->name = $name;
            $this->price = $price;
            $this->status = $status;
            $this->duration = $duration;
            $this->purchase_limit = $purchase_limit;
            $this->daily_income = (int) $daily_income;
            $this->subscription_id = $plan_id;
            (int) $this->total_income =  ($this->daily_income * ($this->daily_income * 30));

            $sql = "UPDATE `subscriptions` SET `plan_name` = :name, `price` = :price, `duration_months` = :duration, `status` = :status, `daily_income` = :daily, `total_income` = :total, `purchase_limit` = :limit WHERE `subscription_id` = :plan_id";
            $stmt = $this->db->prepare($sql);
            if ($stmt->execute([
                ':plan_id' => $this->subscription_id,
                ':name' => $this->name,
                ':price' => $this->price,
                ':duration' => $this->duration,
                ':status' => $this->status,
                ':daily' => $this->daily_income,
                ':total' => $this->total_income,
                ':limit' => $this->purchase_limit
            ])) {
            return $this->subscription_id; }
        }

        

        public function getSubscriptionPlanById($plan_id) {
            $sql = "SELECT * FROM `subscriptions` WHERE `subscription_id` = :plan_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':plan_id' => $plan_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        public function deleteAd($plan_id) {
            $sql = "DELETE FROM `subscriptions` WHERE `subscription_id` = :plan_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':plan_id' => $plan_id]);
            return $stmt->rowCount();
        }


        public function getSubscriptionPlans() {
            $sql = "SELECT * FROM `subscriptions`";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function getAllUserSubscriptions() {
            $sql = "SELECT * FROM `user_subscriptions` ORDER BY USER_SUBSCRIPTION_ID";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function getPlanName($plan_id) {
            $sql = "SELECT * FROM `subscriptions` WHERE `subscription_id` = :plan_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':plan_id' => $plan_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC)["plan_name"];
        }
    }




    class PPCClick {
        private $db;
        private $click_id;
        private $ad_id;
        private $user_id;

        private $cost_per_click;
        private $click_time;

        public function __construct() {
            global $db;
            $this->db = $db;
        }

        
        public function recordClick($ad_id, $user_id, $cost_per_click) {
            $this->user_id = $user_id;
            $this->ad_id = $ad_id;
            $this->cost_per_click = $cost_per_click;
            $this->click_time = date('Y-m-d H:i:s');

            $sql = "INSERT INTO clicks (ad_id, user_id, click_time, ip_address) VALUES (:ad_id, :user_id, :click_time, :ip_address)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':ad_id' => $this->ad_id,
                ':ip_address' => getUserIP(),
                ':user_id' => $this->user_id,
                ':click_time' => $this->click_time
            ]);
            $this->click_id = $this->db->lastInsertId();

            $this->updateUserAdsParticipationHistory();
            $this->addPPCtoUserBalance();
            return  $this->click_id;
        }


        public function addPPCtoUserBalance() {
            $sql = "UPDATE `users` SET `income_balance` = income_balance + :ppc, `all_time_earnings` = all_time_earnings + :ppc WHERE `user_id` = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':ppc' => $this->cost_per_click,
                ':user_id' => $this->user_id
            ]);
            
            $transaction = new PPCTransaction($this->user_id);
            $transaction->newTransaction("Task completed", $this->cost_per_click, "success", "income");
        }


        public function checkUserClickRecordByAd($ad_id, $user_id) {
            $sql = "SELECT * FROM `clicks` WHERE `ad_id` = :ad_id AND `user_id` = :user";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':ad_id' => $ad_id,
                ':user' => $user_id
            ]);
            return $stmt->rowCount();
        }


        public function getClicksByAd($ad_id) {
            $sql = "SELECT * FROM `clicks` WHERE ad_id = :ad_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':ad_id' => $ad_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function updateUserAdsParticipationHistory() {
            $sql = "UPDATE `users` SET `ads_history` = ads_history + 1 WHERE `user_id` = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->user_id
            ]);
            return $stmt->rowCount();
        }
    }



    
    class PPCTransaction {
        private $db;
        public $user_id;
   

        public function __construct($user_id = null) {
            global $db;
            $this->db = $db;

            if (empty($user_id)) { global $user_id; }

            $this->user_id = $user_id;
        }

        
        public function newTransaction($description, $amount, $status, $type) {
            global $db; global $user_id;
            $transaction_id = substr(md5(rand()),0,5);
			$transaction_code = str_pad(rand(0, pow(10, 3)-1), 3, '0', STR_PAD_LEFT);
            $transaction_id .= $transaction_code;

            try {
                $stmt = $db->prepare("INSERT INTO `transactions` (user_id, description, amount, status, transaction_id, transaction_type) VALUES (:id, :type, :amount, :status, :transaction_id, :trans_type)");
                $stmt->execute([
                    ':id'             =>  $this->user_id,
                    ':trans_type'     =>  $type,
                    ':type'           =>  $description,
                    ':amount'         =>  $amount,
                    ':status'         =>  $status,
                    ':transaction_id' =>  $transaction_id
                ]);
            } catch (PDOException $e) { echo $e; }
        }


        public function anotherUsertransaction($userID, $description, $amount, $status, $type) {
            global $db; global $user_id;
            $transaction_id = substr(md5(rand()),0,5);
			$transaction_code = str_pad(rand(0, pow(10, 3)-1), 3, '0', STR_PAD_LEFT);
            $transaction_id .= $transaction_code;

            try {
                $stmt = $db->prepare("INSERT INTO `transactions` (user_id, description, amount, status, transaction_id, transaction_type) VALUES (:id, :type, :amount, :status, :transaction_id, :trans_type)");
                $stmt->execute([
                    ':id'             =>  $userID,
                    ':trans_type'     =>  $type,
                    ':type'           =>  $description,
                    ':amount'         =>  $amount,
                    ':status'         =>  $status,
                    ':transaction_id' =>  $transaction_id
                ]);
            } catch (PDOException $e) { echo $e; }
        }


        public function getTransactionByID($transaction_id) {
            $sql = "SELECT * FROM `transactions` WHERE `id` = :transaction_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':transaction_id' => $transaction_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        public function getUserTransactionHistory() {
            $sql = "SELECT * FROM `transactions` WHERE `user_id` = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->user_id
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }


