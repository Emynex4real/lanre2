<?php
	session_start();
	session_destroy();

    // Message vars
    $msg = "";
    $msgClass = "";
    $register_ok = "";

    // Form Submit
    if (isset($_POST['submit'])) {
        require_once("config/admin_login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <base href="https://emine.com.ng/" /> 
  <link rel="shortcut icon" type="image/x-icon" href="../assets/img/logo.jpg" />
  <title>Admin Login - E-mine</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <!-- <link rel="shortcut icon" type="image/x-icon" href="assets\img\" /> -->

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/utilities_media_query.css" />
	<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
	/>

	<!-- Template Main CSS File -->
	<link href="assets/css/style2.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/utilities2.css" />
	<link rel="stylesheet" href="assets/css/utilities_media_query2.css" />
	<style>
	    #register .btn1.btn {
            color: #fff !important;
			background-color: var(--primary-color);
        }
        
        #register .btn1.btn:hover {
            background-color: var(--dark) !important;
        }

		.relative {
			position: relative !important;
			margin-bottom: 0 !important;
		}

		#password-visibility {
			top: 42px;
			color: var(--light);
			cursor: pointer;
			right: 25px;
		}

		#password-visibility i:hover {
			transition: 0.3s all ease-in-out;
			color: var(--dark);
		}
	</style>
</head>

<body>
	<main id="register">
		<div class="container">
			<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
							<div class="card mb-3">
								<div class="card-body">
									<div class="pt-1 ">
										<h5 class="card-title text-center pb-0 fs-4 primary">Login to Account</h5>
										<p class="text-center small">Fill in your details to login to Admin account</p>
									</div>

									<?php if ($msg != ''): ?>
										<div class="alert <?php echo $msgClass; ?>">
										<p class="alert"><?php echo $msg; ?></p>
										</div>
									<?php elseif (isset($_GET["logout"])): ?>
										<div class="alert danger">
											<p class="alert">You have successfully logged out of your account</p>
										</div>
									<?php endif ?>


									<form class="row g-3 pb-3" method="post" id="login-form" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
										<div class="col-12">
											<label for="yourUsername" class="form-label">Username:</label>
											<div class="yourUsername has-validation ">
												<div class="flex input-group">
													<span class="input-group-text w-fit" id="inputGroupPrepend">@</span>
													<input type="text" name="username" id="username" value="<?php if(isset($_POST['submit'])) {echo ($_POST['username']);}?>">
												</div>
												<p id="usernameErr" class="error"></p>
											</div>
										</div>

										<div class="col-12 relative">
											<label for="yourPassword" class="form-label">Password:</label>
											<section id="password-visibility" class="absolute" onclick="toogleEye()">
												<i class="fa-sharp fa-solid fa-eye-slash" id="toogle-eye"></i>
											</section>

											<input type="password" name="password" class="form-" id="password" value="<?php if(isset($_POST['submit'])) {echo ($_POST['password']);}?>">
											<p id="passwordErr" class="error"></p>
										</div>

										<div class="col-12">
											<button class="btn btn1 w-100" type="submit" name="submit">Login to account</button>
										</div>

										<div class="col-12" style="margin-top: 5px;">
											<p class="small mb-0" class="secondary">Create admin account? <a href="register.php" class="secondary">Register now</a></p>
										</div>
									</form>
								</div>
							</div>

							<div class="credits white">
								E-mine &copy <?= date("Y") ?> All rights reserved
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
    </main><!-- End #main -->

  	<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
	
	<script>
		// TOGGLE EYE VISIBILITY
		function toogleEye() {
			var eye = document.getElementById("toogle-eye");
			var password = document.getElementById("password");
			var new_password = document.getElementById("new_password");
			var confirm_password = document.getElementById("confirm_password");

			// TOOGLE PASSWORD
			if (password) {
				if (password.type === "password") {
					password.type = "text";
					eye.classList.remove("fa-eye");
					eye.classList.add("fa-eye-slash");
				} else {
					password.type = "password";
					eye.classList.remove("fa-eye-slash");
					eye.classList.add("fa-eye");
				}
			}

			// TOOGLE NEW PASSWORD
			if (new_password) {
				if (new_password.type === "password") {
					new_password.type = "text";
					eye.classList.remove("fa-eye");
					eye.classList.add("fa-eye-slash");
				} else {
					new_password.type = "password";
					eye.classList.remove("fa-eye-slash");
					eye.classList.add("fa-eye");
				}
			}

			// TOOGLE CONFIRM PASSWORD
			if (confirm_password) {
				if (confirm_password.type === "password") {
					confirm_password.type = "text";
					eye.classList.remove("fa-eye");
					eye.classList.add("fa-eye-slash");
				} else {
					confirm_password.type = "password";
					eye.classList.remove("fa-eye-slash");
					eye.classList.add("fa-eye");
				}
			}
		}
	</script>

	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Main JS File -->
	<script src="assets/js/main.js"></script>
</body>

</html>