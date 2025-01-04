<?php
    // Message vars
    $msg = "";
    $msgClass = "";
    $register_ok = "";
    session_start();
	session_destroy();

    try {
        // Form Submit
        if (isset($_POST['submit'])) {
            require_once("config/function.php");

            $username    =  $_POST['username'];
            $email       =  $_POST['email'];
            $password    =  $_POST['password'];
            $passkey     =  $_POST["passkey"];
            $date        =  date('y-m-d');
            $register_ok =  1;

            // Form Validation
            if(!empty($username) && !empty($email) && !empty($password) && !empty($passkey)) {
                if($passkey != "Admin") {
                    $msg = "<i class='fa-solid fa-circle-exclamation'></i> Incorrect Passkey *";
                    $msgClass = "alert-danger";

                } elseif($username < 5) {
                    $msg = "<i class='fa-solid fa-circle-exclamation'></i> Username must be longer than 5 characters *";
                    $msgClass = "alert-danger";

                } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $msg = "<i class='fa-solid fa-circle-exclamation'></i> Please enter a valid email *";
                    $msgClass = "alert-warning";
                    
                } elseif(strlen($password) < 5) {
                    $msg = "<i class='fa-solid fa-circle-exclamation'></i> Password must be longer than 5 characters *";
                    $msgClass = "alert-warning";

                } else {
                    global $db;
                    $query = "SELECT * FROM `admins` WHERE `username` = :user AND `email` = :email";
                    $stmt = $db->prepare($query);
                    $stmt->execute([
                        ':user'  => $username,
                        ':email' => $email
                    ]);
                    $count = $stmt->rowCount();

                    if ($count == 1) {
                        $msg = "<i class='fa-solid fa-circle-exclamation'></i> User already registered *";
                        $msgClass = "danger";

                    } else {
                        try {
                            $password = password_hash($password, PASSWORD_DEFAULT);
                            $sql = "INSERT INTO admins (username, email, password, position, status) VALUES (:username, :email, :password, :position, :status)";
                            $stmt = $db->prepare($sql);
                            if ($stmt->execute([
                                ':username' => test_input($username),
                                ':email'    => test_input($email),
                                ':password' => test_input($password),
                                ':status' => "active",
                                ':position' => 1
                            ])) {
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                session_start();
                                $_SESSION['position'] = 'admin';
                                $_SESSION['user_id'] = $row['admin_id'];
                                $_SESSION['user'] = $row['username'];
                                $_SESSION['last_login_timestamp'] = time();
                                header('location: index/registered');
                                
                            } else {
                                $msg = "<i class='fa-solid fa-circle-exclamation'></i> Please check your details!!";
                                $msgClass = "danger";
                            }  

                        } catch (PDOException $e) {  }
                    }
                }

            } else {
                $msg = "Please fill in all fields!!";
                $msgClass = "danger";
            }
        }
    } catch (PDOException $e) {}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Create Admin Account - E-mine</title>
    <base href="http://localhost/php/E-mine/admin/" /> 
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/logo.jpg" />

    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <!-- <link rel="shortcut icon" type="image/x-icon" href="assets\img\ - favicon.png" /> -->

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style2.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/utilities2.css" />
    <link rel="stylesheet" href="assets/css/utilities_media_query2.css" />
</head>
<body>
	<main id="register">
		<div class="container">
			<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
							<!-- <div class="d-flex justify-content-center py-4 mobile-py-0">
								<a href="index" class="logo d-flex align-items-center w-auto">
								<img src="assets/img/logo.png" id="logo" alt="">
								</a>
							</div>End Logo -->

							<div class="card mb-3">
								<div class="card-body">
									<div class="pt-1 ">
										<h5 class="card-title text-center pb-0 fs-4 primary">Create an Account</h5>
										<p class="text-center small">Fill in your details to create account</p>
									</div>

									<?php if($msg != ''): ?>
										<div class="alert <?php echo $msgClass; ?>">
											<?php echo $msg; ?>
										</div>
									<?php endif; ?>


									<form class="row g-3 pb-3" method="post" id="login-form" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
										<div class="col-12">
											<label for="yourPassword" class="form-label">Admin Passkey:</label>
											<input type="text" name="passkey" class="form-" id="email" value="<?php if(isset($_POST['submit'])) {echo ($_POST['passkey']);}?>">
											<p id="emailErr" class="error"></p>
										</div>

										<div class="col-12">
											<label for="yourUsername" class="form-label">Username:</label>
											<div class="yourUsername has-validation ">
												<div class="flex input-group">
													<span class="input-group-text w-fit" id="inputGroupPrepend">@</span>
													<input type="text" name="username" class="" id="username" value="<?php if(isset($_POST['submit'])) {echo ($_POST['username']);}?>">
												</div>
												<p id="usernameErr" class="error"></p>
											</div>
										</div>

										<div class="col-12">
											<label for="yourPassword" class="form-label">Email:</label>
											<input type="email" name="email" class="form-" id="email" value="<?php if(isset($_POST['submit'])) {echo ($_POST['email']);}?>">
											<p id="emailErr" class="error"></p>
										</div>

										<div class="col-12">
											<label for="yourPassword" class="form-label">Password:</label>
											<input type="password" name="password" class="form-" id="password" value="<?php if(isset($_POST['submit'])) {echo ($_POST['password']);}?>">
											<i class="fa-solid fa-eye icon"></i>
											<p id="passwordErr" class="error"></p>
										</div>

										<div class="col-12">
											<button class="btn btn1 w-100" type="submit" name="submit">Create an account</button>
										</div>

										<div class="col-12" style="margin-top: 5px;">
											<p class="small mb-0" class="secondary">Login to your account? <a href="login.php" class="secondary">Login now</a></p>
										</div>
									</form>
								</div>
							</div>

							<div class="credits white">
                                E-mine &copy 2023 All rights reserved
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
  </main><!-- End #main -->

  	<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
	
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Main JS File -->
	<script src="assets/js/main.js"></script>


</body>

</html>