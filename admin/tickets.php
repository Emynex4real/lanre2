<?php 
	$page_title = "All Complaint Tickets";

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
					<li class="breadcrumb-item active">All Complaints tickets</li>
				  </ol>
				</nav>
			</div><!-- End Page Title -->

			<div class="tablet-w-100">
				<div class="form-group flex mt-1 relative" id="search-box">
					<i class="fa fa-search mr-1"></i><input class="form-control upload p-2 shadow-none" type="text" placeholder="Search all tickets..." value="<?php if (isset($_GET["complaint_id"])) { echo ($_GET["complaint_id"]); }  ?>">
				</div>

				<?php
					$ticket_sql = "SELECT * FROM  `support` WHERE `status` != :status";
					$ticket_query = $db->prepare($ticket_sql);
					$ticket_query->execute([  ":status"  =>  2] );
					$number_of_tickets = $ticket_query->rowCount();
					$ticket_details = $ticket_query->fetchAll(PDO::FETCH_ASSOC); 
				?>

				<div class="mt-3">
					<p class="md b-3 m-0">Unsolved Tickets (<?= $number_of_tickets ?>)</p>

					<div class="tablet-w-100 ">
						<?php		
							if ($number_of_tickets > 0) { 
								foreach ($ticket_details as $ticket): 
									$user_email = get_user_info_by_id($ticket["user_id"])["email"]; ?>
									<div class="info-card p-3 mobile-p-1 mb-3" id="ticket<?= $ticket["id"] ?>">
										<div class="flex-between ai-center">
											<div>
												<p class="xxsm m-0"><?= $ticket["subject"] ?></p>
												<p class="ssm m-0 b-2"><b>User:</b> <?= $user_email ?> <b>|</b> <b>Ref:</b> <?= $ticket["id"] ?> <b>|</b> <b>Date:</b> <?= $ticket["created_on"] ?></p>
											</div>
											
											<div class="flex">
												<?php if ($ticket["status"] == 1) { ?>
													<button class="warning-btn mobile-w-fit">
														<span>Processing..</span>
													</button>
												<?php } elseif ($ticket["status"] == 2) { ?>
													<button class="success-btn mobile-w-fit"> 
														<i class="fa-solid fa-mark mr-1 fa-lg"></i>
														<span>Solved</span>
													</button>
												<?php } else { ?>
													<button class="danger-btn mobile-w-fit">
														<i class="fa-solid fa-xmark mr-1 fa-lg"></i>
														<span>Unsolved</span> 
													</button>
												<?php } ?>
											</div>
										</div>

										<div class="alert success my-2 d-none">
											<p class="alert">Reply has been sent to user <b><?= ucfirst($user_email) ?></b></Menu></p>
										</div>

										<div id="replyTicket<?= $ticket["id"] ?>">
											<div class="mt-2">
												<label for="">Description:</label>
												<textarea class="form-control shadow-none none" rows="4" style="resize: none" placeholder="* Description" readonly><?= $ticket["message"] ?></textarea>
											</div>

											<div class="mt-2 d-none replyBox">
												<label>Reply:</label>
												<input type="hidden" value="<?= $user_email ?>" class="email">
												<textarea class="form-control shadow-none none reply" rows="4" style="resize: none" placeholder="* Type a reply to be sent to user email" id="reply<?= $ticket["id"] ?>"></textarea>
												<button class="mobile-w-95 mt-3 editbtn1 w-97 reply-btn  ticket-btn" data-type="2" data-id="<?= $ticket["id"] ?>"><i class="fa-solid fa-send fa-lg mt-2 mr-1"></i><span>Send email and end ticket</span></button>
											</div>
				
											<div class="mt-3 no-break ai-center flex-between ai-center">
												<button class="danger-btn mobile-w-fit ticket-btn" data-type="3" data-id="<?= $ticket["id"] ?>"><i class="fa-solid fa-xmark mt-1 mr-1 fa-lg"></i><span>Delet Ticket</span></button>

												<button class="mobile-w-fit editbtn1 mobile-w-fit reply-btn" data-id="<?= $ticket["id"] ?>"><i class="fa-solid fa-message fa-lg mt-2 mr-1"></i><span>Send a reply</span></button>
											</div>
										</div>
									</div>
								<?php 
								endforeach;
							} else { ?>
								<section class="my-5 py-3 center w-fit mx-auto">
									<i class="fa-solid fa-ranking-star primary fa-7x main"></i>
									<p class="md main">There are no open Tickets yet.</p>
								</section>
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