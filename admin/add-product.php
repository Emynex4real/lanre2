<?php 		
	$page_title = "Add Product";

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

	$product_imageErr = "";
	
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
        $target_file = $target_dir .basename($img);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $uploadOk = 1;


        // IF IMAGE ALREADY EXISTS
        if(empty($img)) {
            $uploadOk = 0;
            $product_imageErr = "<i class='fa-solid fa-circle-exclamation'></i> Field is Required.";

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

		echo $uploadOk;


		// CHECK IF THERE IS NO POST IMAGE ERROR ISSUE
		if ($uploadOk == "1") {
			// CREATE NEW COURSE IF IMAGE HAS BEEN UPLOADED
			if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
				try {
					$sql = "INSERT INTO products (`title`, `image`, `price`, `period`, `daily_income`, `total_revenue`, `description`) VALUES (:title, :image, :price, :period, :daily_income, :total_revenue, :description)";
					$query = $db->prepare($sql);
					if ($query->execute(array(
						':title' => $product_title,
						':image' => $img,
						':price' => $product_price,
						':daily_income' => $daily_income,
						':period' => $cycle_period,
						':total_revenue' => $total_revenue,
						':description' => $product_description
					))) {
						header("Location: products.php?product=$product_title&new=true");
					}
				} catch (PDOException $e)  {
					echo $e;
				}
			} 
		}
	} 
	
	require_once("layout/admin-header.php"); ?>


	<main id="main" class="main">
		<div class="pagetitle">
			<h1>Add Course</h1>
			<nav>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item active">Add Product</li>
				</ol>
			</nav>
		</div><!-- End Page Title -->

		<section class="section dashboard form">
			<div class="card p-3 mobile-p-1 mobile-mt-m-1">
				<div class="card-body">
					<h5 class="card-title">Add Product</h5>

					<!-- Vertical Form -->
					<form class="row g-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="create-form" enctype="multipart/form-data">
						<div class="flex-between">
							<div class="w-47 tablet-w-100 tablet-mb-1">
								<input type="text" class="form-control shadow-none none" placeholder="Enter product title e.g Basin" id="title" name="title">
								<p class="error" id="titleErr"></p>
							</div>
			
							<div class="w-47 tablet-w-100 tablet-mb-1">
								<input type="text" class="form-control shadow-none none" placeholder="Enter Product price e.g 4000" id="price" name="price">
								<p class="error" id="priceErr"></p>
							</div>
						</div>

						<div class="flex-between">
							<div class="w-47 tablet-w-100 tablet-mb-1">
								<input type="text" class="form-control shadow-none" placeholder="(₦) Enter daily income e.g 160" id="daily-income" name="daily-income">
								<p id="daily-incomeErr" class="error"></p>
							</div>

							<div class="w-47 tablet-w-100 tablet-mb-1">
								<input type="text" class="form-control shadow-none" placeholder="Enter cycle period e.g 44" id="cycle-period" name="cycle-period">
								<p class="error" id="cycle-periodErr"></p>
							</div>
						</div>

						<div class="col-12">
							<label class="xsm">Cover image:</label>
							<input type="file" class="form-control shadow-none" id="image" name="product_image">
							<p class="error" id="imageErr"><?php if(!empty($product_imageErr)) {$product_imageErr;};?></p>
						</div>

						<div class="col-12">
							<textarea class="form-control shadow-none" placeholder="Enter product description" id="description" name="description" style="resize:none" cols="30" rows="10"></textarea>
							<p class="error" id="descriptionErr"></p>
						</div>

						<div class="mt-0 my-2">
							<button type="submit" class="btn1" id="add-product" name="add_product">Create product</button>
						</div>
					</form><!-- Vertical Form -->
				</div>
			</div>
		</section>
	</main><!-- End #main -->

	<script src="assets/js/product.js"></script>

	<?php 
	require_once("layout/admin-footer.php");
?>