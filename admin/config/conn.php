<?php
    $host = "localhost";
    // $dbname = "techniqu_techniquesconsult";
    // $username = "techniqu_techniquesconsult";
    // $password = "techniqu_techniquesconsult@2024";
    $dbname = "emine";
    $username = "root";
    $password = "";

    try {
        $db = new PDO("mysql:host=$host; dbname=$dbname", $username, $password); 
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //  echo "DATABASE SUCESSFULLY CONNECTED";

    } catch (PDOException $e) { }
?>