<?php 
	$page_title = "Deposit Management";

	session_start();

	require_once("config/function.php"); 

	if(isset($_SESSION['user'])  && isset($_SESSION['user_id']) && $_SESSION['position'] == "admin") {
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
		header("Location: /logged_out");
	}

	require_once("layout/admin-header.php"); ?>


	<main class="main" id="main">
		<section class="section dashboard container" id="affiliate">
			<div class="pagetitle">
				<nav>
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index">Home</a></li>
					<li class="breadcrumb-item active">Deposit Management</li>
				  </ol>
				</nav>
			</div><!-- End Page Title -->

			<div class="tablet-w-100">
                <div class="form-group flex mt-1 relative" id="search-box">
                    <i class="fa fa-search mr-1"></i><input class="form-control upload p-2 shadow-none" type="text" placeholder="Search all deposits...">
                </div>

				<?php
					try {
                        $deposit_sql = "SELECT * FROM  `transactions` WHERE `transaction_type` = 2 AND `status` = 1 ORDER BY `id` DESC";
                        $deposit_query = $db->query($deposit_sql);
                        $number_of_unverified_deposits = $deposit_query->rowCount();
                        $deposits = $deposit_query->fetchAll(PDO::FETCH_ASSOC); 
                    } catch (PDOException $e) {}
				?>

				<div class="mt-4 tablet-100">
					<p class="md m-0">Unverified Deposit (<span id="numberOfDeposits"><?= $number_of_unverified_deposits; ?></span>)</p>

					<div>
						<?php							
							if ($number_of_unverified_deposits > 0) { 
								foreach ($deposits as $deposit):
								$user_details = get_user_info_by_id($deposit["user_id"]); ?>
				
									<div class="info-card px-3 py-2 mobile-p-1 mb-4" id="verify-deposit<?= $deposit["id"] ?>">
										<div>
											<p class="xxsm m-0 secondary"><?= $user_details["number"] ?></p>
											<p class="ssm m-0 b-3">Transcation ID: <?= $deposit["transaction_id"] ?> || Amount: ₦<?= $deposit["amount"] ?></p>
										</div>

										<div class="mt-3 mb-2 d-" id="">
											<div class="flex-between">
                                                <div class="w-47 tablet-w-100 tablet-mb-1">
													<label for="">User:</label>
													<input type="text" class="form-control shadow-none none" placeholder="Payment Date" value="<?= get_user_info_by_id($deposit["user_id"])["number"] ?>" readonly>
												</div>

												<div class="w-47 tablet-w-100 tablet-mb-1">
													<label for="">Amount Paid:</label>
													<input type="text" class="form-control shadow-none none" placeholder="Withdrawal Transaction ID" value="₦<?= number_format($deposit["amount"]) ?>" readonly>
												</div>
											</div>
										</div>

                                        <div class="mt-3 mb-2 d-" id="">
											<div class="flex-between">
                                                <div class="w-47 tablet-w-100 tablet-mb-1">
													<button class="approve-btn deposits" data-amount="<?= $deposit["amount"] ?>" data-type="1"  data-iid="<?= $deposit["id"] ?>" data-type="1">Approve <i class="fa-solid fa-circle-check fa-lg ml-1"></i></button>
												</div>

												<div class="w-47 tablet-w-100 tablet-mb-1">
                                                    <button class="disapprove-btn deposits" data-amount="<?= $deposit["amount"] ?>" data-type="2"  data-iid="<?= $deposit["id"] ?>">Disapproved <i class="fa-solid fa-circle-exclamation fa-lg ml-1"></i></button>
												</div>
											</div>
										</div>
									</div>
								<?php 
								endforeach;
							} else { ?>
								<section class="my-5 py-3 center w-fit mx-auto">
									<i class="fa-solid fa-ranking-star primary fa-7x main"></i>
									<p class="md main">There are no unverified Deposit requests yet.</p>
								</section>
							<?php } 
						?>
					</div>
				</div>
			</div>
		</section>

	</main><!-- End #main -->


    <script>
        const depositBtns = document.querySelectorAll(".deposits");
        var numberOfDeposits =document.getElementById("numberOfDeposits");

        for (var i = 0; i < depositBtns.length; i++) {
            depositBtns[i].addEventListener('click', (e) => {
                var deposit = e.currentTarget.dataset.iid;
                var amount = e.currentTarget.dataset.amount;
                var type = e.currentTarget.dataset.type;

                if (type == 1) {
                    question = "Are you sure you want to approve the deposit of ₦" + amount;
                } else {
                    question = "Are you sure you want to disapprove the deposit of ₦" + amount;
                }
                
                if (confirm(question)) {
                    const Deposit = new XMLHttpRequest;

                    Deposit.onload = () => {
                        var DepositObject = null;
                        
                        try {
                            console.log(Deposit.responseText);
                            DepositObject = Deposit.responseText;
                            
                            if (DepositObject == 1) {
                                if (type == 1) alert("Deposit added to user wallet");
                                if (type == 2) alert("This Deposit has been marked as failed and no money is added to the user account.");
                                numberOfDeposits.innerHTML = Number(numberOfDeposits.innerHTML) - 1;
                                document.getElementById("verify-deposit" + deposit).style.display = "none";
                            } else {
                                alert("There was a network issue"); 
                            }
                        } catch(e) {}
                    }

                    const requestDeposit = `deposit=${deposit}`;
                    
                    if (type == 1) {
                        Deposit.open('post', 'config/verifyDeposit.php');
                    } else {
                        Deposit.open('post', 'config/failedDeposit.php');
                    }

                    Deposit.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
                    Deposit.send(requestDeposit);
                }
            })
        }
    </script>


	<?php 
	require_once("layout/admin-footer.php"); 
?>