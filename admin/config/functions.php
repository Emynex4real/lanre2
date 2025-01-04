<?php
    require_once("conn.php");

    // Function to fetch campaigns
    function getCampaigns() {
        global $db;
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
    function getAds($campaign_id = null) {
        global $db;
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
    function getClicks($ad_id = null) {
        global $db;
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
    function getWithdrawals($user_id = null) {
        global $db;
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
    function getPayments($user_id = null) {
        global $db;
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
    function getSubscriptions($user_id = null) {
        global $db;
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
    function getUsers() {
        global $db;
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
    function getCampaignClickStats() {
        global $db;
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

    // Add a new admin
    function addAdmin($username, $password, $email) {
        global $db;
        try {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO `admins` (`username`, `password`, `email`, `status`)
                    VALUES (:username, :password, :email, 'active')";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ":username" => $username,
                ":password" => $hashedPassword,
                ":email" => $email
            ]);
            return ['success' => 'Admin added successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error adding admin: ' . $e->getMessage()];
        }
    }

    // Update admin details (for a specific admin by ID)
    function updateAdmin($admin_id, $username, $email, $status) {
        global $db;
        try {
            $sql = "UPDATE `admins` SET `username` = :username, `email` = :email, `status` = :status
                    WHERE `admin_id` = :admin_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ":username" => $username,
                ":email" => $email,
                ":status" => $status,
                ":admin_id" => $admin_id
            ]);
            return ['success' => 'Admin updated successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error updating admin: ' . $e->getMessage()];
        }
    }

    // Delete an admin by ID
    function deleteAdmin($admin_id) {
        global $db;
        try {
            $sql = "DELETE FROM `admins` WHERE `admin_id` = :admin_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([":admin_id" => $admin_id]);
            return ['success' => 'Admin deleted successfully'];
        } catch (PDOException $e) {
            return ['error' => 'Error deleting admin: ' . $e->getMessage()];
        }
    }

    // Fetch all admins
    function getAdmins() {
        global $db;
        try {
            $sql = "SELECT * FROM `admins`";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $admins;
        } catch (PDOException $e) {
            return ['error' => 'Error fetching admins: ' . $e->getMessage()];
        }
    }

    // Fetch a single admin by ID
    function getAdmin($admin_id) {
        global $db;
        try {
            $sql = "SELECT * FROM `admins` WHERE `admin_id` = :admin_id";
            $stmt = $db->prepare($sql);
            $stmt->execute([":admin_id" => $admin_id]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            return $admin;
        } catch (PDOException $e) {
            return ['error' => 'Error fetching admin: ' . $e->getMessage()];
        }
    }

    // Verify admin credentials (login functionality)
    function verifyAdmin($username, $password) {
        global $db;
        try {
            $sql = "SELECT * FROM `admins` WHERE `username` = :username";
            $stmt = $db->prepare($sql);
            $stmt->execute([":username" => $username]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($password, $admin['password'])) {
                return ['success' => 'Admin login successful'];
            } else {
                return ['error' => 'Invalid username or password'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Error verifying admin: ' . $e->getMessage()];
        }
    }
