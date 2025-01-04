<?php 		
	$page_title = "Create new Subscription";

	session_start();
	require_once("config/function.php"); 

	if(isset($_SESSION['user'])  && isset($_SESSION['user_id']) && $_SESSION['position'] == "admin") {
		$user = $_SESSION['user'];
		$user_id = $_SESSION['user_id'];
		$logged_time = $_SESSION['last_login_timestamp'];
		$user_info = get_admin_user_info($user);
		
		if (empty($user_info) || ($user_info["admin_id"]) != $user_id) {
			session_destroy();
			header("Location: login");

		} elseif ((time() - $_SESSION['last_login_timestamp'] )> 10800) {
			header("Location: /logged_out");
		} 

	} else {
		session_destroy();
		header("Location: /logged_out");
	} 
	
	require_once("layout/admin-header.php"); ?>


	<main id="main" class="main">
		<div class="pagetitle">
			<h1>Create Subscription Plan</h1>
			<nav>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item active"> Create subscription plans</li>
				</ol>
			</nav>
		</div><!-- End Page Title -->

		<section class="section dashboard form">
			<div class="card p-3 mobile-p-1 mobile-mt-m-1">
				<div class="card-body">
					<h5 class="card-title">Create Subscription Plan</h5>

					<div class="alert success mb-3 d-none" id="subscriptionSuccess">
						<p class="alert pl-2">Subscription has been created successfully</p>
					</div>

					<div class="alert danger mb-3 d-none" id="subscriptionFailed">
						<p class="alert pl-2">Please check all inputs</p>
					</div>

					<!-- Vertical Form -->
					<form class="row g-3 m-h-100" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="subscriptionForm">
						<div class="col-12">
							<input type="text" class="form-control shadow-none none" placeholder="Enter Plan Name e.g Welcome Bonus" id="name" name="name">
							<p class="error" id="nameErr"></p>
						</div>
		
						<div class="col-12">
							<input type="number" class="form-control shadow-none none" placeholder="Enter Plan price Url e.g 500" id="price" name="price">
							<p class="error" id="priceErr"></p>
						</div>

						<div class="col-12">
							<input type="number" class="form-control shadow-none" placeholder="Enter Monthly Duration e.g 1" id="duration" name="duration">
							<p id="durationErr" class="error"></p>
						</div>

						<div class="col-12">
							<select class="form-control shadow-none none" name="status" id="status">
								<option value="">Select Subscription status</option>
								<option value="active">Active</option>
								<option value="paused">Paused</option>
								<option value="ended">Ended</option>
							</select>
							<p class="error" id="statusErr"></p>
						</div>

						<div class="mt-0 mt-3 mb-2">
							<button type="submit" class="btn1" name="new_subscription">Create Subscription</button>
						</div>
					</form><!-- Vertical Form -->
				</div>
			</div>
		</section>
	</main><!-- End #main -->

	<script src="assets/js/new_record.js"></script>

	<?php 
	require_once("layout/admin-footer.php");
?>