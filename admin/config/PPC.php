<?php
    require_once("function.php");

    class PPCUser {
        private $db;
        private $user_id;
        private $email;
        private $username;

        public function __construct($userID = null) {
            global $db;
            if ($userID) { $user_id = $userID; } else { global $user_id; }

            $this->db = $db;
            $this->user_id = $user_id;
        }

        public function getUserById($userId) {
            $sql = "SELECT * FROM users WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        public function getUserDetails() {
            $sql = "SELECT * FROM users WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $this->user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
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


        public function getAllUsers() {
            $sql = "SELECT * FROM users ORDER BY USER_ID";
            $stmt = $this->db->query($sql);query: 
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        public function updateAd($ad_id, $ad_name, $ad_text, $ad_url, $status, $cost_per_click, $max_attempt) {
            $sql = "UPDATE `ads` SET ad_name = :ad_name, ad_text = :ad_text, status = :status, ad_url = :ad_url, 
                    cost_per_click = :reward, max_attempt = :max_attempt
                    WHERE ad_id = :ad_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':ad_name' => $ad_name,
                ':ad_text' => $ad_text,
                ':status' => $status,
                ':ad_url' => $ad_url,
                ':max_attempt' => $max_attempt,
                ':reward' => $cost_per_click,
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
                ':limit' => $this->purchase_limit,
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
        private $campaign_id;
        private $user_id;
        private $click_time;

        public function __construct() {
            global $db;
            $this->db = $db;
        }

        
        public function recordClick($ad_id, $user_id) {
            $this->user_id = $user_id;
            $this->click_time = date('Y-m-d H:i:s');

            $sql = "INSERT INTO clicks (campaign_id, user_id, click_time) VALUES (:campaign_id, :user_id, :click_time)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':campaign_id' => $this->campaign_id,
                ':user_id' => $this->user_id,
                ':click_time' => $this->click_time
            ]);
            $this->updateUserAdsParticipationHistory();
            return $this->db->lastInsertId();
        }


        public function getClicksByCampaign($campaign_id) {
            $sql = "SELECT * FROM clicks WHERE campaign_id = :campaign_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':campaign_id' => $campaign_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function updateUserAdsParticipationHistory() {
            $sql = "UPDATE `users` SET `ads_history` = :ads_history + 1 WHERE `user_id` = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->user_id
            ]);
            return $stmt->rowCount();
        }
    }


