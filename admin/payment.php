<?php 
	$page_title = "Withdrawal Payment";

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

	require_once("layout/admin-header.php");  ?>



	<main class="main" id="main">
		<section class="section dashboard container mt-1" id="affiliate">
			<div class="pagetitle">
				<nav>
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item active">Affiliate payment</li>
				  </ol>
				</nav>
			</div><!-- End Page Title -->

			<div class="w-100">
				<div class="form-group flex mt-1 relative mb-3" id="search-box">
                    <i class="fa fa-search mr-1"></i><input class="form-control upload p-2 shadow-none" type="text" placeholder="Search all payouts...">
                </div>

				<?php 
					try { 
						$sql = "SELECT * FROM withdrawals WHERE status = 0 ORDER BY DATE(created_on) DESC;";
						$stmt = $db->query($sql);
						$payout_count = $stmt->rowCount();
					} catch (PDOException $e) {} 
				?>

				<p class="xsm b-3 m-0">Withdrawal Payout (<?= $payout_count; ?>)</p>
				<div class="tablet-w-100 mh-100vh mt-3"></div>
					<?php 
						if ($payout_count > 0) {
							// Initialize a multidimensional array to hold results grouped by date
							$withdrawalsPerDay = [];
						
							// Fetch and loop through the results
							while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								// Extract the date part from created_on (Y-m-d format)
								$withdrawalDate = date('Y-m-d', strtotime($row['created_on']));
						
								// Group the withdrawals by date and append each row under the date key
								$withdrawalsPerDay[$withdrawalDate][] = $row;
							}
						
							// Display the withdrawals grouped by date
							foreach ($withdrawalsPerDay as $date => $all_payment_details) {
								echo "<h6><b>Withdrawals for: $date</b></h6>";
						
								// Loop through each withdrawal on that date
								foreach ($all_payment_details as $payment_details) {	
									$user_info = get_user_info_by_id($payment_details["user_id"]);
									$user_account_details = get_account_details($user_info["id"]);
									$payment += 1; 
									$payment_amount = $payment_details["amount"] * 0.95; ?>

									<div class="info-card payment-request px-3 py-2 mobile-p-1 mb-4" id="payment<?= $payment_details["id"]; ?>" data-payment="<?= $payment_details["id"]; ?>">
										<input type="hidden" class="pay-number" value="<?= $user_info["number"]; ?>">
										<div class="flex-between ai-center">
											<div>
												<p class="xxsm m-0 secondary pay-username"><?= $user_account_details["account_name"]; ?></p>
												<p class="xsm m-0 b-3">Amount: ₦<?= $payment_amount; ?></p>
											</div>
					
											<div class="flex">
												<?php if ($payment_details["status"] == 0) { ?>
													<button class="danger-btn mobile-w-fit"><span>Unpaid</span> <i class="fa-solid fa-check fa-lg"></i></button>
												<?php } else { ?>
													<button class="success-btn mobile-w-fit ai-center"><span>Paid</span> <i class="fa-solid fa-check fa-lg"></i></button>
												<?php } ?>
											</div>
										</div>

										<div class="mt-3 mb-2 account-area">
											<div class="payment-area-<?= $payment_details["id"]; ?>" style="display: block">
												<div class="flex-between">
													<div class="w-47 tablet-w-100 tablet-mb-1">
														<label for="">Account Name:</label>
														<input type="text" class="form-control shadow-none none pay-account-name" placeholder="User account name" value="<?= $user_account_details["account_name"]; ?>" readonly>
													</div>
									
													<div class="w-47 tablet-w-100 tablet-mb-1">
														<label for="">Bank Name:</label>
														<input type="text" class="form-control shadow-none none pay-bank-name" placeholder="User bank name" value="<?= $user_account_details["bank_name"]; ?>" readonly>
													</div>
												</div>

												<div class="flex-between pt-2">
													<div class="w-47 tablet-w-100 tablet-mb-1">
														<label for="">Account Number:</label>
														<input type="text" class="form-control shadow-none none pay-account-number" placeholder="User account number" value="<?= $user_account_details["account_number"]; ?>" readonly>
													</div>
									
													<div class="w-47 tablet-w-100 tablet-mb-1">
														<label for="">User Payout:</label>
														<input type="text" class="form-control shadow-none none pay-amount" placeholder="User payout amount" value="₦<?= number_format($payment_amount, 2); ?>" readonly>
													</div>
												</div>

												<div class="mt-2">
													<label for="">Transaction ID:</label>
													<input type="text" class="form-control shadow-none none pay-transaction-id" placeholder="Enter the Transcation ID" id="transaction" value="<?= $payment_details["transaction_id"] ?>">
													<p class="error" id="transactionErr"></p>
												</div>
											</div>

											<div class="flex flex-between">
												<button class="editbtn1 mobile-w-fit mr-2 paid_btn payment-btn" data-payout_id="<?= $payment_details["id"]; ?>" data-payment="<?= $payment_details["id"]; ?>"><span>Mark as paid</span> <i class="fa-solid fa-coins fa-lg"></i></button>

												<button class="editbtn2 mobile-w-fit close_btn" data-payout_id="<?= $payment_details["id"]; ?>" data-payment="<?= $payment_details["id"]; ?>"><span>Reject Withdrawal</span> <i class="fa-solid fa-xmark fa-lg"></i></button>
											</div>
										</div>
									</div> 
								<?php }
							}

						} else { ?>
							<section class="my-5 py-3 center w-fit mx-auto">
								<i class="fa-solid fa-ranking-star primary fa-7x main"></i>
								<p class="md main">There are no Withdrawal requests yet.</p>
							</section>
						<?php }  
					?>
				</div>
			</div>
		</section>

	</main><!-- End #main -->

	<script src="assets/js/payment_handler.js"></script>
	
	<?php 
	require_once("layout/admin-footer.php"); 
?>