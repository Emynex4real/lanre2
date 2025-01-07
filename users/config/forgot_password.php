<?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = ["errors" => [], "success" => false];
        require_once("functions.php");
        require_once("PPC.php");
        
        // Send Reset Link
        if (isset($_POST['email'])) {
            $tempUser = new PPCUser();

            // Fetch form data
            $email = trim($_POST['email'] ?? '');
            
            // Validate inputs
            if (empty($email)) {
                $response['errors']['email'] = "Email is required.";
            } else {
                $userDetails = $tempUser->checkUserDetail($email);
                
                if ($userDetails) {
                    $userID = $userDetails["user_id"];
                } else {
                    $response['errors']['email'] = "There is no account with this email address.";
                }
            }


            if (empty($response["errors"])) {
                $user = new PPCUser($userID);
                $resendLinkSent = $user->sendResetLink($email);
        
                if ($resendLinkSent) {
                    $response['success'] = true;
                } else {
                    $response['errors']['password'] = "Incorrect password for this account.";
                    $response['success'] = false;
                }

            } else {
                $response['success'] = false;
                $response['message'] = "Invalid request";
            }

        
        // Reset User Password
        } elseif (isset($_POST['password'])) {
            // Fetch form data
            $userID = trim($_POST['user_id'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $cpassword = trim($_POST['cpassword'] ?? '');

            
            // Validate inputs
            if (empty($password)) {
                $response['errors']['password'] = "Enter new password.";
            } elseif (strlen($password) < 5) {
                $response['errors']['password'] = "Password cannot be less than 5 characters.";
            } else {
                if (empty($cpassword)) {
                    $response['errors']['cpassword'] = "Re-enter the password.";
                } elseif ($password != $cpassword) {
                    $response['errors']['cpassword'] = "Confirm password does not match password.";
                }
            }


            if (empty($response["errors"])) {
                $user = new PPCUser($userID);
                $resendLinkSent = $user->updateUserPassword($password);
        
                if ($resendLinkSent) {
                    $response['success'] = true;
                } else {
                    $response['errors']['password'] = "Opps, Somwthing went wrong.";
                    $response['success'] = false;
                }

            } else {
                $response['success'] = false;
                $response['message'] = "Invalid request";
            }

        }


        // Send response as JSON
        echo json_encode($response);
    }