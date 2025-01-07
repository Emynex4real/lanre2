<?php 
	$page__css = '
		<link rel="stylesheet" href="css/referral.css" />
		<link rel="stylesheet" href="css/navbar.css" />
	'; 
	require_once("config/session.php");
	$page__title = "My Referrals";

	try {
		global $db;
		require_once("config/PPC.php");
		$user = new PPCUser($user_id);
		$user_details = $user->getUserDetails();
		$referral_details = $user->getUserReferralDetails();

	} catch (PDOException $e) {}

	require_once("layout/user-header.php"); ?>

	<main>
		<div class="referral-panel">
			<p class="head">My Referrals</p>
		</div>

		<section class="referral">
			<div class="referral-container">
				<div class="total-referral-earned">
					<div class="total-referral">
						<i class="fas fa-users"></i>
						<div class="referral-text">
							<p class="text">TOTAL REFERRALS</p>
							<p class="amount"><?= $referral_details["referral_count"] ?: 0 ?></p>
						</div>
					</div>

					<div class="total-earned">
						<i class="fas fa-coins"></i>

						<div class="referral-text">
							<p class="text">TOTAL EARNED</p>
							<p class="amount"><?= $referral_details["totalEarned"] ?></p>
						</div>
					</div>
				</div>

				<div class="referral-link">
					<div class="details">
						<p class="text" style="font-size: 19px;">Referral Link:</p>

						<div class="link">
							<p class="text relative">
								<span id="referral_code">http://localhost/php/e-mine/reg/<?= $user_details["referral_code"] ?></span> <i class="fas fa-copy ml-2 fa-xl copy"  style="fot-size: 15px;"></i>
							</p>
							<input type="hidden" name="username" id="username" value="<?= $user_details["username"] ?>">
						</div>

						<a><button class="share">SHARE</button></a>
					</div>
					<p class="texts">Get 10% for each invited user</p>
				</div>
			</div>

			<div class="my-referrals p-3">
				<p class="text">My Referrals</p>

				<div class="referral-details">
					<table>
						<tr>
							<th>DATE</th>
							<th>USER</th>
							<th>LEVEL</th>
							<th>PROFIT</th>
						</tr>

						<?php	
							try {
								if (count($referral_details["referrals"]) > 0) { 
									foreach ($referral_details["referrals"] as $referral):  ?>
										<tr>
											<td style="border-radius: 10px 0 0 10px;"><?= get_transaction_time($referral["created_on"]) ?></td>
											<td><?= ucfirst($user->getUserById($referral["user_id"])["username"]) ?></td>
											<td class="user"><i class="fas fa-users"></i><?= $referral["level"] ?></td>
											<td style="border-radius: 0 10px 10px 0; font-weight: 700;">+ <?= $referral["amount_earned"] ?></td> 
										</tr>
									<?php endforeach;
								}
							} catch (PDOException $e) {}
						?>
					</table>
				</div>
			</div>
		</section>
	</main>

	<script src="js/navbar.js"></script>
	<script src="js/referral.js"></script>
</body>
</html>
