<?php 
    session_start();
    $user_id = $_SESSION["user_id"];

    if ($user_id) {
        $plan_id = $_plan_id;

        if ($plan_id["plan_id"]) {
            require_once("PPC.php");
            $PPC = new PPCSubscribe();
            $response = $PPC->subscribeNow($user_id, $plan_id);

        } else {
            $response['success'] = false;
            $response['message'] = "Invalid request";
        }

        // Send response as JSON
        echo json_encode($response);
    }