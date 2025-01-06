<?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = ["errors" => [], "success" => false];
        require_once("functions.php");
        require_once("PPC.php");
        $tempUser = new PPCUser();

        // Fetch form data
        $email = trim($_POST['email'] ?? '');

        
        // Validate inputs
        if (empty($email)) {
            $response['errors']['email'] = "Email is required.";
        } else {
            $userDetails = $tempUser->checkUserDetail($email);
            $userID = $userDetails["user_id"];
            
            if (!$result) {
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

        // Send response as JSON
        echo json_encode($response);
    }