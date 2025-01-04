<?php
    require_once('function.php');
    $username = $_POST["username"];
    $password = $_POST["password"];

    $usernameErr = $passwordErr = "";

    // VALIDATE USERNAME
    $usernameOk = 1;
    if(!empty($_POST['username'])) {
        // IF USERNAME IS REGISTERED
        $username = $_POST['username'];
        $sql = "SELECT * FROM `users` WHERE `user_name` = '{$username}' or `email_address` = '{$username}' LIMIT 1";
        $query = $db->prepare($sql);
        $query->execute();
        $username_count = $query->rowCount(); 
        if($username_count == 1) {
            $data = $query->fetch(PDO::FETCH_OBJ);
        } 

        if($username_count == 1) {
            $usernameOk = 1;
            $username = $_POST['username'];
        } else {
            $usernameOk = 0;
            $username = "";
            $usernameErr = "<i class='fa-solid fa-circle-exclamation'></i> There is no account with this username or email";
        }
    } else {
        $usernameOk = 0;
        $usernameErr = "<i class='fa-solid fa-circle-exclamation'></i> Username is required";
    }


    // VALIDATE PASSWORD
    $passwordOk = 1;
    if(!empty($_POST['password']) && empty($usernameErr)) {
        $password = $_POST['password'];
        $hashed_password = $data->user_password;

        if (password_verify($password, $hashed_password)) {
            $passwordOk = 1;
        } else {
            $passwordOk = 0;
            $passwordErr = "<i class='fa-solid fa-circle-exclamation'></i> Password is incorrect";
        }
    } else {
        $passwordOk = 0;
        $passwordErr = "<i class='fa-solid fa-circle-exclamation'></i> Password is required";
    }


    if($usernameOk == 1 && $passwordOk == 1) {
        $login = 1;
        $data = get_user_info($username);
        session_start();
        $_SESSION['user'] = $data['user_name'];
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['last_login_timestamp'] = time();
    } else {
        $login = 0;
    }

    echo json_encode(
        array(
            'loginOk'       =>  $login,
            'usernameErr'   =>  $usernameErr,
            'passwordErr'   =>  $passwordErr
        )
    );
?>