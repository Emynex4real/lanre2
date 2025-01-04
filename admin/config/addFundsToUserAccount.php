<?php
    require_once("function.php");

    global $db;
    $user_id = $_POST["user"];
    $amount = $_POST["amount"];

    try {
        require_once("./userBalance.php");
        $userBalance = new UserBalance($user_id);
        $userBalance->addDepositBalance($amount);
        $userBalance->newTransaction("+ ₦" . number_format($amount) . " - Deposit", $amount, 2, 2);
        echo 1;

    } catch (PDOException $e) { echo $e; }
?>
