<?php
    require_once("function.php");
    $usernameErr = $emailErr = $post_imageErr = "";

    $current_username = $_POST["cur_username"];
    $user_info = get_user_info($current_username);
    $user_id = $user_info["id"];
    $profile_edit = 0;
    $current_user_image = $user_info["image"];

    $username = $_POST['username'];
    $usernameOk = 1;
    if(!empty($username)) {
        if(strlen($username) < 5) {
            $usernameOk = 0;
            $usernameErr = "<i class='fa-solid fa-circle-exclamation'></i> Username should be 5 or more characters*";
        } else {
            $usernameOk = 1;
            $username = test_input($username);
        }

    } else {
        $usernameOk = 0;
        $usernameErr = "<i class='fa-solid fa-circle-exclamation'></i> Enter new username *";
    }

    // VALIDATE EMAIL
    $email = $_POST['email'];
    $mailOk = 1;
    if(!empty($email)) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mailOk = 0;
            $mailErr = "<i class='fa-solid fa-circle-exclamation'></i> Email format is Incorrect*";
        } else {
            $mailOk = 1;
            $email = test_input($email);
        }
    } else {
        $mailOk = 0;
        $mailErr = "<i class='fa-solid fa-circle-exclamation'></i> Please enter your email address*";
    }


    $uploadOk = 1;
    if (isset($_FILES["file"])) {
        $img = $_FILES["file"]["name"];
        $arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];

        if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
            $uploadOk = 0;
            $post_imageErr = "<i class='fa-solid fa-circle-exclamation'></i> Invalid image format";
        }

    } else {
        $img = "";
        $uploadOk = 1;
        $img = $current_user_image;
        $use_current_user_image = "";
    }


    if ($uploadOk == 1 && $usernameOk == 1 && $mailOk == 1) {
        // CHECK IF USER IS UPLOADING NEW IMAGE OR USING FORMER IMAGE 
        if (!isset($use_current_user_image)) {
			$target_dir = "../uploads/users/";
			$target_file = $target_dir .$img;

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $uploaded = 1;
            } else {
                $uploaded = 0;
            }

        } else {
            $uploaded = 1;
        }

        // UPLOAD IMAGE 
        if ($uploaded == "1") {
            try {
                $sql = "UPDATE `users` SET `user_name` = :username, `email_address` = :email, `image` = :image WHERE `id` = :user_id LIMIT 1";
                $query = $db->prepare($sql);
                if ($query->execute(array(
                    ':username' => $username,
                    ':email' 	=> $email,
                    ':image' 	=> $img,
                    ':user_id' 	=> $user_id
                ))) {
                    $profile_edit = 1;
                }
            } catch (PDOException $e)  {}

        } else {
            $profile_edit = 1;
        }

    } 


    echo json_encode(
        array (
            "username"      =>       $usernameErr,
            "email"         =>       $emailErr,
            "image"         =>       $post_imageErr,
            "profile_edit"  =>       $profile_edit
        )
    );