<?php 
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = [];

        // Fetch form data
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Validate inputs
        if (empty($username)) {
            $response['errors']['username'] = "Username is required.";
        }

        if (empty($email)) {
            $response['errors']['email'] = "Email is required.";
        }



        if (!empty($password)) {
            if (strlen($password) < 5) {
                $response['errors']['password'] = "Password cannot be less than 5 characters.";
            }
        }


        // If validation passes
        if (empty($response['errors'])) {
            require_once("PPC.php");
            $user = new PPCUser($user_id);
            $result = $user->updateUserDetails($email, $username,  $password);

            if ($result) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
            }

        } else {
            $response['success'] = false;
        }

        // Send response as JSON
        echo json_encode($response);
    }