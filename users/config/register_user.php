<?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = [];

        // Fetch form data
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $coupon = trim($_POST['coupon'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $referral_code = trim($_POST['refUsername'] ?? '');
        echo $password;

        require_once("functions.php");
        require_once("PPC.php");
        $user = new PPCUser();

        // Validate inputs
        if (empty($username)) {
            $response['errors']['username'] = "Username is required.";
        } else {
            $usernameUniqueness = $user->checkDataUniqueness("username", $username);
   
            if ($usernameUniqueness > 0) {
                $response['errors']['username'] = "This username has been taken.";
            }
        }

        if (empty($email)) {
            $response['errors']['email'] = "Email is required.";
        } else {
            $emailUniqueness = $user->checkDataUniqueness("email", $email);

            if ($emailUniqueness > 0) {
                $response['errors']['email'] = "There is an account with this email.";
            }
        } 

        if (empty($password)) {
            $response['errors']['password'] = "Password is required.";
        } else if (strlen($password) < 5) {
            $response['errors']['password'] = "Password cannot be less than 5 character.";
        }

        if (empty($coupon)) {
            $response['errors']['coupon'] = "Coupon is required.";
        } else {
            $result = $user->couponCodeChecker($coupon);

            if (!$result) {
                $response['errors']['coupon'] = "Incorrect Coupon code";
            } 
        }


        if (empty($response["errors"])) {
            $new_user = $user->createUser($email, $username, $coupon, $password, $referral_code);

            if ($new_user) {
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