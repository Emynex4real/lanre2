<?php
    require_once("conn.php");

    // Function to fetch campaigns
    function getCampaigns($db) {
        try {
            $sql = "SELECT * FROM `campaigns` ORDER BY `campaign_id` DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching campaigns: ' . $e->getMessage()];
        }
    }

    // Function to fetch ads
    function getAds($db, $campaign_id = null) {
        try {
            if ($campaign_id) {
                $sql = "SELECT * FROM `ads` WHERE `campaign_id` = :campaign_id ORDER BY `ad_id` DESC";
                $stmt = $db->prepare($sql);
                $stmt->execute([":campaign_id" => $campaign_id]);
            } else {
                $sql = "SELECT * FROM `ads` ORDER BY `ad_id` DESC";
                $stmt = $db->prepare($sql);
                $stmt->execute();
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching ads: ' . $e->getMessage()];
        }
    }

    // Function to fetch clicks
    function getClicks($db, $ad_id = null) {
        try {
            if ($ad_id) {
                $sql = "SELECT * FROM `clicks` WHERE `ad_id` = :ad_id ORDER BY `click_id` DESC";
                $stmt = $db->prepare($sql);
                $stmt->execute([":ad_id" => $ad_id]);
            } else {
                $sql = "SELECT * FROM `clicks` ORDER BY `click_id` DESC";
                $stmt = $db->prepare($sql);
                $stmt->execute();
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching clicks: ' . $e->getMessage()];
        }
    }

    // Function to fetch withdrawals
    function getWithdrawals($db, $user_id = null) {
        try {
            if ($user_id) {
                $sql = "SELECT * FROM `withdrawals` WHERE `user_id` = :user_id ORDER BY `withdrawal_id` DESC";
                $stmt = $db->prepare($sql);
                $stmt->execute([":user_id" => $user_id]);
            } else {
                $sql = "SELECT * FROM `withdrawals` ORDER BY `withdrawal_id` DESC";
                $stmt = $db->prepare($sql);
                $stmt->execute();
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching withdrawals: ' . $e->getMessage()];
        }
    }

    // Function to fetch payments
    function getPayments($db, $user_id = null) {
        try {
            if ($user_id) {
                $sql = "SELECT * FROM `payments` WHERE `user_id` = :user_id ORDER BY `payment_id` DESC";
                $stmt = $db->prepare($sql);
                $stmt->execute([":user_id" => $user_id]);
            } else {
                $sql = "SELECT * FROM `payments` ORDER BY `payment_id` DESC";
                $stmt = $db->prepare($sql);
                $stmt->execute();
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching payments: ' . $e->getMessage()];
        }
    }

    // Function to fetch subscriptions
    function getSubscriptions($db, $user_id = null) {
        try {
            if ($user_id) {
                $sql = "SELECT * FROM `subscriptions` WHERE `user_id` = :user_id ORDER BY `subscription_id` DESC";
                $stmt = $db->prepare($sql);
                $stmt->execute([":user_id" => $user_id]);
            } else {
                $sql = "SELECT * FROM `subscriptions` ORDER BY `subscription_id` DESC";
                $stmt = $db->prepare($sql);
                $stmt->execute();
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching subscriptions: ' . $e->getMessage()];
        }
    }

    // Function to fetch users
    function getUsers($db) {
        try {
            $sql = "SELECT * FROM `users` ORDER BY `user_id` DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching users: ' . $e->getMessage()];
        }
    }

    // Function to fetch campaign click stats
    function getCampaignClickStats($db) {
        try {
            $sql = "SELECT c.campaign_id, c.name AS campaign_name, COUNT(cl.click_id) AS total_clicks
                    FROM campaigns c
                    LEFT JOIN clicks cl ON c.campaign_id = cl.campaign_id
                    GROUP BY c.campaign_id";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching campaign click stats: ' . $e->getMessage()];
        }
    }

