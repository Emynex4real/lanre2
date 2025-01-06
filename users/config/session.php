<?php 
	session_start();
	require_once("functions.php"); 

	if (isset($_SESSION['user'])  && isset($_SESSION['user_id'])) {
		$user = $_SESSION['user'];
		$user_id = $_SESSION['user_id'];
		$logged_time = $_SESSION['last_login_timestamp'];
		$user_info = get_user_info($user);
		
		if (empty($user_info) || ($user_info["user_id"]) != $user_id) {
			session_destroy();
			header("Location: login");

		} elseif ((time() - $_SESSION['last_login_timestamp']) > 10800) {
            session_destroy();
			header("Location: /logged_out");
		} 

        extend_session_validity();

	} else {
		session_destroy();
		header("Location: /login");
	}
?>