<?php 
	$page__css = '
		<link rel="stylesheet" href="css/navbar.css" />
		<link rel="stylesheet" href="css/subscription.css" />
	'; 

require_once("layout/user-header.php"); ?>

	<main>
		<div class="subscription-panel">
			<p class="head">Subscriptions Plans</p>
		</div>

		<section class="subscription">
			<?php	
				try {
					global $db;
					require_once("config/PPC.php");
					$PPC = new PPCPlan();
					$plans = $PPC->getSubscriptionPlans();

					if (count($plans) > 0) { 
						foreach ($plans as $plan):  ?>
							<div class="subscription-container">
								<div class="content">
									<div class="head-buy">
										<p class="head"><?= ucfirst($plan["plan_name"]) ?></p>
									</div>

									<div class="details">
										<div class="price">
											<p class="text">Price</p>
											<p class="amount">&#8358; <?= number_format($plan["price"]) ?></p>
										</div>

										<div class="days">
											<p class="text">Months</p>
											<p class="amount"><?= $plan["duration_months"] ?></p>
										</div>

										<div class="daily-income">
											<p class="text">Daily Income</p>
											<p class="amount">&#8358; <?= number_format($plan["daily_income"]) ?></p>
										</div>

										<div class="total-income">
											<p class="text">Total Income</p>
											<p class="amount">&#8358; <?= number_format($plan["total_income"]) ?></p>
										</div>
									</div>

									<a href="buy-subscription.php?plan_id=<?= $plan["subscription_id"] ?>"><button class="buy">Buy</button></a>
								</div>
							</div>
						<?php endforeach;
					}
				} catch (PDOException $e) {}
			?>
		</section>
	</main>

	<script src="navbar.js"></script>
</body>
</html>
