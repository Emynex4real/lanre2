<?php
    require_once('function.php');

    global $db;
    $payment_id = $_POST["payment_id"];
    $transaction_id = $_POST["transaction_id"];

    try {
        $sql = "UPDATE `withdrawals` SET `status` = :status, `updated_on` = :updated_on WHERE `id` = :payment_id";
        $query = $db->prepare($sql);
        $query->execute(array (
            ':payment_id'      =>   $payment_id,
            ':updated_on'      =>   date('Y-m-d'),
            ':status'          =>   3
        ));

        
        $sql = "SELECT * FROM `withdrawals` WHERE `id` = :payment_id";
        $query = $db->prepare($sql);
        $query->execute(array (
            ':payment_id'      =>   $payment_id,
        ));
        $data = $query->fetch(PDO::FETCH_ASSOC);


        $sql = "UPDATE `transactions` SET `status` = 3 WHERE `transaction_id` = :id";
        $query = $db->prepare($sql);
        $query->execute(array (
            ':id'      =>   $data["transaction_id"]
        ));


        // Update User Balance Table
        returnWithdrawalBalance($data["user_id"], $data["amount"]);

        echo true;


    } catch(PDOException $e) { echo $e; }


?>