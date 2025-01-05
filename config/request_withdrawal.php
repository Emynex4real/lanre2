<?php 
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = [];

        // Fetch form data
        $bankName = trim($_POST['bankName'] ?? '');
        $acctNumber = trim($_POST['acctNumber'] ?? '');
        $acctName = trim($_POST['acctName'] ?? '');

        // Validate inputs
        if (empty($bankName)) {
            $response['errors']['bankName'] = "Bank Name is required.";
        }

        if (empty($acctNumber)) {
            $response['errors']['acctNumber'] = "Account number is required.";
        }

        if (empty($acctName)) {
            $response['errors']['acctName'] = "Account name is required.";
        }

        if (empty($amount)) {
            $response['errors']['amount'] = "Amount is required.";
        } elseif ((int) $amount < 5000.00) {
            $response['errors']['amount'] = "Minimum withdrawal is ₦5000.00";
        } else {
            require_once("PPC.php");
            $user = new PPCUser( 1);
            $result = $user->checkBalanceSufficiencyForWithdrawal($amount);

            if (!$result) {
                $response['errors']['amount'] = "Insufficient income balance";
            } 
        }


        // If validation passes
        if (empty($response['errors'])) {
            $result = $user->createWithdrawalRequest($email,  $acctNumber, $bankName, $acctName);

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