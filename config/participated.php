<?php 
    session_start();
    $_SESSION["user_id"];

    if ($user_id) {
        $ad_id = $_POST["ad_id"];
        $cost_per_click = $_POST["cpp"];

        if ($ad_id) {
            require_once("PPC.php");
            $PPC = new PPCClick();
            $result = $PPC->recordClick($ad_id, $user_id, $cost_per_click);

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