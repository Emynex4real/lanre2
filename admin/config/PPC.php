<?php
    require_once("function.php");

    class PPCUser {
        private $db;
        private $user_id;
        private $email;
        private $username;
        private $subscription_status;

        public function __construct() {
            global $db;
            $this->db = $db;
        }

        public function createUser($email, $username, $subscription_status, $password, $referral_code = null) {
            $this->email = $email;
            $this->username = $username;
            $this->subscription_status = $subscription_status;

            $referred_by = null;

            // Check if referral code is provided and valid
            if ($referral_code) {
                $sql = "SELECT `user_id` FROM `users` WHERE `referral_code` = :referral_code";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':referral_code' => $referral_code]);
    
                if ($stmt->rowCount() > 0) {
                    $referred_by = $stmt->fetch(PDO::FETCH_ASSOC)['user_id'];
                }
            }

            $sql = "INSERT INTO `users` (email, username, subscription_status, referral_code, referred_by, password) VALUES (:email, :name, :subscription_status, :referral_code, :referred_by, :password)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':email' => $this->email,
                ':name' => $this->username,
                ':password' => password_hash($password, PASSWORD_DEFAULT),
                ':referral_code' => strtoupper(uniqid()),
                ':referred_by' => $referred_by,
                ':subscription_status' => $this->subscription_status
            ]);
            return $this->db->lastInsertId();
        }

        public function getUserById($user_id) {
            $sql = "SELECT * FROM users WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function updateUserSubscription($user_id, $subscription_status) {
            $sql = "UPDATE `users` SET subscription_status = :subscription_status WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':subscription_status' => $subscription_status,
                ':user_id' => $user_id
            ]);
            return $stmt->rowCount();
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
    
        // Update an existing ad
        public function updateAd($ad_id, $ad_name, $ad_text, $ad_url, $status, $cost_per_click, $max_attempt, $start_date, $end_date) {
            $sql = "UPDATE `ads` SET ad_name = :ad_name, ad_text = :ad_text, status = :status, ad_url = :ad_url, 
                    cost_per_click = :reward, max_attempt = :max_attempt, start_date = :start_date, end_date = :end_date
                    WHERE ad_id = :ad_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':ad_name' => $ad_name,
                ':ad_text' => $ad_text,
                ':status' => $status,
                ':ad_url' => $ad_url,
                ':max_attempt' => $max_attempt,
                ':reward' => $cost_per_click,
                ':start_date' => $start_date,
                ':end_date' => $end_date,
                ':ad_id' => $ad_id
            ]);
            return $stmt->rowCount();
        }
    
        // Delete an ad
        public function deleteAd($ad_id) {
            $sql = "DELETE FROM ads WHERE ad_id = :ad_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':ad_id' => $ad_id]);
            return $stmt->rowCount();
        }
    
        // Get all ads (could be filtered by status, date, etc.)
        public function getAds($filter = []) {
            $sql = "SELECT * FROM ads WHERE 1";
            
            // Apply any filters if provided
            if (isset($filter['status'])) {
                $sql .= " AND status = :status";
            }
            if (isset($filter['start_date'])) {
                $sql .= " AND start_date >= :start_date";
            }
            if (isset($filter['end_date'])) {
                $sql .= " AND end_date <= :end_date";
            }
            
            $stmt = $this->db->prepare($sql);
    
            // Bind filter values
            if (isset($filter['status'])) {
                $stmt->bindParam(':status', $filter['status']);
            }
            if (isset($filter['start_date'])) {
                $stmt->bindParam(':start_date', $filter['start_date']);
            }
            if (isset($filter['end_date'])) {
                $stmt->bindParam(':end_date', $filter['end_date']);
            }
    
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }


    class PPCPlan {
        private $db;
        private $name;
        private $price;
        private $duration;
        private $status;
        private $subscription_id;

        public function __construct() {
            global $db;
            $this->db = $db;
        }

        public function createSubscriptionPlan($name, $price, $status, $duration) {
            $this->name = $name;
            $this->price = $price;
            $this->status = $status;
            $this->duration = $duration;

            $sql = "INSERT INTO `subscriptions` (plan_name, price, duration_months, status) VALUES (:name, :price, :duration, :status)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':name' => $this->name,
                ':price' => $this->price,
                ':duration' => $this->duration,
                ':status' => $this->status
            ]);
            return $this->db->lastInsertId();
        }


        public function updateSubscriptionPlan($name, $price, $status, $duration, $plan_id) {
            $this->name = $name;
            $this->price = $price;
            $this->status = $status;
            $this->duration = $duration;
            $this->subscription_id = $plan_id;

            $sql = "UPDATE `subscriptions` SET `plan_name` = :name, `price` = :price, `duration_months` = :duration, `status` = :status WHERE `subscription_id` = :plan_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':plan_id' => $this->subscription_id,
                ':name' => $this->name,
                ':price' => $this->price,
                ':duration' => $this->duration,
                ':status' => $this->status
            ]);
            return $this->db->lastInsertId();
        }

        

        public function getSubscriptionPlanById($plan_id) {
            $sql = "SELECT * FROM `subscriptions` WHERE `subscription_id` = :plan_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':plan_id' => $plan_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        
        public function deleteAd($plan_id) {
            $sql = "DELETE FROM `subscriptions` WHERE `subscription_id` = :plan_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':plan_id' => $plan_id]);
            return $stmt->rowCount();
        }
    }



