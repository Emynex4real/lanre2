<?php
    require_once('function.php');
    require_once('userBalance.php');

    global $db;
    $deposit_id = $_POST["deposit"];

    try {
        $sql = "SELECT * FROM `transactions` WHERE `id` = :deposit_id";
        $query = $db->prepare($sql);
        $query->execute(array (
            ':deposit_id'      =>   $deposit_id,
        ));
        $deposit_details = $query->fetch(PDO::FETCH_ASSOC);

        $user = new UserBalance($deposit_details["user_id"]);
        $user->addDepositBalance($deposit_details["amount"]);
        $user->updateTransaction($deposit_id);
        echo true;

    } catch(PDOException $e) {
        echo false;
    }
    
    
?>