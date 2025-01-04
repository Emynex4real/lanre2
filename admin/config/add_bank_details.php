<?php
    // CREATE BANK ACCOUNT ROW FOR AFFILIATE USER
    $bank_name = "Not Set";
    $account_name = "Not Set";
    $account_number = "Not Set";

    try {
        $sql = "INSERT INTO `affiliate_account_details` (`user_id`, `user_name`, `bank_name`, `account_name`, `account_number`) VALUES (:user_id, :username, :bank_name, :account_name, :account_number)";
        $query = $db->prepare($sql);
        $query->execute(array (
            ':user_id'                  =>   $user_id,
            ':username'                 =>   $user,
            ':bank_name'                =>   $bank_name,
            ':account_name'             =>   $account_name,
            ':account_number'           =>   $account_number
        ));

    } catch(PDOException $e) {}
?>