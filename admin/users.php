<?php 
	$page_title = "Admin Dashboard";

	require_once("config/function.php");
	session_start(); 

	if(isset($_SESSION['user'])  && isset($_SESSION['user_id']) && $_SESSION['role'] == "admin") {
		$user = $_SESSION['user'];
		$user_id = $_SESSION['user_id'];
		$logged_time = $_SESSION['last_login_timestamp'];
		$user_info = get_admin_user_info($user);
		
		if (empty($user_info) || ($user_info["id"] != $user_id)) {
			session_destroy();
			header("Location: logged_out");

		} elseif ((time() - $_SESSION['last_login_timestamp'] )> 10800) {
			header("Location: logged_out");
		} 

	} else {
		echo $_SESSION['user'];
		// session_destroy();
		header("Location: login");
	}

	require_once("layout/admin-header.php");?>


	<main id="main" class="main">	
		<section class="section dashboard">
			<div class="pagetitle">
				<h1>Manage Users</h1>
				<nav>
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item active">Manage Users</li>
				  </ol>
				</nav>
			</div><!-- End Page Title -->
	
            <div class="search-bar my-3">
				<div class="search-form d-flex align-items-center">
					<button type="submit" title="Search"><i class="bi bi-search"></i></button>
					<input type="text" name="user_query" id="user_query" placeholder="Search all Users" title="Enter search keyword">
				</div>
			</div><!-- End Search Bar -->

			<div class="row">
				<div class="col-12">
					<div class="row">
                        <!-- Top Selling -->
						<div class="col-12 mt-4">
							<div class="info-card top-selling overflow-auto">

								<div class="card-body pb-0">
									<div class="flex-between ai-center no-break">
										<h5 class="card-title">All Users</h5>
									</div>

								<table class="table table-borderless" id="complaints">
									<thead>
										<tr>
											<th scope="col" style="color: #000;">Email</th>
											<th scope="col" style="color: #000;">Deposit Balance</th>
											<th scope="col" style="color: #000;">Income Balance</th>
											<th scope="col" style="color: #000;">User Investment</th>
											<th scope="col" style="color: #000;">Team size</th>
											<th scope="col" style="color: #000;">Valid Team size</th>
											<th scope="col" style="color: #000;">Total Team Investment</th>
											<th scope="col" style="color: #000;">Rank</th>
											<th scope="col" style="color: #000;">Status</th>
                                            <th scope="col" colspan="2" style="color: #000; text-align: center; font-size: 19px; min-width: 200px; margin-right: 20px;">Action</th>
										</tr>
									</thead>

									<tbody id="users_data">
										<?php
											global $db;
											$user_sql = "SELECT * FROM `users` ORDER BY ID DESC";
											$user_query = $db->query($user_sql);
											$user_query->execute();
											$number_of_users = $user_query->rowCount();
											$user_details = $user_query->fetchAll(PDO::FETCH_ASSOC); 
	
											try {
												if ($number_of_users > 0) { 
													foreach ($user_details as $user): 
														$user_balance = get_user_balances($user["id"]);
														$deposit_balance = $user_balance ? number_format($user_balance["deposit_balance"]) : 0;
														$income_balance = $user_balance ? number_format($user_balance["income_balance"]) : 0; 
														$total_user_investments = get_total_user_investments($user["id"]) ? number_format(get_total_user_investments($user["id"])) : 0; 
														$total_user_team_investment = checkUserTeamTotalInvestment($user["referral_code"]) ? number_format(checkUserTeamTotalInvestment($user["referral_code"])) : 0;
														$user_deposits = check_if_user_has_ever_invested($user["id"]); ?>

														<tr>
															<td scope="row" style="color: #000;"><b><?= $user["email"] ?></b></td>
															<td><b><?= "₦" . $deposit_balance ?></b></td>
															<td><b><?= "₦" . $income_balance ?></b></td>
															<td><b><?= "₦" . $total_user_investments ?></b></td>
															<td><b><?= get_user_team_size($user["referral_code"]) ?></b></td>
															<td><b><?= get_user_valid_team_size($user["id"]) ?></b></td>
															<td><b><?= "₦" . $total_user_team_investment ?></b></td>
															<td><b><?= ucfirst($user["rank"]) ?></b></td>
	
															<td>
																<?php if ($user["verification"] == 1 || $user["verification"] == 0) {
																	if (check_if_user_has_ever_invested($user["id"]) > 0) {?>
																		<button class="success-btn mobile-w-fit">
																			<i class="fa-solid fa-mark fa-lg"></i>
																			<span>Active</span> 
																		</button>

																	<?php } else { ?>
																		<button class="danger-btn mobile-w-fit">
																			<i class="fa-solid fa-xmark fa-lg"></i>
																			<span>Inactive</span> 
																		</button>
																	<?php } 

																} else { ?>
																	<button class="danger-btn mobile-w-fit">
																		<i class="fa-solid fa-xmark fa-lg"></i>
																		<span>Banned</span> 
																	</button>
																<?php } ?>
															</td>

															<td style=" margin-right: 20px;">
																<button class="editbtn1 mobile-w-100 funds-btn flex" data-user="<?= $user["id"] ?>" data-email="<?= $user["email"] ?>">
																	<i class="fa-solid fa-plus fa-lg mr-1"></i>
																	<span id="span<?= $user["id"] ?>" style="min-width: 100px">Add Funds</span> 
																</button>
															</td>
	
															<td style="padding-left: 40px;">
																<?php if ($user["verification"] == 1 || $user["verification"] == 0) { ?>
																	<button class="editbtn1 ban mobile-w-100 action-btn flex" data-user="<?= $user["id"] ?>" data-action="ban" data-email="<?= $user["email"] ?>">
																		<i class="fa-solid fa-xmark fa-lg mr-1"></i>
																		<span id="span<?= $user["id"] ?>" style="min-width: 80px">Ban user</span> 
																		<i class="fa-solid fa-user fa-lg"></i>
																	</button>
																<?php } else { ?>
																	<button class="editbtn1 unban mobile-w-100 action-btn flex" data-user="<?= $user["id"] ?>" data-action="unban" data-email="<?= $user["email"] ?>">
																		<i class="fa-solid fa-circle-check fa-lg mr-1"></i>
																		<span id="span<?= $user["id"] ?>" style="min-width: 100px">Unban user</span> 
																		<i class="fa-solid fa-user fa-lg"></i>
																	</button>
																<?php } ?>
															</td>
														</tr>
													<?php endforeach;
												}
											} catch (PDOException $e) { echo $e; }
										?>
									</tbody>
								</table>

								</div>

							</div>
						</div>
                    </div>
				</div><!-- End Left side columns -->
			</div>
		</section>
	</main><!-- End #main -->


	   <!-- /*  Decision box */  -->
	   <div id="modal-container">
        <b class="cookies-card">
			<section class="success p-2 mb-2" style="display: none;" id="success_message">
				<p class="text-center m-0" id="update-text">dssdjh</p> 
			</section>

            <p class="cookie-heading">Add Funds</p>
			<p>Enter the amount you want to add to <b id="user-email"></b> account balance.</p>
            
            <div>
                <input type="number" id="funds-amount" class="form-control" placeholder="* e.g 3000">
                <p class="error m-0" id="amountErr"></p>
            </div>

            <div class="button-wrapper">
                <button class="accept cookie-button">Add funds</button>
            </div>

            <button class="exit-button">
                <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 162 162"
                class="svgIconCross"
                >
                <path
                    stroke-linecap="round"
                    stroke-width="17"
                    stroke="black"
                    d="M9.01074 8.98926L153.021 153"
                ></path>
                <path
                    stroke-linecap="round"
                    stroke-width="17"
                    stroke="black"
                    d="M9.01074 153L153.021 8.98926"
                ></path>
                </svg>
            </button>
        </div>
    </div>

	<script src="assets/js/users.js"></script>
	<?php require_once("layout/admin-footer.php");
?>