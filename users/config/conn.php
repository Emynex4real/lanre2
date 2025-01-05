<?php
    $host = 'localhost';  
    $dbname = 'emine';  // Your DB Name
    $db_username = 'root';  
    $db_password = '';  

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $db_username, $db_password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }