<?php
    require_once("conn.php");

    global $db;
    $action = $_POST["action"];
    $user_id = $_POST["user"];

    // Banning Logic
    if ($action == "ban") {
        $action = "unban";
        $account_status = 2;
        $nextActionText = "Unban User";

    } elseif ($action == "unban") {
        $action = "ban";
        $account_status = 0;
        $nextActionText = "Ban User";
    }

    // Update Database
    try {
        $sql = "UPDATE `users` SET `verification` = '{$account_status}' WHERE `id` = '{$user_id}'";
        $query = $db->query($sql);
    } catch (PDOException $e) { echo $e; }


    echo json_encode(array(
        'action'           =>      $action,
        'innerText'        =>      $nextActionText
    ))
?>
