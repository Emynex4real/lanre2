<?php 
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = [];

        // Fetch form data
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $coupon = trim($_POST['coupon'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $referral_code = trim($_POST['refUsername'] ?? '');

        // Validate inputs
        if (empty($username)) {
            $response['errors']['username'] = "Username is required.";
        }

        if (empty($email)) {
            $response['errors']['email'] = "Email is required.";
        }

        if (empty($password)) {
            $response['errors']['password'] = "Password is required.";
        } else if (strlen($password) < 5) {
            $response['errors']['password'] = "Password cannot be less than 5 character.";
        }

        if (empty($coupon)) {
            $response['errors']['coupon'] = "Coupon is required.";
        } else {
            require_once("PPC.php");
            $user = new PPCUser();
            $result = $user->couponCodeChecker($coupon);

            if (!$result) {
                $response['errors']['coupon'] = "Incorrect Coupon codea";
            } 
        }


        if (empty($response["errors"])) {
            require_once("PPC.php");
            $user = new PPCUser();
            $user->createUser($email, $username, $password, $referral_code);

        } else {
            $response['success'] = false;
            $response['message'] = "Invalid request";
        }

        // Send response as JSON
        echo json_encode($response);
    }