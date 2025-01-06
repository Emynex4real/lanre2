<?php 
	$page_title = "Admin Dashboard";

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
	} else {
		session_destroy();
		header("Location: /login");
	}

	require_once("layout/admin-header.php");?>


	<main id="main" class="main">	
		<section class="section dashboard">
			<div class="pagetitle">
				<h1>Dashboard</h1>
				<nav>
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item active">Dashboard</li>
				  </ol>
				</nav>
			</div><!-- End Page Title -->
	
			<?php if (isset($_GET["login"]) && ($_GET["login"] == true)) { ?>
				<div class="alert success mb-3">
					<p class="alert"><?= $user ?>, Welcome to your dashboard</p>
				</div>
			<?php } elseif (isset($_GET["register"]) && ($_GET["register"] == true)) { ?>
				<div class="alert success mb-3">
					<p class="alert"><?= $user ?>, Your account has been created successfully</p>
				</div>
			<?php } ?>

			<div class="row">
				<!-- Left side columns -->
				<div class="col-12">
					<div class="row">
						<!-- Sales Card -->
						<div class="col-xxl-4 col-md-6">
							<div class="info-card sales-card">

								<div class="card-body">
									<h5 class="card-title">Registeration <span>| All Time</span></h5>

									<div class="d-flex align-items-center">
										<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
											<i class="bi bi-people-fill"></i>
										</div>

										<div class="ps-3">
											<h6 class="b-5"><?= empty(get_row_count("users")) ? 0 : get_row_count("users")?></h6>
											<span class="text-success small pt-1 fw-bold">100%</span> <span class="text-muted small pt-2 ps-1">increase</span>
										</div>
									</div>
								</div>

							</div>
						</div><!-- End Sales Card -->

						<!-- Revenue Card -->
						<div class="col-xxl-4 col-md-6 tab-mt-3">
							<div class="info-card revenue-card">

								<div class="card-body">
								<h5 class="card-title">Subscriptions <span>| All Time</span></h5>

								<div class="d-flex align-items-center">
									<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
										<i class="bi bi-safe2-fill"></i>
									</div>
									<div class="ps-3">
									<h6 class="b-5"><?= empty(get_row_count("Subscriptions")) ? 0 : get_row_count("Subscriptions") ?></h6>
									<span class="text-success small pt-1 fw-bold">100%</span> <span class="text-muted small pt-2 ps-1">increase</span>
									</div>
								</div>
								</div>
							</div>
						</div><!-- End Revenue Card -->

						<!-- <div class="row mt-4"> -->
							<!-- Sales Card -->
							<div class="col-xxl-4 col-md-6 mt-4">
								<div class="info-card sales-card">

									<div class="card-body">
										<h5 class="card-title">Deposit <span>| All Time</span></h5>

										<div class="d-flex align-items-center">
											<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
												<i class="bi bi-wallet"></i>
											</div>

											<div class="ps-3">
												<h6 class="b-5">₦<?= "" ?></h6>
												<span class="text-success small pt-1 fw-bold">100%</span> <span class="text-muted small pt-2 ps-1">increase</span>
											</div>
										</div>
									</div>

								</div>
							</div><!-- End Sales Card -->

							<!-- Revenue Card -->
							<div class="col-xxl-4 col-md-6 tab-mt-3 mt-4">
								<div class="info-card revenue-card">

									<div class="card-body">
									<h5 class="card-title">Withrawals <span>| All Time</span></h5>

									<div class="d-flex align-items-center">
										<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
											<i class="bi bi-wallet2"></i>
										</div>
										<div class="ps-3">
										<h6 class="b-5">₦<?= number_format(get_total_withdrawal_amount()) ?></h6>
										<span class="text-success small pt-1 fw-bold">100%</span> <span class="text-muted small pt-2 ps-1">increase</span>
										</div>
									</div>
									</div>

								</div>
							</div><!-- End Revenue Card -->
						<!-- </div> -->


						<!-- <div class="row mt-4"> -->
							<!-- Sales Card -->
							<div class="col-xxl-4 col-md-6 mt-4">
								<div class="info-card sales-card">

									<div class="card-body">
										<h5 class="card-title"> Active Users</h5>

										<div class="d-flex align-items-center">
											<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
												<i class="bi bi-people-fill"></i>
											</div>

											<div class="ps-3">
												<h6 class="b-5"><?= number_of_active_users(); ?></h6>
												<span class="text-success small pt-1 fw-bold">100%</span> <span class="text-muted small pt-2 ps-1">increase</span>
											</div>
										</div>
									</div>
								</div>
							</div><!-- End Sales Card -->

							<!-- Revenue Card -->
							<div class="col-xxl-4 col-md-6 tab-mt-3 mt-4">
								<div class="info-card revenue-card">

									<div class="card-body">
									<h5 class="card-title">Inactive Users</h5>

									<div class="d-flex align-items-center">
										<div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
										<i class="bi bi-people-fill"></i>
										</div>
										<div class="ps-3">
										<h6 class="b-5"><?= number_of_inactive_users(); ?></h6>
										<span class="text-success small pt-1 fw-bold">50%</span> <span class="text-muted small pt-2 ps-1">increase</span>

										</div>
									</div>
									</div>

								</div>
							</div><!-- End Revenue Card -->
						<!-- </div> -->

						<!-- Top Selling -->
						<div class="col-12 mt-4">
							<div class="info-card top-selling overflow-auto">

								<div class="card-body pb-0">
									<div class="flex-between ai-center no-break">
										<h5 class="card-title">Customer Service <span>| All Tickets</span></h5>

										<a href="complaints"><button class="btn2">See All</button></a>
									</div>

								<table class="table table-borderless" id="complaints">
									<thead>
										<tr>
											<th scope="col" style="color: #000;">Complaint ID</th>
											<th scope="col" style="color: #000;">Title</th>
											<th scope="col" style="color: #000;">Status</th>
										</tr>
									</thead>

									<tbody>
										<?php
											global $db;
											$ticket_sql = "SELECT * FROM  `support` LIMIT 5";
											$ticket_query = $db->query($ticket_sql);
											$ticket_query->execute();
											$number_of_tickets = $ticket_query->rowCount();
											$ticket_details = $ticket_query->fetchAll(PDO::FETCH_ASSOC); 
	
											if ($number_of_tickets > 0) { 
												foreach ($ticket_details as $ticket): ?>
													<tr>
														<th scope="row" style="color: #000;"><?= $ticket["id"] ?></th>
														<td><a href="complaints/<?= $ticket["id"] ?>" class="secondary fw-bold"><?= $ticket["subject"] ?></a></td>
														<td>
															<?php if ($ticket["status"] == 1) { ?>
																<button class="warning-btn mobile-w-fit">
																	<span>Processing...</span>
																</button>
															<?php } elseif ($ticket["status"] == 2) { ?>
																<button class="success-btn mobile-w-fit">
																	<span>Solved</span> 
																	<i class="fa-solid fa-mark fa-lg"></i>
																</button>
															<?php } else { ?>
																<button class="danger-btn mobile-w-fit">
																	<span>Unsolved</span> 
																	<i class="fa-solid fa-xmark fa-lg"></i>
																</button>
															<?php } ?>
														</td>
													</tr>
												<?php endforeach;
											}
										?>
									</tbody>
								</table>

								</div>

							</div>
						</div><!-- End Top Selling -->
					</div>
				</div><!-- End Left side columns -->
			</div>
		</section>
	</main><!-- End #main -->

	
	<?php require_once("layout/admin-footer.php");
?>