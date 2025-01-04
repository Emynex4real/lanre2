<?php
    require_once("conn.php");

    // Function to fetch campaigns specific to a user
    function getCampaignsByUser($db, $user_id) {
        try {
            $sql = "SELECT * FROM `campaigns` WHERE `user_id` = :user_id ORDER BY `campaign_id` DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute([":user_id" => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching campaigns for the user: ' . $e->getMessage()];
        }
    }

    // Function to fetch ads for a specific user and campaign
    function getAdsByUserAndCampaign($db, $user_id, $campaign_id) {
        try {
            $sql = "SELECT * FROM `ads` WHERE `user_id` = :user_id AND `campaign_id` = :campaign_id ORDER BY `ad_id` DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute([":user_id" => $user_id, ":campaign_id" => $campaign_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching ads for the user and campaign: ' . $e->getMessage()];
        }
    }

    // Function to fetch clicks for a specific user and ad
    function getClicksByUserAndAd($db, $user_id, $ad_id) {
        try {
            $sql = "SELECT * FROM `clicks` WHERE `user_id` = :user_id AND `ad_id` = :ad_id ORDER BY `click_id` DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute([":user_id" => $user_id, ":ad_id" => $ad_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching clicks for the user and ad: ' . $e->getMessage()];
        }
    }

    // Function to fetch withdrawals specific to a user
    function getWithdrawalsByUser($db, $user_id) {
        try {
            $sql = "SELECT * FROM `withdrawals` WHERE `user_id` = :user_id ORDER BY `withdrawal_id` DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute([":user_id" => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching withdrawals for the user: ' . $e->getMessage()];
        }
    }

    // Function to fetch payments specific to a user
    function getPaymentsByUser($db, $user_id) {
        try {
            $sql = "SELECT * FROM `payments` WHERE `user_id` = :user_id ORDER BY `payment_id` DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute([":user_id" => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching payments for the user: ' . $e->getMessage()];
        }
    }

    // Function to fetch subscriptions specific to a user
    function getSubscriptionsByUser($db, $user_id) {
        try {
            $sql = "SELECT * FROM `subscriptions` WHERE `user_id` = :user_id ORDER BY `subscription_id` DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute([":user_id" => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching subscriptions for the user: ' . $e->getMessage()];
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

    // Function to fetch campaign click stats specific to a user
    function getCampaignClickStatsByUser($db, $user_id) {
        try {
            $sql = "SELECT c.campaign_id, c.name AS campaign_name, COUNT(cl.click_id) AS total_clicks
                    FROM campaigns c
                    LEFT JOIN clicks cl ON c.campaign_id = cl.campaign_id AND cl.user_id = :user_id
                    WHERE c.user_id = :user_id
                    GROUP BY c.campaign_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([":user_id" => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching campaign click stats for the user: ' . $e->getMessage()];
        }
    }

    // Function to update campaign details for a specific user
    function updateCampaign($db, $user_id, $campaign_id, $name, $description, $status) {
        try {
            $sql = "UPDATE `campaigns` SET `name` = :name, `description` = :description, `status` = :status
                    WHERE `user_id` = :user_id AND `campaign_id` = :campaign_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ":name" => $name,
                ":description" => $description,
                ":status" => $status,
                ":user_id" => $user_id,
                ":campaign_id" => $campaign_id
            ]);
            return ['success' => 'Campaign updated successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error updating campaign: ' . $e->getMessage()];
        }
    }

    // Function to delete a campaign for a specific user
    function deleteCampaign($db, $user_id, $campaign_id) {
        try {
            $sql = "DELETE FROM `campaigns` WHERE `user_id` = :user_id AND `campaign_id` = :campaign_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([":user_id" => $user_id, ":campaign_id" => $campaign_id]);
            return ['success' => 'Campaign deleted successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error deleting campaign: ' . $e->getMessage()];
        }
    }

    // Function to update ad details for a specific user and campaign
    function updateAd($db, $user_id, $ad_id, $title, $description, $status) {
        try {
            $sql = "UPDATE `ads` SET `title` = :title, `description` = :description, `status` = :status
                    WHERE `user_id` = :user_id AND `ad_id` = :ad_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ":title" => $title,
                ":description" => $description,
                ":status" => $status,
                ":user_id" => $user_id,
                ":ad_id" => $ad_id
            ]);
            return ['success' => 'Ad updated successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error updating ad: ' . $e->getMessage()];
        }
    }

    // Function to delete an ad for a specific user and campaign
    function deleteAd($db, $user_id, $ad_id) {
        try {
            $sql = "DELETE FROM `ads` WHERE `user_id` = :user_id AND `ad_id` = :ad_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([":user_id" => $user_id, ":ad_id" => $ad_id]);
            return ['success' => 'Ad deleted successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error deleting ad: ' . $e->getMessage()];
        }
    }

    // Function to update click details for a specific user and ad
    function updateClick($db, $user_id, $click_id, $click_date) {
        try {
            $sql = "UPDATE `clicks` SET `click_date` = :click_date WHERE `user_id` = :user_id AND `click_id` = :click_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ":click_date" => $click_date,
                ":user_id" => $user_id,
                ":click_id" => $click_id
            ]);
            return ['success' => 'Click updated successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error updating click: ' . $e->getMessage()];
        }
    }

    // Function to delete a click for a specific user and ad
    function deleteClick($db, $user_id, $click_id) {
        try {
            $sql = "DELETE FROM `clicks` WHERE `user_id` = :user_id AND `click_id` = :click_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([":user_id" => $user_id, ":click_id" => $click_id]);
            return ['success' => 'Click deleted successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error deleting click: ' . $e->getMessage()];
        }
    }

    // Function to update withdrawal details for a specific user
    function updateWithdrawal($db, $user_id, $withdrawal_id, $amount, $status) {
        try {
            $sql = "UPDATE `withdrawals` SET `amount` = :amount, `status` = :status WHERE `user_id` = :user_id AND `withdrawal_id` = :withdrawal_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ":amount" => $amount,
                ":status" => $status,
                ":user_id" => $user_id,
                ":withdrawal_id" => $withdrawal_id
            ]);
            return ['success' => 'Withdrawal updated successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error updating withdrawal: ' . $e->getMessage()];
        }
    }

    // Function to delete a withdrawal for a specific user
    function deleteWithdrawal($db, $user_id, $withdrawal_id) {
        try {
            $sql = "DELETE FROM `withdrawals` WHERE `user_id` = :user_id AND `withdrawal_id` = :withdrawal_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([":user_id" => $user_id, ":withdrawal_id" => $withdrawal_id]);
            return ['success' => 'Withdrawal deleted successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error deleting withdrawal: ' . $e->getMessage()];
        }
    }

    // Function to fetch earnings for a specific user
    function getEarningsByUser($db, $user_id) {
        try {
            $sql = "SELECT SUM(e.amount) AS total_earnings FROM earnings e WHERE e.user_id = :user_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([":user_id" => $user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Error fetching earnings for the user: ' . $e->getMessage()];
        }
    }


    function getUserIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // IP from shared internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // IP passed from a proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            // Direct IP
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
