<?php 
	$page__css = '
		<link rel="stylesheet" href="css/project.css" />
		<link rel="stylesheet" href="css/navbar.css" />
	';

	require_once("layout/user-header.php"); ?>

		<main>
			<div class="dashboard-panel">
				<p class="head">Dashboard</p>
			</div>

			<section class="dashboard">
				<div class="dashboard-container">
					<div class="referral-link">
						<p class="text">Referral Link:</p>
						<p class="text">
						https://app.bapemall.com/reg/jaye9 <i class="fas fa-copy"></i>
						</p>
					</div>

				<div class="earnings dashboard-mini-box">
					<div class="earning-box dashboard-box">
						<div class="earning-amount amount">
							<div class="price">&#8358;0.00</div>
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
						<div class="price">0</div>
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
						<div class="price">0</div>
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
