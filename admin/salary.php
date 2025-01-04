<?php 
	$page_title = "Weekly Salary";
	require_once("config/function.php");
	session_start(); 

	if(isset($_SESSION['user'])  && isset($_SESSION['user_id']) && $_SESSION['position'] == "admin") {
		$user = $_SESSION['user'];
		$user_id = $_SESSION['user_id'];
		$logged_time = $_SESSION['last_login_timestamp'];
		$user_info = get_admin_user_info($user);
		
		if (empty($user_info) || ($user_info["admin_id"] != $user_id)) {
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
				<h1>Weekly Salary</h1>
				<nav>
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item active">Weekly Salary</li>
				  </ol>
				</nav>
			</div><!-- End Page Title -->

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
											<th scope="col" style="color: #000;">S/N</th>
											<th scope="col" style="color: #000;">Email</th>
											<th scope="col" style="color: #000;">Rank</th>
											<th scope="col" style="color: #000; min-width: 300px;">Number of Referral since Monday</th>
											<th scope="col" style="color: #000;">Weekly Salary</th>
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
											$number = 1;
	
											try {
												if ($number_of_users > 0) { 
													foreach ($user_details as $user): 
														$bonusAmount = entitledWeeklySalary($user); 
														if ($bonusAmount > 0) { ?>
															<tr>
																<td scope="row" style="color: #000;"><b><?= $number ?></b></td>
																<td scope="row" style="color: #000;"><b><?= $user["email"] ?></b></td>
																<td><b><?= ucfirst($user["rank"]) ?></b></td>
																<td style="min-width: 300px;"><b><?= $user["referrals_this_week"] ?></b></td>
																<td><b><?= number_format($bonusAmount) ?></b></td>
															</tr>
														<?php $number ++ ; } 
													endforeach;
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