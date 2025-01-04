<?php 
	$page_title = "Subscriptions";

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
		header("Location: /logged_out");
	}

	require_once("layout/admin-header.php");?>


	<main id="main" class="main">	
		<section class="section dashboard">
			<div class="pagetitle">
				<h1>Subscriptions</h1>
				<nav>
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item active">Subscriptions</li>
				  </ol>
				</nav>
			</div><!-- End Page Title -->
	
			<?php if (isset($_GET["new"]) && ($_GET["new"] == true)) { ?>
				<div class="alert success mb-3">
					<p class="alert"><?= $user ?>, Welcome to your dashboard</p>
				</div>
			<?php } elseif (isset($_GET["updated"]) && ($_GET["updated"] == true)) { ?>
				<div class="alert success mb-3">
					<p class="alert"><?= $user ?>, Your account has been created successfully</p>
				</div>
			<?php } ?>

			<div class="row">
				<!-- Left side columns -->
				<div class="col-12">
					<div class="row">
						
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
                        
					</div>
				</div><!-- End Left side columns -->
			</div>
		</section>
	</main><!-- End #main -->

	
	<?php require_once("layout/admin-footer.php");
?>