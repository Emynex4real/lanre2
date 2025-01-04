<?php 
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

	$product_title = str_replace("-", " ", $_GET["product"]);
	$page_title = "Edit " . $product_title; 
	$product_imageErr = $uploaded = "";
	$updated = 0;

	if (isset($_GET['product'])) {
		try {
			$sql = "SELECT * FROM `products` WHERE title = :title";
			$query = $db->prepare($sql);
			$query->execute([':title' => $product_title]);
			$product_data = $query->fetch(PDO::FETCH_ASSOC);

		} catch (PDOException $e) {	};
			
		if (isset($_POST["title"])) {
			$product_title = $_POST["title"];
			$cycle_period = (int) $_POST["cycle-period"];
			$product_price = $_POST["price"];
			$daily_income = (int) $_POST["daily-income"];
			$total_revenue = ($cycle_period * $daily_income);
			$product_description = $_POST["description"];
	
	
			// VALIDATE IMAGE
			$target_dir = "uploads/products/";
			$img = $_FILES["product_image"]["name"];
			$target_file = $target_dir.basename($img);
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$uploadOk = 1;
			$current_product_image = $product_data["image"];
	
	
			// IF IMAGE ALREADY EXISTS
			$update_image = "";
			if(empty($img)) {
				$uploadOk = 1;
				$use_current_product_image = "";
				$img = $current_product_image;
	
			} // IF IT IS A FAKE IMAGE
			elseif($check = getimagesize($_FILES["product_image"]["tmp_name"])){
				if ($check !== false) {
					$uploadOk = 1;
				} else {
					$product_imageErr = "<i class='fa-solid fa-circle-exclamation'></i> File is not an Image.";
					$uploadOk = 0;
				} 
			} // CHECK IF FILE EXISTS
			elseif (file_exists($target_file)) {
				$product_imageErr = "<i class='fa-solid fa-circle-exclamation'></i> Sorry, File already exists";
				$uploadOk = 0;
			} // CHOOSE FILE FORMAT 
			elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
				$product_imageErr = "<i class='fa-solid fa-circle-exclamation'></i> Sorry, The image has to be Jpeg, Jpg, Png or Gif";
				$uploadOk = 0;
			} // IF IMAGE IS TOO LARGE
			elseif ($_FILES["product_image"]["size"] > 500000 ) {
				$product_imageErr = "<i class='fa-solid fa-circle-exclamation'></i> Sorry, this file is too large.";
				$uploadOk = 0;
			} 	
	
	
			// CHECK IF THERE IS NO POST IMAGE ERROR ISSUE
			if ($uploadOk == "1") {
				
				// CHECK IF USER IS UPLOADING NEW IMAGE OR USING FORMER IMAGE 
				if (!isset($use_current_product_image)) {
					if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
						$uploaded = 1;
					} else {
						$uploaded = 0;
					}
				} else {
					$uploaded = 1;
				}


				if ($uploaded == "1") {
					try {
						$sql = "UPDATE `products` SET `title` = :title, `image` = :image, price = :price, `daily_income` = :daily_income, `period` = :period, `total_revenue` = :total_revenue, `description` = :description WHERE id = :id";
						$query = $db->prepare($sql);
						if ($query->execute(array(
							':title' => $product_title,
							':image' => $img,
							':id'    => $product_data["id"],
							':price' => $product_price,
							':daily_income' => $daily_income,
							':period' => $cycle_period,
							':total_revenue' => $total_revenue,
							':description' => $product_description
						))) { 
							$updated = 1;
							header("Location: products.php?edit=$product_title");
						 }
					} catch (PDOException $e)  {
						echo $e;
					}
				}
			}
		}
	} else {
		echo "<script>history.go(-1)</script>";
	}
	
	require_once("layout/admin-header.php"); ?>


	<main id="main" class="main">
		<div class="pagetitle">
			<nav>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item"><a href="products.php">Mercahndise</a></li>
					<li class="breadcrumb-item active">Edit <?= $product_title; ?></li>
				</ol>
			</nav>
		</div><!-- End Page Title -->

		<section class="section dashboard form">
			<section class="flex-between ai-center mb-4">
				<h4 class="tablet-pb-2 secondary">Edit <?= $product_title; ?></h4>
			</section>

			<div class="card p-3 mobile-p-1">
				<div class="card-body">
					<h5 class="card-title">Edit product</h5>

					<!-- Vertical Form -->
					<form class="row g-3" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>?product=<?= $product_title ?>" method="POST" id="create-form" enctype="multipart/form-data">
						<div class="flex-between">
							<div class="w-47 tablet-w-100 tablet-mb-1">
								<input type="text" class="form-control shadow-none none" placeholder="Enter product title e.g Basin" id="title" value="<?= $product_data["title"] ?>" name="title">
								<p class="error" id="titleErr"></p>
							</div>
			
							<div class="w-47 tablet-w-100 tablet-mb-1">
								<input type="text" class="form-control shadow-none none" placeholder="Enter Product price e.g 4000" id="price" value="<?= $product_data["price"] ?>" name="price">
								<p class="error" id="priceErr"></p>
							</div>
						</div>

						<div class="flex-between">
							<div class="w-47 tablet-w-100 tablet-mb-1">
								<input type="text" class="form-control shadow-none" placeholder="(₦) Enter daily income e.g 160" value="<?= $product_data["daily_income"] ?>" id="daily-income" name="daily-income">
								<p id="daily-incomeErr" class="error"></p>
							</div>

							<div class="w-47 tablet-w-100 tablet-mb-1">
								<input type="text" class="form-control shadow-none" placeholder="Enter cycle period e.g 44" id="cycle-period"  value="<?= $product_data["period"] ?>" name="cycle-period">
								<p class="error" id="cycle-periodErr"></p>
							</div>
						</div>

						<div class="col-12">
							<label class="xsm">Cover image:</label>
							<input type="file" class="form-control shadow-none" id="image" name="product_image">
							<p class="error" id="imageErr"><?php if(!empty($product_imageErr)) {$product_imageErr;};?></p>
						</div>

						<div class="col-12">
							<textarea class="form-control shadow-none" placeholder="Enter product description" id="description" name="description" style="resize:none" cols="30" rows="10"><?= $product_data["description"] ?></textarea>
							<p class="error" id="descriptionErr"></p>
						</div>

						<div class="mt-0 my-2">
							<button type="submit" class="btn1" id="edit-Product" name="edit_product">Update product</button>
						</div>
					</form>
				</div>
			</div>
		</section>

	</main><!-- End #main -->

	<script src="assets/js/product.js"></script>

	<?php 
	require_once("layout/admin-footer.php"); ?>