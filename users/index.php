<?php 
	$page__css = '
		<link rel="stylesheet" href="css/project.css" />
		<link rel="stylesheet" href="css/navbar.css" />
	';

	try {
		global $db;
		require_once("config/PPC.php");
		$user = new PPCUser($user);
		$user_details = $user->getUserDetails();
		$referral_details = $user->getUserReferralDetails();

	} catch (PDOException $e) {}

	require_once("layout/user-header.php"); ?>

		<main>
			<div class="dashboard-panel">
				<p class="head">Dashboard</p>
			</div>

			<section class="dashboard">
				<div class="dashboard-container">
					<div class="referral-link">
						<p class="text">Referral Link:</p>
							<p class="text relative">
								<span id="referral_code">https://emine.com.ng/reg/<?= $user_details["referral_code"] ?></span> <i class="fas fa-copy ml-2 fa-xl copy"  style="fot-size: 15px;"></i>
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
	</body>
	</html>
