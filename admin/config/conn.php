<?php
    $host = "localhost";
    $dbname = "emine";
    $username = "root";
    $password = "";

    try {
        $db = new PDO("mysql:host=$host; dbname=$dbname", $username, $password); 
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //  echo "DATABASE SUCESSFULLY CONNECTED";

    } catch (PDOException $e) { }
?>