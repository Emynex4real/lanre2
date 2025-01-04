<?php
    require_once('function.php');

    $ticket_id = $_POST["ticket_id"];
    $status = $_POST["status"];
    $email = $_POST["email"];
    $reply = $_POST["reply"];

    try {
        $sql = "UPDATE `support` SET `status` = :status, `updated_on` = :updated_on, `reply` = :reply WHERE `id` = :ticket_id";
        $query = $db->prepare($sql);
        $query->execute(array (
            ':ticket_id'       =>    $ticket_id,
            ':updated_on'      =>   date("Y-m-d"),
            ':status'          =>   $status,
            ':reply'           =>   $reply
        ));

        if ($status == 2) {
            echo true;
            require_once("../../phpmailer/send_reply.php");
        } else { echo false; }
        
    } catch(PDOException $e) {echo $e; }
?>