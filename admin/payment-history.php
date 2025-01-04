<?php 
	$page_title = "Withdrawal payments";

	session_start();
	require_once("config/function.php"); 

	if(isset($_SESSION['user'])  && isset($_SESSION['user_id']) && $_SESSION['role'] == "admin") {
		$user = $_SESSION['user'];
		$user_id = $_SESSION['user_id'];
		$logged_time = $_SESSION['last_login_timestamp'];
		$user_info = get_admin_user_info($user);
		
		if (empty($user_info) || ($user_info["id"]) != $user_id) {
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


	<main class="main" id="main">
		<section class="section dashboard container" id="affiliate">
			<div class="pagetitle">
				<nav>
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index">Home</a></li>
					<li class="breadcrumb-item active">Affiliate payment History</li>
				  </ol>
				</nav>
			</div><!-- End Page Title -->

			<div class="tablet-w-100">
                <div class="form-group flex mt-1 relative" id="search-box">
                    <i class="fa fa-search mr-1"></i><input class="form-control upload p-2 shadow-none" type="text" placeholder="Search all payments...">
                </div>

				<?php
					$payment_sql = "SELECT * FROM  `withdrawals` WHERE `status` = :payment ORDER BY `id` DESC";
					$payment_query = $db->prepare($payment_sql);
					$payment_query->execute([  ":payment"  =>  1  ]);
					$number_of_withdrawal_payments = $payment_query->rowCount();
					$Withdrawal_payments = $payment_query->fetchAll(PDO::FETCH_ASSOC); 
				?>

				<div class="mt-4 tablet-100">
					<p class="md m-0">Withdrawal Payments (<?= $number_of_withdrawal_payments; ?>)</p>

					<div>
						<?php							
							if ($number_of_withdrawal_payments > 0) { 
								foreach ($Withdrawal_payments as $payment):
								$user_details = get_user_info_by_id($payment["user_id"]); ?>
				
									<div class="info-card px-3 py-2 mobile-p-1 mb-4">
										<div>
											<p class="xxsm m-0 secondary"><?= $user_details["number"] ?></p>
											<p class="ssm m-0 b-3">Transcation ID: <?= $payment["transaction_id"] ?> || Amount: ₦<?= $payment["amount"] ?></p>
										</div>

										<div class="mt-3 mb-2 d-" id="">
											<div class="flex-between">
												<div class="w-47 tablet-w-100 tablet-mb-1">
													<label for="">Amount Paid:</label>
													<input type="text" class="form-control shadow-none none" placeholder="Withdrawal Transaction ID" value="₦<?= $payment["amount"] ?>" readonly>
												</div>
								
												<div class="w-47 tablet-w-100 tablet-mb-1">
													<label for="">Paid On:</label>
													<input type="text" class="form-control shadow-none none" placeholder="Payment Date" value="<?= $payment["updated_on"] ?>" readonly>
												</div>
											</div>
										</div>
									</div>
								<?php 
								endforeach;
							} else { ?>
								<section class="my-5 py-3 center w-fit mx-auto">
									<i class="fa-solid fa-ranking-star primary fa-7x main"></i>
									<p class="md main">You have not paid any Withdrawal requests yet.</p>
								</section>
							<?php } 
						?>
					</div>
				</div>
			</div>
		</section>

	</main><!-- End #main -->


	<?php 
	require_once("layout/admin-footer.php"); 
?>