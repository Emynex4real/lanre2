<?php 
    require_once("conn.php");
    $title = $_POST["title"];

    $course_sql = "SELECT * FROM `products` WHERE `title` = :title";
    $course_query = $db->prepare($course_sql);
    if ($course_query->execute([':title' => $title])) {
        $course_count = $course_query->rowCount();
        echo $course_count;
    }
?>