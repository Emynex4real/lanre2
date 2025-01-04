<?php 
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = [];

        // Fetch form data
        $name = trim($_POST['name'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $duration = trim($_POST['duration'] ?? '');
        $status = trim($_POST['status'] ?? '');

        // Validate inputs
        if (empty($name)) {
            $response['errors']['name'] = "Plan title is required.";
        }

        if (empty($price)) {
            $response['errors']['price'] = "Plan price is required.";
        }

        if (empty($status)) {
            $response['errors']['status'] = "Plan monthly duration is required.";
        }

        if (empty($duration)) {
            $response['errors']['status'] = "Plan status is required.";
        }


        // If validation passes
        if (empty($response['errors'])) {
            require_once("PPC.php");
            $PPC = new PPCPlan();
            $result = $PPC->createSubscriptionPlan($name, $price, $status, $duration);

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