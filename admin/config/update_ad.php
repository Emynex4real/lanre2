<?php 
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = [];

        // Fetch form data
        $ad_id = trim($_POST['ad_id']);
        $ad_title = trim($_POST['name'] ?? '');
        $ad_url = trim($_POST['url'] ?? '');
        $ad_description = trim($_POST['description'] ?? '');
        $max_attempts = trim($_POST['max'] ?? '');
        $status = trim($_POST['status'] ?? '');
        $ad_reward = trim($_POST['reward'] ?? '');

        // Validate inputs
        if (empty($ad_title)) {
            $response['errors']['name'] = "Ad title is required.";
        }

        if (empty($ad_description)) {
            $response['errors']['description'] = "Ad description is required.";
        }

        if (empty($ad_url) || !filter_var($ad_url, FILTER_VALIDATE_URL)) {
            $response['errors']['url'] = "A valid ad URL is required.";
        }

        if (empty($status)) {
            $response['errors']['status'] = "Choose ad status.";
        }

        if (empty($ad_reward)) {
            $response['errors']['reward'] = "Cost per click is required.";
        }
        
        if (empty($max_attempts)) {
            $response['errors']['max'] = "Enter max Entry for ad";
        }

        // If validation passes
        if (empty($response['errors'])) {
            require_once("PPC.php");
            $PPC = new PPCAd();
            $result = $PPC->updateAd($ad_id, $ad_title, $ad_description, $ad_url,$status, $ad_reward, $max_attempts);

            if ($result) {
                $response['success'] = true;
                $response['message'] = "Ad created successfully.";
            } else {
                $response['success'] = false;
            }

        } else {
            $response['success'] = false;
        }

        // Send response as JSON
        echo json_encode($response);
    }