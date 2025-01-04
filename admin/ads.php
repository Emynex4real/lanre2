<?php 
	$page_title = "All Ads";

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


	<main id="main" class="main">

		<div class="pagetitle flex-between ai-center">
			<div>
				<h1>All Ads</h1>
				<nav>
					<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item active">Ads</li>
					</ol>
				</nav>
			</div>

			<div class="mobile-mb-1 mobile-mt-m-1">
				<a href="add-ads.php"><button class="editbtn2"><i class="fa-solid fa-plus fa-lg"></i> Add new Coupon</button></a>
			</div>
		</div><!-- End Page Title -->

		<div class="form-group flex mt-1 relative" id="search-box">
			<i class="fa fa-search mr-1"></i><input class="form-control upload p-2 shadow-none" type="text" placeholder="Search all ads...">
		</div>

		<?php
			if (isset($_GET["new"]) && $_GET["new"] == "true") {
				$ads_title = $_GET["title"];
				echo '
					<section class="w-93 success flex-center ai-center no-break my-2 mb-3 new">
						<section class="w-90 m-auto">
							<p class="alert text-center">' . $ads_title . ' created sucessfully.</p> 
						</section>
					</section>
				';
			} 
		?>

		<section class="section dashboard mt-4">
			<?php
				global $db;
				require_once("config/PPC.php");
                $PPC = new PPCAd();
                $ads = $PPC->getAds();

				if (count($ads) > 0) {  ?>
					<section class="grid-3" id="all-course-list">
						<?php foreach ($ads as $ad): ?>
							<div class="hover-card info-card sales-card">
								<div class="card-body pt-3">
									<section class="flex-between ai-center no-break">
										<div class="flex">
											<i class="fa-star fa-solid"></i>
											<i class="fa-star fa-solid"></i>
											<i class="fa-star fa-solid"></i>
											<i class="fa-star fa-solid"></i>
											<i class="fa-star fa-solid"></i>
										</div>
									</section>

									<div class="pt-2 mb-3">
                                        <p class="xxsm m-0 b-5 black b-3"><?= ucfirst($ad["ad_name"]) ?></p>
                                        <h6 class="b-3"><?= $ad["clicks"] ?> Clicks of <?= $ad["max_attempt"] ?></h6>
									</div>

                                    <button class="success-btn mb-1"><?= ucfirst($ad["status"]) ?></button>

									<div class="mt-3 flex-between ai-center no-break">                                            
										<a href="edit-coupon/<?= $ad["ad_id"] ?>" class="a"><button class="editbtn1">Edit Coupon</button></a>
										<a href="delete-coupon/<?= $ad["ad_id"] ?>" class="a"><button class="delete-butn">Delete Coupon</button></a>
									</div>
								</div>
							</div>
						<?php endforeach ?>
					</section>

				<?php } else { ?>
					 <section class="my-5 py-3 center w-fit mx-auto">
						<i class="fa-solid fa-ranking-star primary fa-7x main"></i>
						<p class="md main">There are no Coupons yet.</p>
					</section>
				<?php }
			?>
		</section>

	</main><!-- End #main -->

	
	<?php 
	require_once("layout/admin-footer.php"); ?>