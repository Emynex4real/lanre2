<?php
        // VALIDATE USERNAME
        $usernameOk = 1;
        if(!empty($_POST['username'])) {
            $username = $_POST['username'];
            $sql = "SELECT * FROM `admin` WHERE `username` = '{$username}'";
            $query = $db->prepare($sql);
            $query->execute();
            $username_count = $query->rowCount(); 

            if(strlen($username) < 5) {
                $usernameOk = 0;
                $usernameErr = "<i class='fa-solid fa-circle-exclamation'></i> Username should be 5 or more characters.*";

            } elseif($username_count > 0) {
                $usernameOk = 0;
                $usernameErr = "<i class='fa-solid fa-circle-exclamation'></i> Username is aready taken*";
            } else {
                $usernameOk = 1;
                $username = test_input($username);
            }
        } else {
            $usernameOk = 0;
            $usernameErr = "<i class='fa-solid fa-circle-exclamation'></i> Username is required*";
        }


        // VALIDATE EMAIL
        $mailOk = 1;
        if(!empty($_POST['email'])) {
            $mail = $_POST["email"];
            if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $mailOk = 0;
                $mailErr = "<i class='fa-solid fa-circle-exclamation'></i> Email format is Incorrect*";
            } else {
                $mailOk = 1;
                $mail = test_input($mail);
            }
        } else {
            $mailOk = 0;
            $mailErr = "<i class='fa-solid fa-circle-exclamation'></i> Please enter your email address*";
        }

        // VALIDATE PASSKEY
        $passkeyOk = 1;
        if(!empty($_POST['passkey'])) {
            $passkey = $_POST["passkey"];
            if($passkey != "1234567") {
                $passkeyOk = 0;
                $passkeyErr = "<i class='fa-solid fa-circle-exclamation'></i> Passkey format is Incorrect*";
            } else {
                $passkeyOk = 1;
                $passkey = test_input($passkey);
            }
        } else {
            $passkeyOk = 0;
            $passkeyErr = "<i class='fa-solid fa-circle-exclamation'></i> Please enter Admin passkey*";
        }


        // VALIDATE PASSWORD
        $passwordOk = 1;
        if(!empty($_POST['password'])) {
            $password = $_POST['password'];
            $contain_number = preg_match('@[0-9]@', $password);

            if(strlen($password) < 3) {
                $passwordOk = 0;
                $passwordErr = "<i class='fa-solid fa-circle-exclamation'></i> Password should be 3 or more characters*";
            } elseif(!($contain_number)) {
                $passwordOk = 0;
                $passwordErr = "<i class='fa-solid fa-circle-exclamation'></i> Password should contain at least one number*";
            } else {
                $passwordOk = 1;
                $password = test_input($password);
                $password = password_hash($password, PASSWORD_DEFAULT);
            }
        } else {
            $passwordOk = 0;
            $passwordErr = "<i class='fa-solid fa-circle-exclamation'></i> Password is required*";
        }

    
        if($usernameOk == 1 && $passkeyOk == 1 && $mailOk == 1 && $passwordOk == 1) {
            try {
                $sql = "INSERT INTO `admin` (`username`, `passkey`, `email`, `password`) VALUES (:username, :passkey, :email, :password)";
                $query = $db->prepare($sql);
                if($query->execute(array(
                    ':username'  =>   $username,
                    ':passkey'    =>   $passkey,
                    ':email'     =>   $mail,
                    ':password'  =>   $password
                ))) {
                    $register = 1;
                    session_start();
                    $data = get_admin_user_info($username);
                    $_SESSION['role'] = 'admin';
                    $_SESSION['user'] = $data['username'];
                    $_SESSION['user_id'] = $data['id'];
                    header("Location: index/registered");
                } else {
                    $e = "<i class='fa-solid fa-circle-exclamation'></i> Could'nt accept data";
                    $register = 0;
                }
            } catch(PDOException $e) {
            }
        } else {
            $register = 0;
        }
?>