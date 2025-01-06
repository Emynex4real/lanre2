<?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = ["errors" => [], "success" => false];
        require_once("functions.php");
        require_once("PPC.php");
        $user = new PPCUser();

        // Fetch form data
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        
        // Validate inputs
        if (empty($username)) {
            $response['errors']['username'] = "Username is required.";
        } else {
            $result = $user->checkUserName($username);
            
            if (!$result) {
                $response['errors']['username'] = "There is no account with this username.";
            }
        }

        if (empty($password)) {
            $response['errors']['password'] = "Password is required.";
        } else if (strlen($password) < 5) {
            $response['errors']['password'] = "Password cannot be less than 5 character.";
        }


        if (empty($response["errors"])) {
            try {
                $userAccount = $user->userLogin( $username, $password);
            } catch (PDOException $e) { echo $e; }
     
            if ($userAccount) {
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