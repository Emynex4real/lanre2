<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Admin Dashboard - E-mine</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <base href="https://admin.emine.com.ng/" />
  <!-- Favicons -->
  <link rel="shortcut icon" type="image/x-icon" href="../assets/img/logo.jpg" />

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/utilities.css" rel="stylesheet">
  <link href="assets/css/utilities_media_query.css" rel="stylesheet">
  <link  rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>

<body>
	<!-- ======= Header ======= -->
	<header id="header" class="header fixed-top d-flex align-items-center background">
		<div class="d-flex align-items-center justify-content-between">
			<i class="bi bi-list toggle-sidebar-btn mr-2"></i>
    	</div><!-- End Logo -->

		<nav class="header-nav ms-auto">
			<ul class="d-flex align-items-center">
				<li class="nav-item dropdown pe-3">
					<a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
						<img src="https://https://emine.com.ng/admin/uploads/users/<?php if (!empty($user_info["image"])) { echo $user_info["image"]; } else { echo "user.png"; }; ?>" alt="<?= $user ?>" class="rounded-circle">
						<span class="d-none d-md-block dropdown-toggle ps-2"><?= $user; ?></span>
					</a><!-- End Profile Iamge Icon -->

					<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
						<li class="dropdown-header">
                            <h6><?= $user ?></h6>
                            <span>Admin</span>
						</li>

						<li>
						    <hr class="dropdown-divider">
						</li>

						<li>
                            <a class="dropdown-item d-flex align-items-center" href="logout">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
						</li>

					</ul><!-- End Profile Dropdown Items -->
				</li><!-- End Profile Nav -->
			</ul>
		</nav><!-- End Icons Navigation -->
	</header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
	<aside id="sidebar" class="sidebar mt-2">
		<ul class="sidebar-nav" id="sidebar-nav">
			<li class="nav-item">
				<a class="nav-link collapsed" href="index.php">
					<i class="bi bi-grid"></i>
					<span>Dashboard</span>
				</a>
			</li><!-- End Dashboard Nav -->

			<li class="nav-heading">PPC Management</li>

			<li class="nav-item">
				<a class="nav-link collapsed" href="Subscriptions.php">
					<i class="bi bi-cart"></i>
					<span>Plans</span>
				</a>
			</li>

			<li class="nav-item">
				<a class="nav-link collapsed" href="ads.php">
					<i class="bi bi-speaker"></i>
					<span>All Ads</span>
				</a>
			</li>

			<li class="nav-item">
				<a class="nav-link collapsed" href="coupons.php">
					<i class="bi bi-gift"></i>
					<span>Coupons</span>
				</a>
			</li>


			<li class="nav-heading">Users</li>

			<li class="nav-item">
				<a class="nav-link collapsed" href="users.php">
					<i class="bi bi-people-fill"></i>
					<span>Manage Users</span>
				</a>
			</li><!-- End Contact Page Nav -->	

			<li class="nav-item">
				<a class="nav-link collapsed" href="user-subscriptions.php">
					<i class="bi bi-gift"></i>
					<span>User Subscriptions</span>
				</a>
			</li><!-- End Contact Page Nav	 -->

			<li class="nav-item">
				<a class="nav-link collapsed" href="complaints.php">
					<i class="bi bi-dash-circle"></i>
					<span>Customer Service</span>
				</a>
			</li>

			<li class="nav-heading">Payment</li>

			<li class="nav-item">
				<a class="nav-link collapsed" href="payment.php">
					<i class="bi bi-coin"></i>
					<span>Withdrawal Request</span>
				</a>
			</li><!-- End Error 404 Page Nav -->

			<li class="nav-item">
				<a class="nav-link collapsed" href="payment-history.php">
					<i class="bi bi-coin"></i>
					<span>Payment History</span>
				</a>
			</li><!-- End Error 404 Page Nav -->


			<li class="nav-heading">Others</li>

			<li class="nav-item">
				<a class="nav-link collapsed" href="transactions.php">
					<i class="bi bi-dash-circle"></i>
					<span>Transactions</span>
				</a>
			</li><!-- End Error 404 Page Nav -->
		</ul>
	</aside><!-- End Sidebar-->