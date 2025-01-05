<?php
    require_once("conn.php");
    
    function getUserIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // IP from shared internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // IP passed from a proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            // Direct IP
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    function format_timestamp_Date($date) {   
        $date = explode(" ", $date);
        $date = explode("-", $date[0]);

        // Format Date Day
        if (($date[2] == 1) || ($date[2] == 11) || ($date[2] == 21) || ($date[2] == 31)) {
            $date[2] =  (int) $date[2] . "st";
        } elseif (($date[2] == 2) || ($date[2] == 22)) {
            $date[2] =  (int) $date[2] . "nd";
        } elseif (($date[2] == 3) || $date[2] == 23) {
            $date[2] = (int) $date[2] . "rd";
        }  else {
            $date[2] = (int) $date[2] . "th";
        }

        // Format Month Name
        $monthName   = DateTime::createFromFormat('!m', $date[1]);
        $monthName = $monthName->format('F');

        // COUPLE DATE AND SEND
        $date = $date[2] . " of " . $monthName . ", " . $date[0];
        return $date;
    }

    
    function go_back() {
        echo "<script>history.go(-1)</script>";
    }

    

    function get_transaction_time($date) {
        $time = date("H:i A", strtotime($date));
        return $time;
    }
