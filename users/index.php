<?php 
	$page__css = '
		<link rel="stylesheet" href="css/project.css" />
		<link rel="stylesheet" href="css/navbar.css" />
	';
	require_once("config/session.php");
	$page__title = "Welcome";

	try {
		global $db;
		require_once("config/session.php");
		require_once("config/PPC.php");
		$user = new PPCUser($user_id);
		$user_details = $user->getUserDetails();
		$referral_details = $user->getUserReferralDetails();

	} catch (PDOException $e) {}

	require_once("layout/user-header.php"); ?>

		<main>
			<div class="dashboard-panel">
				<p class="head">Dashboard</p>
			</div>

			<?php if (isset($_GET["register"]) && $_GET["register"] == true) { ?>
				<div class="alert success mb-3">
					<p class="alert pl-2"><?= ucfirst($username) ?> your account has been created successfully</p>
				</div>
			<?php } elseif (isset($_GET["login"]) && $_GET["login"] == true) { ?>
				<div class="alert success mb-3">
					<p class="alert pl-2">Welcome <?= ucfirst($username) ?>, login successful</p>
				</div>
			<?php }  ?>

			<div id="referral_box" class="flex-between mobile-mt-0 mobile-mb-0 ai-center no-break mb-5 mt-3 mobile-p-1 relative">
				<div class="w-60 mobile-w-100">
					<h3 class="mb-1 m-0 b-3 md white mobile-xsm" style="color: #fff;">Earn Daily with E-Mine!</h3>
					<ul>
						<p>At E-Mine, your daily login earns you real money—no tasks, no hassles, just rewards for showing up.</p> <br>
						<p>How it works:</p> 

						<ul>
							<li>Log in to your E-Mine account every day.</li>
							<li>Earn instant daily rewards credited to your wallet.</li>
							<li>Withdraw once your earnings reach the minimum balance of ₦5000.</li>
							<li>Start your journey to effortless income today. 💎</li>
						</ul>
					</ul>
				</div>

				<img src="images/withdrawal.png" class="home-img" alt="">
			</div>

			<section class="dashboard">
				<div class="dashboard-container">
					<div class="referral-link">
						<p class="text">Referral Link:</p>
							<p class="text relative">
								<span id="referral_code">http://localhost/php/e-mine/reg/<?= $user_details["referral_code"] ?></span> <i class="fas fa-copy ml-2 fa-xl copy"  style="fot-size: 15px;"></i>
							</p>
							<input type="hidden" name="username" id="username" value="<?= $user_details["username"] ?>">
					</div>

				<div class="earnings dashboard-mini-box">
					<div class="earning-box dashboard-box">
						<div class="earning-amount amount">
							<div class="price">&#8358;<?= ($user_details["all_time_earnings"]) ?></div>
							<div class="text">All Earnings</div>
						</div>
						<div class="icon"><i class="fas fa-chart-simple"></i></div>
					</div>

					<div class="get-more">
						<a href=""><i class="fas fa-diamond-turn-right"></i></a>
					</div>
				</div>
				
				<div class="earnings dashboard-mini-box">
					<div class="earning-box dashboard-box">
						<div class="earning-amount amount">
							<div class="price"><?= $referral_details["referral_count"] ?></div>
							<div class="text">Referrals</div>
						</div>
						<div class="icon"><i class="fas fa-users"></i></div>
					</div>

					<div class="get-more" id="referral">
						<a href=""><i class="fas fa-diamond-turn-right"></i></a>
					</div>
				</div>

				<div class="earnings dashboard-mini-box">
					<div class="earning-box dashboard-box">
						<div class="earning-amount amount">
							<div class="price"><?= $user_details["ads_history"] ?></div>
							<div class="text">My Task</div>
						</div>
					<div class="icon"><i class="fas fa-calendar-check"></i></div>
				</div>
					<div class="get-more" id="task">
					<a href="ta"><i class="fas fa-diamond-turn-right"></i></a>
					</div>
				</div>
				</div>
			</section>
		</main>

		<script src="js/navbar.js"></script>
		<script src="js/referral.js"></script>
	</body>
	</html>
