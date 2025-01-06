<?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = [];

        // Fetch form data
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        
        // Validate inputs
        if (empty($username)) {
            $response['errors']['username'] = "Username is required.";
        }

        if (empty($password)) {
            $response['errors']['password'] = "Password is required.";
        } else if (strlen($password) < 5) {
            $response['errors']['password'] = "Password cannot be less than 5 character.";
        }


        if (empty($response["errors"])) {
            require_once("functions.php");
            require_once("PPC.php");
            $user = new PPCUser();
            $userAccount = $user->userLogin($username, $password);

            if ($userAccount ) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
            }

        } else {
            $response['success'] = false;
            $response['message'] = "Invalid request";
        }

        // Send response as JSON
        echo json_encode($response);
    }