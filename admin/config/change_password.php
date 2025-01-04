<?php
    require_once('function.php');
    $old_passwordErr = $updated = $new_passwordErr = "";

    $username = $_POST['username'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $user_info = get_user_info($username);
    $current_password = $user_info["user_password"];
    $user_id = $user_info["id"];

    if (password_verify($old_password, $current_password)) {
        if (password_verify($new_password, $current_password)) {
            $updated = 0;
            $new_passwordErr = "<i class='fa-solid fa-circle-exclamation'></i> Password cannot be the same as Old password";

        } else {
            $new_password = test_input($new_password);
            $new_password = password_hash($new_password, PASSWORD_DEFAULT);

            try {
                $sql = "UPDATE `users` SET `user_password` = :new_password WHERE `id` = :user_id LIMIT 1";
                $query = $db->prepare($sql);
                if($query->execute([
                    ":user_id"          =>  $user_id,
                    ":new_password"     =>  $new_password
                ])) {
                    $updated = 1;
                    
                }

            } catch (PDOException $e) {}
        }
    } else {
        $old_passwordErr = "<i class='fa-solid fa-circle-exclamation'></i> Incorrect Current Password";
    }



    echo json_encode(array(
        'updated'           =>      $updated,
        'old_passwordErr'   =>      $old_passwordErr,
        'new_passwordErr'   =>      $new_passwordErr
    ))
?>
