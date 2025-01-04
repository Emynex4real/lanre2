<?php
    require_once('function.php');


    $updateErr = $new_password_Ok = $passwordErr = $updated = $redirect = $confirm_passwordErr = $passwordUpdate ="";
    $email = $_POST['email'];
    $new_password = $_POST['new_passowrd'];
    $confirm_password = $_POST['confirm_passowrd'];

    $user_info = get_admin_user_info($email);
    $old_password = $user_info['password'];
    $user_id = $user_info['id'];
    $username = $user_info['username'];

            // VALIDATE PASSWORD
            if(!empty($new_password)) {
                $contain_number = preg_match('@[0-9]@', $new_password);

                if(strlen($new_password) < 3) {
                    $new_password_Ok = 0;
                    $confirm_passwordErr = check_password($confirm_password);
                    $passwordErr = " Password should be 3 or more characters*";
                } elseif(!($contain_number)) {
                    $new_password_Ok = 0;
                    $confirm_passwordErr = check_password($confirm_password);
                    $passwordErr = " Password should contain at least one number*";
                } else {
                    if (empty($confirm_password)) {
                        $confirm_passwordErr = " Confirm Password is required*";
                        $new_password_Ok = 0;
                    } elseif ($new_password === $confirm_password) {
                        $new_password_Ok = 1;
                    } else {
                        $new_password_Ok = 0;
                        $confirm_passwordErr = " Confirm Password needs to match New Password*";
                    }
                }
            } else {
                $new_password_Ok = 0;
                $passwordErr = " New Password is required*";
                $confirm_passwordErr = check_password($confirm_password);
            }

           
            if ($new_password_Ok == 1) {
                if(password_verify($new_password,$old_password)) {
                    $updated = 0;
                    $passwordErr = " Password cannot be the same as Old password*";
                    $passwordUpdate = "Password has not been changed.";

                } else {
                    $new_password = test_input($new_password);
                    $new_password = password_hash($new_password, PASSWORD_DEFAULT);

                    try {
                        $sql = "UPDATE `admin` SET `password` = '{$new_password}' WHERE `id` = '{$user_id}' LIMIT 1";
                        $query = $db->prepare($sql);
                        if($query->execute()) {
                            $updated = 1;
                            $passwordUpdate = $username . ", your Password has been sucessfully changed.";
                            $redirect = 1;
                        } else {
                            $updated = 0;
                            $passwordUpdate = "Password has not been changed.";
                        }
                    } catch (PDOException $e) {
                        
                    }
                }
            } else {
                $passwordUpdate = "Password has not been changed.";
            }


            echo json_encode(array(
                'updated'       =>      $updated,
                'redirect'      =>      $redirect, 
                'Update_text'   =>      $passwordUpdate,
                'passwordErr'   =>      $passwordErr,
                'c_passwordErr' =>      $confirm_passwordErr
            ))

?>
