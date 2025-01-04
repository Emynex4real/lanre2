<?php
    try {
        require_once("function.php");

        // VALIDATE USERNAME
        $usernameOk = 1;
        if(!empty($_POST['username'])) {
            // IF USERNAME IS REGISTERED
            $username = $_POST['username'];
            $sql = "SELECT * FROM `admins` WHERE `username` = '{$username}' or `email` = '{$username}' LIMIT 1";
            $query = $db->prepare($sql);
            $query->execute();
            $username_count = $query->rowCount(); 
            $data = "";
            if($username_count == 1) {
                $data = $query->fetch(PDO::FETCH_OBJ);
            } 


            if(($username_count == 1)) {
                $usernameOk = 1;
                $username = test_input($username);
            } else {
                $usernameOk = 0;
                $username = "";
                $usernameErr = " Username/Email is Incorrect*";
            }
        } else {
            $usernameOk = 0;
            $usernameErr = " Username is required*";
        }


        // VALIDATE PASSWORD
        $passwordOk = 1;
        if ($usernameOk == 1) {
            if(!empty($_POST['password'])) {
                $password = $_POST['password'];
                $hashed_password = $data->password;
    
                if(password_verify($password, $hashed_password)) {
                    $passwordOk = 1;
                    $password = test_input($password);

                } else {
                    $passwordOk = 0;
                    $passwordErr = " Password is incorrect*";
                }
            } else {
                $passwordOk = 0;
                $passwordErr = " Password is required*";
            }
        }

    
        if($usernameOk == 1 && $passwordOk == 1) {
            $login = 1;
            $data = get_admin_user_info($username);

            session_start();
            $_SESSION['position'] = $data['position'];
            $_SESSION['user'] = $data['username'];
            $_SESSION['user_id'] = $data['admin_id'];
            $_SESSION['last_login_timestamp'] = time();
            print_r($_SESSION); 
            header("Location: index/logged_in");
 
        } else {
            $login = 0;
            $msgClass = "danger";
            $msg = "Incorrect Account details";
        }
    } catch (PDOException $e) { echo $e; }
?>