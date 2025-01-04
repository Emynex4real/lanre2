<?php
    require_once('function.php');
    require_once('userBalance.php');

    global $db;
    $deposit_id = $_POST["deposit"];

    try {
        global $db;
        $sql = "UPDATE `transactions` SET `status` = :status WHERE `id` = :deposit_id";
        $query = $db->prepare($sql);
        $query->execute(array (
            ':deposit_id'      =>   $deposit_id,
            ':status'          =>   3,
        ));

        echo true;

    } catch(PDOException $e) {
        echo false;
    }
    
    
?>