<?php 		
	$page_title = "Add Coupon";

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
	
	if (isset($_POST["code"])) {
		$coupon_code = $_POST["code"];
		$amount = $_POST["amount"];

		try {
			$sql = "INSERT INTO coupons (`code`, `amount`) VALUES (:code, :amount)";
			$query = $db->prepare($sql);
			if ($query->execute(array(
				':code' => $coupon_code,
				':amount' => $amount,
			))) {
				header("Location: coupons.php?title=$coupon_title&new=true");
			}
		} catch (PDOException $e)  {
			echo $e;
		}
	} 
	
	require_once("layout/admin-header.php"); ?>


	<main id="main" class="main">
		<div class="pagetitle">
			<h1>Add Coupon</h1>
			<nav>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item active">Add Coupon</li>
				</ol>
			</nav>
		</div><!-- End Page Title -->

		<section class="section dashboard form h-5">
			<div class="card p-3 mobile-p-1 mobile-mt-m-1">
				<div class="card-body">
					<h5 class="card-title">Add Coupon</h5>

					<!-- Vertical Form -->
					<form class="row g-3 mh-100vh" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="create-form" enctype="multipart/form-data">
						<div class="col-12">
							<input type="text" class="form-control shadow-none none" placeholder="Coupon passkey" id="passkey" name="passkey">
							<p class="error" id="passkeyErr"></p>
						</div>

						<div class="col-12">
							<input type="text" class="form-control shadow-none" placeholder="Enter coupon code" id="code" name="code">
							<p id="codeErr" class="error"></p>
						</div>
			
						<div class="col-12">
							<input type="text" class="form-control shadow-none none" placeholder="(₦) Amount each user should collect  e.g 300" id="amount" name="amount">
							<p class="error" id="amountErr"></p>
						</div>

						<div class="mt-0 mt-3 mb-2">
							<button type="submit" class="btn1" id="add-coupon" name="add_coupon">Create coupon code</button>
						</div>
					</form><!-- Vertical Form -->
				</div>
			</div>
		</section>
	</main><!-- End #main -->

	<script src="assets/js/coupon.js"></script>

	<?php 
	require_once("layout/admin-footer.php");
?>