<?php 
	$page__css = '
		<link rel="stylesheet" href="css/buy-subscription.css" />
		<link rel="stylesheet" href="css/navbar.css" />
	'; 
	require_once("config/session.php");
	$page__title = "Buy Subscription";

	require_once("layout/user-header.php");
	
	if ($_GET["plan_id"]) {
		$plan_id = $_GET["plan_id"];
		require_once("config/PPC.php");
		$PPC = new PPCPlan();
		$plan = $PPC->getSubscriptionPlanById($plan_id);
	} else {
		go_back();
	} ?>


	<main>
		<div class="buy-subscription-panel">
			<p class="head">Buy <?= ucfirst($plan["plan_name"]) ?></p>
		</div>

		<section class="buy-subscription">
			<img src="images/unnamed.png" alt="" />
			
			<div class="buy-subscription-container">
				<div class="vip1">
					<div class="header">
						<p class="head"><?= ucfirst($plan["plan_name"]) ?></p>
						<p class="text">Limited to <b><?= $plan["purchase_limit"] ?></b> purchases</p>
					</div>

					<div class="details">
						<div class="price-days">
							<div class="days">
								<p class="amount"><?= $plan["duration_months"] ?></p>
								<p class="text">Month(s)</p>
							</div>

							<div class="price">
								<p class="amount">&#8358;<?= number_format($plan["daily_income"] )?></p>
								<p class="text">Daily Income</p>
							</div>

							<div class="days">
								<p class="amount">&#8358;<?= number_format($plan["total_income"] )?></p>
								<p class="text">Total Income</p>
							</div>
						</div>
					</div>
				</div>

				<div class="welfare-fund">
					<p class="head">My Wallet</p>

					<div class="balance-payment">
						<div class="balance">
							<p class="text">Balance</p>
							<p class="amount">&#8358; <?= "" // number_format($user["deposit_balance"]); ?></p>
						</div>

						<hr />

						<div class="payment">
							<p class="text">Payment</p>
							<p class="amount">&#8358; <?= number_format($plan["price"]); ?></p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<div class="go-to-buy">
			<div class="price-payment">
				<p class="price">&#8358;<?= number_format($plan["price"]) ?></p>
				<p class="payment">Payment</p>
			</div>
			<button class="buy" id="buy-subscription-btn">Go to Buy</button>
		</div>
	</main>

	<div id="purchaseModal" class="modal">
		<div class="modal-content">
			<div id="loader" class="spinner"></div>
			<p id="modalMessage">Processing your purchase...</p>
		</div>
	</div>

	<script src="js/modal.js"></script>
	<script src="js/navbar.js"></script>
</body>
</html>
