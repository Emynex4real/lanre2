<?php
    require_once('conn.php');

    // GET USER INFO
    function get_user_info($email) {
        global $db;
        $sql = "SELECT * FROM `users` WHERE `email` = '{$email}' LIMIT 1";
        $query = $db->prepare($sql);
        $query->execute();
        $email_count = $query->rowCount(); 

        // CHECK IF USER EXISTS
        if($email_count == 1) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
            return $data;
        }
    }



    function get_user_info_by_referral_code($referral_code) {
        global $db;
        $sql = "SELECT * FROM `users` WHERE `referral_code` = '{$referral_code}' LIMIT 1";
        $query = $db->prepare($sql);
        $query->execute();
        $email_count = $query->rowCount(); 

        // CHECK IF USER EXISTS
        if($email_count == 1) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
            return $data;
        }

        return array();
    }




    function get_user_info_by_id($id) {
        global $db;
        $sql = "SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1";
        $query = $db->prepare($sql);
        $query->execute();
        $email_count = $query->rowCount(); 

        // CHECK IF USER EXISTS
        if($email_count == 1) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
            return $data;
        }
    }



    function get_admin_user_info($username) {
        // GET USER INFO BY EMAIL
        global $db; $data = "";
        $sql = "SELECT * FROM `admins` WHERE `username` = '{$username}' or `email` = '{$username}'";
        $query = $db->query($sql);
        $email_count = $query->rowCount(); 

        // CHECK IF USER EXISTS
        if($email_count == 1) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
            return $data;
        }
        return $data;
    }



    function check_password($confirm_password) {
        if (empty($confirm_password)) {
            $confirm_passwordErr = "Confirm Password is required *";
        } else {
            $confirm_passwordErr = "";
        }
        return $confirm_passwordErr;
    }

    

    // REMOVE TIMESTAMP FORMAT
    function edit_time($time) {
        $time = substr($time, 0, 5);
        return $time;
    }



    // COUNT SUBSCRIPTION DATE
    function get_subscription_deadline($date, $format) {
        $date = date('d-m-Y', strtotime('+30 days', strtotime($date))) . PHP_EOL;

        if ($format == 1) { 
            return format_Date($date);
        } else {
            return $date;
        }
    }



    // Function to find the difference 
    // between two dates. 
    function dateDiffInDays($date1, $date2) { 
        // Calculating the difference in timestamps 
        $diff = strtotime($date2) - strtotime($date1); 

        // 24 * 60 * 60 = 86400 seconds 
        return abs(round($diff / 86400)); 
    } 



    // FORMAT DATE
    function format_Date($date) {  
        $date = explode(" ", $date);
        $time  = explode(":", $date[1]);

        // Format Time
        if ($time[0] < 12) {
            $hour = $time[0] - 12;
            $time = $hour . ":" . $time[1] . "pm";
        } else {
            $time = $time[0] . ":" . $time[1] . "am";
        }


        $date = explode("-", $date[0]);

        // Format Date Day
        if (($date[2] == 1) || ($date[2] == 11) || ($date[2] == 21) || ($date[2] == 31)) {
            $date[2] =  (int) $date[2] . "st";
        } elseif (($date[2] == 2) || ($date[2] == 22)) {
            $date[2] =  (int) $date[2] . "nd";
        } elseif (($date[2] == 3) || $date[2] == 23) {
            $date[2] = (int) $date[2] . "rd";
        }  else {
            $date[2] = (int) $date[2] . "th";
        }

        // Format Month Name
        $monthName   = DateTime::createFromFormat('!m', $date[1]);
        $monthName = $monthName->format('F');

        // COUPLE DATE AND SEND
        $date =  $date[2] . " of " . $monthName . ", ". $date[0] . " by " . substr($time, 1);
        return $date;
    }



    // TEST INPUT
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }



    function active($currect_page) {
        $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
        $url = end($url_array);
        // $url = substr($url, 0, -4);
       
        if ($currect_page == $url){
            echo 'active';  
        } 
    }



    function comment_count($id) {
        global $db;
        $sql = "SELECT * FROM `comments` WHERE `post_id` = '{$id}'";
        $query = $db->prepare($sql);
        $query->execute();
        $comment_count = $query->rowCount(); 
        return $comment_count;
    }



    function get_course_info($title) {
        global $db;
        $course_sql = "SELECT * FROM `courses` WHERE `title` = :title LIMIT 1";
        $course_query = $db->prepare($course_sql);
        if ($course_query->execute(["title" => $title])) {
            $course_data = $course_query->fetch(PDO::FETCH_ASSOC);
            return $course_data;
        }
    }



    function get_course_info_by_id($id) {
        global $db;
        $course_sql = "SELECT * FROM `courses` WHERE `id` = " . $id . " LIMIT 1";
        $course_query = $db->query($course_sql);
        if ($course_query->execute()) {
            $course_data = $course_query->fetch(PDO::FETCH_ASSOC);
            return $course_data;
        }
    }



    function videoType($url) {
        if (strpos($url, 'iframe') > 0) {
            return 1;

        } else {
            return 0;
        }
    }



    function validate_user_email_address($email) {
        global $db;
        $referral_sql = "SELECT email_address FROM users WHERE email_address = :email";
        $referral_query = $db->prepare($referral_sql);
        $referral_query->execute([":email" => $email]);

        if($referral_query->rowCount() == 1) {
            $email_validity = 1;
        } else {
            $email_validity = 0;
        }

        return $email_validity;
    }



    function validate_affiliate_email_address($email) {
        global $db;
        $referral_sql = "SELECT * FROM affiliates WHERE referred_user_email = :email";
        $referral_query = $db->prepare($referral_sql);
        $referral_query->execute([":email" => $email]);
        $referral_detail = $referral_query->fetch(PDO::FETCH_ASSOC);

        if ($referral_query->rowCount() == 1) {
            $email_validity = 1;
        } else {
            $email_validity = 0;
        }

        $referral_detail["validity"] = $email_validity;
        return $referral_detail;
    }


    function get_row_count($table) {
        try {
            global $db;
            $sql = "SELECT * FROM {$table}";
            $query = $db->prepare($sql);
            $query->execute();
            return $query->rowCount(); 
        } catch (PDOException $e) {}
    }


    function get_account_details($user_id) {
        try {
            global $db;
            $sql = "SELECT * FROM `account_details` WHERE `user_id` = :id";
            $query = $db->prepare($sql);
            $query->execute([  ":id"  =>  $user_id  ]);
            return $query->fetch(PDO::FETCH_ASSOC); 

        } catch (PDOException $e) { }
    }



    function check_affiliate_user_unpaid_payout_order($username) {
        try {
            global $db;
            $sql = "SELECT * FROM `affiliate_paidout` WHERE `user_name` = :username AND `payment` = :payment";
            $query = $db->prepare($sql);
            $query->execute([  ":username"  =>  $username,  ":payment"  =>  0  ]);
            return $query->rowCount(); 

        } catch (PDOException $e) {}
    }


    
    function check_affiliate_membership_status($referral_code) {
        global $db;

        if (!empty($referral_code)) {
            try {
                // GET USER AFFILIATE ORDER DETAILS
                $affiliate_sql = "SELECT * FROM  `affiliates` WHERE affiliate_code_id = :code AND `status` = :status";
                $affiliate_query = $db->prepare($affiliate_sql);
                $affiliate_query->execute([ ":code"     =>  $referral_code,
                                            ":status"   =>  "Paid"]);
                return $affiliate_query->rowCount();
                
            } catch (PDOException $e) {}
            
        } return 0;
    }



    function update_user_refferals($code) {
        global $db;
        $affiliate_sql = "INSERT INTO `affiliates` (affiliate_code_id, created_on, amount_to_be_paid, status) VALUES (:affiliate_code, :created_on, :amount, :status)";
        $affiliate_query = $db->prepare($affiliate_sql);
        $affiliate_query->execute([
            ":affiliate_code"   =>  $code,
            ":created_on"       =>  date("Y, m d"),
            ":amount"           =>  0,
            ":status"           =>  "Unpaid"
        ]);
    }



    // GET USER REFERRAL DETAILS
    function user_referral_details($email) {
        global $db;
        $affiliate_sql = "SELECT * FROM `affiliates` WHERE `referred_user_email` = :email";
        $affiliate_query = $db->prepare($affiliate_sql);
        $affiliate_query->execute([":email" => $email]);

        if ($affiliate_query->rowCount() > 0) {
            $affiliate_members_details = $affiliate_query->fetch(PDO::FETCH_ASSOC);
            return $affiliate_members_details;
        } else {
            return "";
        }
    }



    function check_referral_code_validity($code) {
        global $db;
        $referral_sql = "SELECT * FROM `users` WHERE `referral_code` = :code";
        $referral_query = $db->prepare($referral_sql);
        $referral_query->execute([":code" => $code]);

        if ($referral_query->rowCount() > 0) {
            return false;

        } else {
            return true;
        }
    }



    function check_renewal_order($user_id) {
        global $db;
        $renewal_sql = "SELECT * FROM `renewal` WHERE `user_id` = :user_id AND `status` = :status";
        $renewal_query = $db->prepare($renewal_sql);
        $renewal_query->execute([
            ":user_id"  =>   $user_id,
            ":status"   =>   "Unpaid"
        ]);
        $renewal_details = $renewal_query->fetch(PDO::FETCH_ASSOC);
        $renewal_details["count"] = $renewal_query->rowCount();
        return $renewal_details;
    } 


    
    function get_transaction_id($user_id, $order_date) {
        global $db;
        $affiliate_sql = "SELECT `transaction_id` FROM  `receipt` WHERE `user_id` = :user_id AND `payment_date` = :date AND (`payment_title` = :referral OR `payment_title` = :renewal) LIMIT 1";
        $affiliate_query = $db->prepare($affiliate_sql);
        $affiliate_query->execute([
            ":user_id" 	    =>  $user_id,
            ":date" 	    =>  $order_date,
            ":referral" 	=>  "Registered",
            ":renewal" 	    =>  "Renewed"
        ]);
        $order_transaction_id = $affiliate_query->fetch(PDO::FETCH_ASSOC)["transaction_id"]; 
        return $order_transaction_id;
    }


    
    function number_of_active_users() {
        global $db;
        $sql = "SELECT * FROM `users` WHERE `verification` = 1";
        $query = $db->prepare($sql);
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        $number_of_active_users = 0;

        foreach ($users as $user) {
            if (check_if_user_has_ever_invested($user["id"]) > 0) {
                $number_of_active_users += 1;
            }
        }

        return $query->rowCount(); 
    }


    function number_of_inactive_users() {
        global $db;
        $sql = "SELECT * FROM `users` WHERE `verification` = 0";
        $query = $db->prepare($sql);
        $query->execute();
        return $query->rowCount(); 
    }

    function get_total_deposit_amount() {
        global $db;
        $sql = "SELECT SUM(total_deposit) AS total_deposit FROM `user_balance`";
        $query = $db->query($sql);
        return $query->fetch(PDO::FETCH_ASSOC)["total_deposit"]; 
    }


    function get_user_balances($user_id) {
        global $db;
        $sql = "SELECT * FROM `user_balance` WHERE `user_id` = '{$user_id}'";
        $query = $db->query($sql);
        return $query->fetch(PDO::FETCH_ASSOC); 
    }


    function get_user_team_size($referral_code) {
        global $db;
        $sql = "SELECT * FROM `teams` WHERE `team_code` = '{$referral_code}'";
        $query = $db->query($sql);
        return $query->fetch(PDO::FETCH_ASSOC)["size"]; 
    }


    function get_user_valid_team_size($user_id) {
        global $db; 
        $sql = "SELECT COUNT(*) AS record_count
                FROM referrals
                WHERE team_income > 0 AND referred_by = :referral;
        ";
        $query = $db->prepare($sql);
        $query->execute(array (
            ':referral'  =>  $user_id,
        ));
        return $query->fetch(PDO::FETCH_ASSOC)["record_count"];
    }

    
    function get_another_user_investments($userID) {
        global $db;
        $sql = "SELECT * FROM `investments` WHERE `user_id` = :user_id";
        $query = $db->prepare($sql);
        $query->execute(array (
            ':user_id'      =>   $userID
        ));
        return $query->fetchAll();
    }


    function amountMadeThroughTeamIncome($user_id) {
        global $db;
        $sql = "SELECT SUM(team_income) AS total_earned
                FROM referrals
                WHERE referred_by = :user_id
        ";
        $query = $db->prepare($sql);
        $query->execute([
            ":user_id" => $user_id
        ]);
        return $query->fetch(PDO::FETCH_ASSOC)["total_earned"];
    }



    function entitledWeeklySalary($user) {
        global $db;
        $user_id = $user["id"];

        // Prepare the SQL statement to get the number of people the user has referred in the past week
        $stmt = $db->prepare("
            SELECT COUNT(*) as invite_count 
            FROM referrals 
            WHERE referred_by = :userId
            AND level = 1 AND team_income > 0
            AND created_on >= CURDATE() - INTERVAL WEEKDAY(CURDATE()) DAY
        ");
        $stmt->execute([':userId' => $user_id]);
        $user_referrals_last_week = $stmt->fetch(PDO::FETCH_ASSOC);
        $referral_count = $user_referrals_last_week["invite_count"];
        $bonusAmount = 0;

        if ($referral_count >= 20) {
            $bonusAmount = 8000;

        } elseif ($referral_count >= 10) {
            $bonusAmount = 4000;

        }  elseif ($referral_count >= 5) {
            $bonusAmount = 2000;

        }  elseif ($referral_count >= 3) {
            $bonusAmount = 1000;
        } 

        return $bonusAmount;
    }


    function total_user_level1_that_have_deposited($user) {
        global $db;
        $user_id = $user["id"];

        // Prepare the SQL statement to get the number of people the user has referred in the past week
        $stmt = $db->prepare("
            SELECT COUNT(*) as invite_count 
            FROM referrals 
            WHERE referred_by = :userId
            AND level = 1 AND team_income > 0
        ");
        $stmt->execute([':userId' => $user_id]);
        $user_referrals_last_week = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user_referrals_last_week["invite_count"];
    }


    
    function checkUserTeamTotalInvestment($referral_code) {
        global $db; 

        // Prepare the SQL statement to get the number of people the user has referred in the past week
        $stmt = $db->prepare("SELECT * FROM `team_members` WHERE `team_code` = :code");
        $stmt->execute([':code' => $referral_code]);
        $inviteCount = $stmt->rowCount();

        if ($inviteCount > 0) {
            $team_members = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $total_user_team_income = 0.00;

            foreach($team_members as $member) {
                $total_user_investment = get_total_user_investments($member["member_id"]);
                $total_user_team_income += $total_user_investment;
            }

            return $total_user_team_income;
        }
    }


    function get_product_details_by_id($product_id) {
        global $db;
        $sql = "SELECT * FROM `products` WHERE id = '{$product_id}'";
        $query = $db->query($sql);
        $query->execute();

        if ($query->rowCount() == 1) {
            $product_details = $query->fetch(PDO::FETCH_ASSOC);
            $product_details["count"] = 1;
        } else {
            $product_details = array();
            $product_details["count"] = 0;
        }

        return $product_details;
    }


    function get_total_user_investments($userID) {
        $user_investments = get_another_user_investments($userID);
        $total_user_investment = 0;
        
        foreach($user_investments as $investment) {
            $investment_price = get_product_details_by_id($investment["product_id"])["price"];
            $total_user_investment += $investment_price;
        }

        return $total_user_investment;
    }


    function check_if_user_has_ever_invested($user_id) {
        global $db; 
            
        $stmt = $db->prepare("SELECT COUNT(*) AS investment_count FROM `investments` WHERE `user_id` = :id");
        $stmt->execute([
            ':id'         =>  $user_id,
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC)["investment_count"];
    }


    function addWithdrawalBalance($user_id, $amount) {
        global $db; (float) $amount;

        try {
            $stmt = $db->prepare("UPDATE `user_balance` SET total_withdraw = total_withdraw + :amount WHERE `user_id` = :id");
            $stmt->execute([
                ':id' => $user_id,
                ':amount' => $amount
            ]);
        } catch (PDOException $e) { echo $e; }
    }

    
    
    function returnWithdrawalBalance($user_id, $amount) {
        global $db; (float) $amount;

        try {
            $stmt = $db->prepare("UPDATE `user_balance` SET total_withdraw = total_withdraw - :amount AND income_balance = income_balance + :amount WHERE `user_id` = :id");
            $stmt->execute([
                ':id' => $user_id,
                ':amount' => $amount
            ]);
        } catch (PDOException $e) { echo $e; }
    }


    function get_total_withdrawal_amount() {
        global $db;
        $sql = "SELECT SUM(amount) AS total_withdraw FROM `withdrawals` WHERE `status` = 1";
        $query = $db->query($sql);
        return $query->fetch(PDO::FETCH_ASSOC)["total_withdraw"]; 
    }
?>
