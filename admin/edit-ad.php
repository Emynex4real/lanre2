<?php 		
	$page_title = "Update Ads";

	session_start();
	require_once("config/function.php"); 

	if (isset($_SESSION['user'])  && isset($_SESSION['user_id']) && $_SESSION['position'] == "admin") {
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

        if ($_GET["ad_id"]) {
            $ad_id = $_GET["ad_id"];
            require_once("config/PPC.php");
            $PPC = new PPCAd();
            $ad = $PPC->getAdById($ad_id);
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
			<h1>Update Ad</h1>
			<nav>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item active">Update Ad</li>
				</ol>
			</nav>
		</div><!-- End Page Title -->

		<section class="section dashboard form">
			<div class="card p-3 mobile-p-1 mobile-mt-m-1">
				<div class="card-body">
					<h5 class="card-title">Update <?= ucfirst($ad["ad_name"]) ?></h5>

					<div class="alert success mb-3 d-none" id="adSuccess">
						<p class="alert pl-2">Ad has been edited successfully</p>
					</div>

					<div class="alert danger mb-3 d-none" id="adFailed">
						<p class="alert pl-2">Please check all inputs</p>
					</div>

					<!-- Vertical Form -->
					<form class="row g-3 m-h-100" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="adForm">
                        <input type="hidden" id="ad_id" value="<?= $ad["ad_id"] ?>" name="ad_id">

						<div class="col-12">
                            <label for="reward">Ad Title:</label>
							<input type="text" class="form-control shadow-none none" placeholder="Enter Ad title e.g Welcome Bonus" value="<?= ucfirst($ad["ad_name"]) ?>" id="name" name="name">
							<p class="error" id="nameErr"></p>
						</div>
		
						<div class="col-12">
                            <label for="reward">Ad Url:</label>
							<input type="url" class="form-control shadow-none none" placeholder="Enter Ads Url e.g https://emine.com.ng" value="<?= ucfirst($ad["ad_url"]) ?>" id="url" name="url">
							<p class="error" id="urlErr"></p>
						</div>

						<div class="col-12">
                            <label for="reward">Maximum Ad Participation:</label>
							<input type="number" class="form-control shadow-none" placeholder="Enter Maximum Ads view" id="max" name="max"value="<?= $ad["max_attempt"] ?>">
							<p id="maxErr" class="error"></p>
						</div>

						<div class="col-12"> 
                            <label for="reward">Ad Reward Per Click:</label>
							<input type="number" class="form-control shadow-none none" placeholder="Reward per Click" id="reward" name="reward" value="<?= $ad["cost_per_click"] ?>">
							<p class="error" id="rewardErr"></p>
						</div>

						<div class="col-12">
                            <label for="description">Ad Description:</label>
							<textarea class="form-control shadow-none none" placeholder="Enter a description of the Ads" id="description" name="description"><?= ucfirst($ad["ad_text"]) ?></textarea>
							<p class="error" id="descriptionErr"></p>
						</div>

						<div class="col-12">
                            <label for="status">Status:</label>
							<select class="form-control shadow-none none" name="status" id="status">
								<option value="">Select Ads status</option>
								<option value="active" <?= ($ad["status"] == "active") ? "selected" : "" ?>>Active</option>
								<option value="paused" <?= ($ad["status"] == "paused") ? "selected" : "" ?>>Paused</option>
								<option value="ended" <?= ($ad["status"] == "ended") ? "selected" : "" ?>>Ended</option>
							</select>
							<p class="error" id="statusErr"></p>
						</div>

						<div class="mt-0 mt-3 mb-2">
							<button type="submit" class="btn1" id="add-coupon" name="add_coupon">Update ad</button>
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