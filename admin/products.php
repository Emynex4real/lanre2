<?php 
	$page_title = "All Courses";

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

		<div class="pagetitle flex-between ai-center no-break">
			<div>
				<h1>All Products</h1>
				<nav>
					<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item active">Products</li>
					</ol>
				</nav>
			</div>
			
		</div><!-- End Page Title -->

		<div class="form-group flex mt-1 relative" id="search-box">
			<i class="fa fa-search mr-1"></i><input class="form-control upload p-2 shadow-none" type="text" placeholder="Search all products...">
		</div>

		<?php
			if (isset($_GET["new"]) && $_GET["new"] == "true") {
				$product_title = $_GET["product"];
				echo '
					<section class="w-93 success flex-center ai-center no-break my-2 mb-3 new">
						<section class="w-90 m-auto">
							<p class="alert text-center">' . $product_title . ' created sucessfully.</p> 
						</section>
					</section>
				';
			} elseif (isset($_GET["edit"])) {
				$product_title = $_GET["edit"];
				echo '
					<section class="w-93 success flex-center ai-center no-break my-2 mb-3 new">
						<section class="w-90 m-auto">
							<p class="alert text-center">' . $product_title . ' edited sucessfully.</p> 
						</section>
					</section>
				';
			} 
		?>

		<section class="section dashboard mt-4">
			<?php
				global $db;
				$sql = "SELECT * FROM `products` ORDER BY ID DESC";
				$query = $db->prepare($sql);
				$query->execute();
				
				if ($query->rowCount() > 0) {  ?>
					<section class="grid-3" id="all-course-list">
						<?php while ($product_data = $query->fetch(PDO::FETCH_ASSOC)):?>

							<div class="hover-card info-card sales-card">
								<section>
									<img src="uploads/products/<?= $product_data["image"] ?>" class="w-100 h-2" alt="">
								</section>

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

									<div class="pt-2">
										<p class="xxsm b-5 black"><?= $product_data["title"] ?></p>
									</div>

									<div class="mt-3 flex-between ai-center no-break">
										<a href="edit-product.php?product=<?= $product_data["title"] ?>" class="a"><button class="study-btn">Edit Product</button></a>

										<a href="delete-product.php?product=<?= $product_data["title"] ?>" class="a"><button class="delete-butn">Delete Product</button></a>
									</div>
								</div>
							</div>
						<?php endwhile; ?>
					</section>

				<?php } else { ?>
					 <section class="my-5 py-3 center w-fit mx-auto">
						<i class="fa-solid fa-ranking-star primary fa-7x main"></i>
						<p class="md main">There are no Products yet.</p>
					</section>
				<?php }
			?>
		</section>

	</main><!-- End #main -->

	
	<?php 
	require_once("layout/admin-footer.php"); ?>