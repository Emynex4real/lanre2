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
        $user_bank_details = $user->get_user_bank_details();
        $user_social_details = $user->get_user_social_accounts();
		$user_details = $user->getUserDetails();

	} catch (PDOException $e) {}

	require_once("layout/user-header.php"); ?>

    <main>
        <div class="dashboard-panel">
            <p class="head">Edit Profile</p>
        </div>

        <section class="dashboard">
            <section class="profile-form-container">
                <form class="profile-form" id="profile-form">
                    <p class="md mb-3 profile-headline">Update Profile</p>

                    <div class="alert success mb-3 d-none w-100" id="profileSuccess">
                        <p class="alert pl-2">Profile updated successfully</p>
                    </div>

                    <div class="alert danger mb-3 d-none w-100" id="profileFailed">
                        <p class="alert pl-2">Please check all inputs</p>
                    </div>

                    <input type="hidden" name="user_id" value="<?= $_SESSION["user_id"] ?>">

                    <!-- Full Name -->
                    <div class="form-group" style="margin-top: 20px;">
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
                        <label for="image">Profile Image</label>
                        <?php if (!empty($user_details["image"])) { ?>
                            <img src="uploads/users/<?= $user_details["image"] ?>" id="userImage" style="width: 120px; height: 120px; border-radius: 50%;" alt="">
                        <?php } else { ?>
                            <img src="" id="userImage" style="width: 120px; height: 120px; border-radius: 50%; display: none; margin-bottom: 15px;" alt="">
                            <p class="profile-img" id="nameImage"><?= ucfirst(substr($user_details["username"], 0, 1)) ?></p>
                        <?php } ?>
                        <input type="file" id="image" name="image" />
                        <p class="danger-text" id="imageErr"></p>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" class="save-btn" id="profile-button">Save Changes</button>
                    </div>
                </form>
            </section>

            <section class="profile-form-container">
                <form class="profile-form" id="bank-settings-form">
                    <p class="profile-headline mb-3 md">Bank Settings</p>

                    <div class="alert success mb-3 d-none w-100" id="bankSuccess">
                        <p class="alert pl-2">Bank settings updated successfully</p>
                    </div>

                    <div class="alert danger mb-3 d-none w-100" id="bankFailed">
                        <p class="alert pl-2">Please check all inputs</p>
                    </div>

                    <input type="hidden" name="user_id" value="<?= $_SESSION["user_id"] ?>">

                    <!-- Full Name -->
                    <div class="form-group" style="margin-top: 20px;">
                        <label for="fullName">Bank Name</label>
                            <select name="bank_name" id="bank_name" class="form-control" style="border:1px solid #dcdcdc !important;">
                                <?php if (isset($user_bank_details["bank_name"])) { ?>
                                    <option value="<?= $user_bank_details["bank_name"]; ?>" selected><?= $user_bank_details["bank_name"]; ?></option>
                                <?php } else { ?>
                                    <option class="text-black" value="">--- Choose Bank name ---</option>
                                <?php } ?>
                                <option class="text-black" value="Access Bank"  >Access Bank</option>
                                <option class="text-black" value="Citi Bank"  >Citi Bank</option>
                                <option class="text-black" value="EcoBank PLC"  >EcoBank PLC</option>
                                <option class="text-black" value="First Bank PLC"  >First Bank PLC</option>
                                <option class="text-black" value="First City Monument Bank"  >First City Monument Bank</option>
                                <option class="text-black" value="Fidelity Bank"  >Fidelity Bank</option>
                                <option class="text-black" value="Guaranty Trust Bank"  >Guaranty Trust Bank</option>
                                <option class="text-black" value="Polaris bank"  >Polaris bank</option>
                                <option class="text-black" value="Stanbic IBTC Bank"  >Stanbic IBTC Bank</option>
                                <option class="text-black" value="Standard Chaterted bank PLC"  >Standard Chaterted bank PLC</option>
                                <option class="text-black" value="Sterling Bank PLC"  >Sterling Bank PLC</option>
                                <option class="text-black" value="United Bank for Africa"  >United Bank for Africa</option>
                                <option class="text-black" value="Union Bank PLC"  >Union Bank PLC</option>
                                <option class="text-black" value="Wema Bank PLC"  >Wema Bank PLC</option>
                                <option class="text-black" value="Zenith bank PLC"  >Zenith bank PLC</option>
                                <option class="text-black" value="Unity Bank PLC"  >Unity Bank PLC</option>
                                <option class="text-black" value="Providus Bank PLC"  >Providus Bank PLC</option>
                                <option class="text-black" value="Keystone Bank"  >Keystone Bank</option>
                                <option class="text-black" value="Jaiz Bank"  >Jaiz Bank</option>
                                <option class="text-black" value="Heritage Bank"  >Heritage Bank</option>
                                <option class="text-black" value="Kuda"  >Kuda</option>
                                <option class="text-black" value="VFD Micro Finance Bank"  >VFD Micro Finance Bank</option>
                                <option class="text-black" value="PALMPAY"  >PALMPAY</option>
                                <option class="text-black" value="Opay"  >Opay (Paycom)</option>
                                <option class="text-black" value="Moniepoint Microfinance Bank"  >Moniepoint Microfinance Bank</option>
                            </select>
                        <p class="danger-text" id="bank_nameErr"></p>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="name">Account Name</label>
                        <input type="text" name="account_name" value="<?php if (isset($user_bank_details["account_name"])) { echo $user_bank_details["account_name"]; } ?>" name="account_name" placeholder="Enter the name on the bank Account" />
                        <p class="danger-text" id="account_nameErr"></p>
                    </div>

                    <div class="form-group">
                        <label for="name">Account Number</label>
                        <input type="text" name="account_number" value="<?php if (isset($user_bank_details["account_number"])) { echo $user_bank_details["account_name"]; } ?>" name="account_number" placeholder="Enter the account number" />
                        <p class="danger-text" id="account_numberErr"></p>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" class="save-btn" id="bank-button">Save Changes</button>
                    </div>
                </form>
            </section>

            <section class="profile-form-container">
                <form class="profile-form" id="social-accounts-form">
                    <p class="md mb-3 profile-headline">Social Accounts</p>

                    <div class="alert success mb-3 d-none w-100" id="socialSuccess">
                        <p class="alert pl-2">Social Accounts updated successfully</p>
                    </div>

                    <div class="alert danger mb-3 d-none w-100" id="socialFailed">
                        <p class="alert pl-2">Please check all inputs</p>
                    </div>

                    <input type="hidden" name="user_id" value="<?= $_SESSION["user_id"] ?>">

                    <div class="mb-3" style="margin-top: 20px;">
                        <ul>
                            <li>Our team will check to see if your ink is correct</li>
                            <li>All links should follow the format <b class="b-3">https://social.com/Username</b></li>
                            <li>Submit correct and active Whatsapp Number</li>
                        </ul>
                    </div>
                
                    <div class="form-group">
                        <label for="Facebook">Facebook Link</label>
                        <input type="url" id="facebook" name="facebook" placeholder="Enter your facebook profile link" />
                        <p class="danger-text" id="facebookErr"></p>
                    </div>

                    <div class="form-group">
                        <label for="Facebook">Instagram Link</label>
                        <input type="url" id="instagram" name="instagram" placeholder="Enter your instagram profile link" />
                        <p class="danger-text" id="instagramErr"></p>
                    </div>

                    <div class="form-group">
                        <label for="Twitter">Twitter Link</label>
                        <input type="url" id="twitter" name="twitter" placeholder="Enter your twitter profile link" />
                        <p class="danger-text" id="twitterErr"></p>
                    </div>

                    <div class="form-group">
                        <label for="whatsapp">Whatsapp Number</label>
                        <input type="number" id="whatsapp" name="whatsapp" placeholder="Enter your active whatsapp number" />
                        <p class="danger-text" id="whatsappErr"></p>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" class="save-btn" id="social-button">Save Changes</button>
                    </div>
                </form>
            </section>

            <section class="profile-form-container">
                <form class="profile-form" id="change-password-form">
                    <p class="md mb-3 profile-headline">Change Password</p>

                    <div class="alert success mb-3 d-none w-100" id="passwordSuccess">
                        <p class="alert pl-2">Password updated successfully</p>
                    </div>

                    <div class="alert danger mb-3 d-none w-100" id="passwordFailed">
                        <p class="alert pl-2">Please check all inputs</p>
                    </div>

                    <input type="hidden" name="user_id" value="<?= $_SESSION["user_id"] ?>">

                    <!-- Full Name -->
                    <div class="form-group" style="margin-top: 20px;">
                        <label for="password">Current Password</label>
                        <input type="text" id="password" name="password" placeholder="Enter your current password" />
                        <p class="danger-text" id="passwordErr"></p>
                    </div>

                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="text" id="new_password" name="new_password" placeholder="Enter a new password" />
                        <p class="danger-text" id="new_passwordErr"></p>
                    </div>

                    <div class="form-group">
                        <label for="password">Confirm Password</label>
                        <input type="text" id="cpassword" name="cpassword" placeholder="Re-enter new password" />
                        <p class="danger-text" id="cpasswordErr"></p>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" class="save-btn" id="password-button">Save Changes</button>
                    </div>
                </form>
            </section>
        </section>
    </main>

    <script src="js/profile.js"></script>
    <script src="js/navbar.js"></script>
</body>
</html>