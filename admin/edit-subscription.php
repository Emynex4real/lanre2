<?php 		
	$page_title = "Update Subscription Plan";

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

        if ($_GET["plan_id"]) {
            $plan_id = $_GET["plan_id"];
            require_once("config/PPC.php");
            $PPC = new PPCPlan();
            $plan = $PPC->getSubscriptionPlanById($plan_id);
        } else {
            go_back();
        }

	} else {
		session_destroy();
		header("Location: /logged_out");
	} 
	
	require_once("layout/admin-header.php"); ?>


	<main id="main" class="main">
		<div class="pagetitle">
			<h1>Update <?= ucfirst($plan["plan_name"]) ?></h1>
			<nav>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item active"> Update <?= ucfirst($plan["plan_name"]) ?></li>
				</ol>
			</nav>
		</div><!-- End Page Title -->

		<section class="section dashboard form">
			<div class="card p-3 mobile-p-1 mobile-mt-m-1">
				<div class="card-body">
					<h5 class="card-title">Update subscription Plan</h5>

					<div class="alert success mb-3 d-none" id="subscriptionSuccess">
						<p class="alert pl-2">Subscription Plan has been created successfully</p>
					</div>

					<div class="alert danger mb-3 d-none" id="subscriptionFailed">
						<p class="alert pl-2">Please check all inputs</p>
					</div>

					<!-- Vertical Form -->
					<form class="row g-3 m-h-100" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="subscriptionForm">
						<input type="hidden" id="plan_id" value="<?= $plan["subscription_id"] ?>" name="plan_id">

						<div class="col-12">
                            <label for="name">Plan Name</label>
							<input type="text" class="form-control shadow-none none" value="<?= $plan["plan_name"] ?>" placeholder="Enter Plan Name e.g Welcome Bonus" id="name" name="name">
							<p class="error" id="nameErr"></p>
						</div>
		
						<div class="col-12">
							<label for="duration">Plan Price:</label>
							<input type="number" class="form-control shadow-none none" placeholder="Enter Plan price Url e.g 500" value="<?= ucfirst($plan["price"]) ?>" id="price" name="price">
							<p class="error" id="priceErr"></p>
						</div>

						<div class="col-12">
							<label for="duration">Plan Daily Income:</label>
							<input type="number" class="form-control shadow-none none" placeholder="Enter daily income e.g 50" id="daily_income" name="daily_income">
							<p class="error" id="daily_incomeErr"></p>
						</div>

						<div class="col-12">
							<label for="duration">Monthly Duration:</label>
							<input type="number" class="form-control shadow-none" placeholder="Enter Monthly Duration e.g 1" id="duration" value="<?= ucfirst($plan["duration_months"]) ?>" name="duration">
							<p id="durationErr" class="error"></p>
						</div>

						<div class="col-12">
							<label for="duration">Purchase Limit:</label>
							<input type="number" class="form-control shadow-none none" placeholder="Enter plan purchase limit e.g 2" id="purchase_limit" name="purchase_limit">
							<p class="error" id="purchase_limitErr"></p>
						</div>

						<div class="col-12">
							<label for="status">Plan Status</label>
							<select class="form-control shadow-none none" name="status" id="status">
								<option value="">Select Plan status</option>
								<option value="active" <?= ucfirst($plan["plan_name"] == "active") ? "selected" : ""; ?>>Active</option>
								<option value="inactive" <?= ucfirst($plan["plan_name"] == "inactive") ? "selected" : ""; ?>>Inactive</option>
							</select>
							<p class="error" id="statusErr"></p>
						</div>

						<div class="mt-0 mt-3 mb-2">
							<button type="submit" class="btn1" name="new_subscription">Update Plan</button>
						</div>
					</form><!-- Vertical Form -->
				</div>
			</div>
		</section>
	</main><!-- End #main -->

	<script src="assets/js/update_record.js"></script>

	<?php 
	require_once("layout/admin-footer.php");
?>