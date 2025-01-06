<?php 
	$page__css = '
    	<link rel="stylesheet" href="css/profile.css" />
	    <link rel="stylesheet" href="css/navbar.css" />
	'; 
    require_once("config/session.php");
    $page__title = "Edit Profile";

	try {
		global $db;
		require_once("config/PPC.php");
		$user = new PPCUser($user_id);
		$user_details = $user->getUserDetails();

	} catch (PDOException $e) {}

	require_once("layout/user-header.php"); ?>

    <main>
        <div class="dashboard-panel">
            <p class="head">Edit Profile</p>
        </div>

        <div class="alert success mb-3 d-none" id="profileSuccess">
            <p class="alert pl-2">Profile updated successfully</p>
        </div>

        <div class="alert danger mb-3 d-none" id="profileFailed">
            <p class="alert pl-2">Please check all inputs</p>
        </div>

        <section class="dashboard">
            <form class="profile-form" id="profile-form">
                <!-- Full Name -->
                <div class="form-group">
                    <label for="fullName">Username</label>
                    <input type="text" id="username" name="username" value="<?= $user_details["username"] ?>" placeholder="Enter your user name" />
                    <p class="danger-text" id="usernameErr"></p>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="<?= $user_details["email"] ?>" name="email" placeholder="Enter your email" />
                    <p class="danger-text" id="emailErr"></p>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password"  />
                    <p class="danger-text" id="passowordErr"></p>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="save-btn">Save Changes</button>
                </div>
            </form>
        </section>
    </main>

    <script src="js/profile.js"></script>
    <script src="js/navbar.js"></script>
</body>
</html>