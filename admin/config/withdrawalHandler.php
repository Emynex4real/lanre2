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
            ':status'          =>   1
        ));


        
        $sql = "SELECT * FROM `withdrawals` WHERE `id` = :payment_id";
        $query = $db->prepare($sql);
        $query->execute(array (
            ':payment_id'      =>   $payment_id,
        ));
        $data = $query->fetch(PDO::FETCH_ASSOC);


        $sql = "UPDATE `transactions` SET `status` = :status WHERE `transaction_id` = :id";
        $query = $db->prepare($sql);
        $query->execute(array (
            ':id'      =>   $data["transaction_id"],
            ':status'  =>   2
        ));

        echo true;

    } catch(PDOException $e) { echo $e; }
?>