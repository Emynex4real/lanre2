<?php 
	$page_title = "All Complaint transactions";

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
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item active">All Complaints transactions</li>
				  </ol>
				</nav>
			</div><!-- End Page Title -->

			<div class="tablet-w-100">
				<div class="form-group flex mt-1 relative" id="search-box">
					<i class="fa fa-search mr-1"></i><input class="form-control upload p-2 shadow-none" type="text" placeholder="Search all transactions..." value="<?php if (isset($_GET["complaint_id"])) { echo ($_GET["complaint_id"]); }  ?>">
				</div>

				<?php
					$transaction_sql = "SELECT * FROM  `transactions`";
					$transaction_query = $db->prepare($transaction_sql);
					$transaction_query->execute();
					$number_of_transactions = $transaction_query->rowCount();
					$transaction_details = $transaction_query->fetchAll(PDO::FETCH_ASSOC); 
				?>

				<div class="mt-3">
					<p class="md b-3 m-0">All Transactions (<?= $number_of_transactions ?>)</p>

					<div class="tablet-w-100 ">
						<?php		
							if ($number_of_transactions > 0) { 
								foreach ($transaction_details as $transaction): ?>
									<div class="info-card p-3 mobile-p-1 mb-2" id="transaction<?= $transaction["id"] ?>">
										<div class="flex-between ai-center">
											<div>
												<p class="xxsm m-0 b-3"><?= ucfirst($transaction["description"]) ?> of ₦<?= number_format($transaction["amount"]) ?></p>
												<p class="ssm m-0 b-2"><b>User:</b> <?= get_user_info_by_id($transaction["user_id"])["number"] ?> <b>|</b> <b>Ref:</b> <?= $transaction["transaction_id"] ?> <b>|</b> <b>Date:</b> <?= $transaction["created_on"] ?></p>
											</div>
											
											<div class="flex">
												<?php if ($transaction["status"] == 1) { ?>			
													<button class="warning-btn mobile-w-fit">
													<span>Pending</span> 
												<?php } elseif ($transaction["status"] == 2) { ?>
													<button class="success-btn mobile-w-fit">
													<span>Completed</span> 
												<?php } else { ?>
													<button class="danger-btn mobile-w-fit">
													<span>Not Completed</span> 
												<?php } ?>
													<i class="fa-solid fa-mark fa-lg"></i>
												</button>
											</div>
										</div>
									</div>
								<?php 
								endforeach;
							} else { ?>
							
							<?php }
						?>						
					</div>
				</div>
			</div>
		</section>

	</main><!-- End #main -->

	<script src="assets/js/ticketHandler.js"></script>
	<?php 
	require_once("layout/admin-footer.php");
?>