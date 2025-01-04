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

    
    // Update campaign details for a specific user
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
    
    // Delete a campaign for a specific user
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
    
    // Update ad details for a specific user and campaign
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
    
    // Delete an ad for a specific user and campaign
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
    
    // Update click details for a specific user and ad
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
    
    // Delete a click for a specific user and ad
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
    
    // Update withdrawal details for a specific user
    function updateWithdrawal($db, $user_id, $withdrawal_id, $amount, $status) {
        try {
            $sql = "UPDATE `withdrawals` SET `amount` = :amount, `status` = :status
                    WHERE `user_id` = :user_id AND `withdrawal_id` = :withdrawal_id";
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
    
    // Delete a withdrawal for a specific user
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
    
    // Update payment details for a specific user
    function updatePayment($db, $user_id, $payment_id, $amount, $status) {
        try {
            $sql = "UPDATE `payments` SET `amount` = :amount, `status` = :status
                    WHERE `user_id` = :user_id AND `payment_id` = :payment_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ":amount" => $amount,
                ":status" => $status,
                ":user_id" => $user_id,
                ":payment_id" => $payment_id
            ]);
            return ['success' => 'Payment updated successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error updating payment: ' . $e->getMessage()];
        }
    }
    
    // Delete a payment for a specific user
    function deletePayment($db, $user_id, $payment_id) {
        try {
            $sql = "DELETE FROM `payments` WHERE `user_id` = :user_id AND `payment_id` = :payment_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([":user_id" => $user_id, ":payment_id" => $payment_id]);
            return ['success' => 'Payment deleted successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error deleting payment: ' . $e->getMessage()];
        }
    }
    
    // Update subscription details for a specific user
    function updateSubscription($db, $user_id, $subscription_id, $type, $status) {
        try {
            $sql = "UPDATE `subscriptions` SET `type` = :type, `status` = :status
                    WHERE `user_id` = :user_id AND `subscription_id` = :subscription_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ":type" => $type,
                ":status" => $status,
                ":user_id" => $user_id,
                ":subscription_id" => $subscription_id
            ]);
            return ['success' => 'Subscription updated successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error updating subscription: ' . $e->getMessage()];
        }
    }
    
    // Delete a subscription for a specific user
    function deleteSubscription($db, $user_id, $subscription_id) {
        try {
            $sql = "DELETE FROM `subscriptions` WHERE `user_id` = :user_id AND `subscription_id` = :subscription_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([":user_id" => $user_id, ":subscription_id" => $subscription_id]);
            return ['success' => 'Subscription deleted successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error deleting subscription: ' . $e->getMessage()];
        }
    }
        