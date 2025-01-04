<?php
    require_once("conn.php");

    ini_set('upload_max_filesize', '1000M');
    ini_set('post_max_size', '1000M');
    ini_set('max_input_time', 300);
    ini_set('max_execution_time', 300);

    if (isset($_FILES['file'])) {
        $arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg', 'video/mp3', 'video/mp4'];
        if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
            echo "false";
            return;
        }

        $filename = $_FILES['file']['name'];
        if (move_uploaded_file($_FILES['file']['tmp_name'], '../uploads/courses/videos/'.$filename)) {
            try {
                $sql = "INSERT INTO `videos` (`video_title`) VALUES (:video_title)";
                $query = $db->prepare($sql);
                $query->execute([
                    ':video_title' => $filename,
                ]);
                echo "success";

            } catch (PDOException $e) {}
        }

        die;
    }
?>