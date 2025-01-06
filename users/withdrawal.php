<?php 
	$page__css = '
    	<link rel="stylesheet" href="css/profile.css" />
	    <link rel="stylesheet" href="css/navbar.css" />
	'; 

    	
	try {
		global $db;
		require_once("config/PPC.php");
		$user = new PPCUser($user_id);
		$user_details = $user->getUserDetails();

	} catch (PDOException $e) {}

	require_once("layout/user-header.php"); ?>

    <main>
        <div class="dashboard-panel">
            <p class="head">Create Withdrawal Request</p>
        </div>

        <div id="referral_box" class="flex-between mobile-mt-0 mobile-mb-0 ai-center no-break mb-5 mt-3 mobile-p-1 relative">
            <div class="w-60 mobile-w-100">
                <h3 class="mb-1 m-0 b-3 md white mobile-xsm" style="color: #fff;">Withraw your E-mine earnings</h3>
                <ul>
                    <li>Minimum withdrawal is ₦5,000.00</li>
                    <li>No withdrawal during weekends</li>
                    <li>Withdawal takes 0 - 24hours on weekdays</li>
                </ul>
            </div>

            <img src="images/withdrawal.png" alt="">
        </div>

        <div class="alert success mb-3 d-none" id="withdrawalSuccess">
            <p class="alert pl-2">Withdrawal request initiated successfully</p>
        </div>

        <div class="alert danger mb-3 d-none" id="withdrawalFailed">
            <p class="alert pl-2">Please check all inputs</p>
        </div>

        <section class="dashboard">
            <form class="profile-form" id="withdrawal-form">
                <div class="form-group">
                    <label for="bankName">Amount</label>
                    <input type="number" id="amount" name="amount" placeholder="Enter your amount you want to withdraw"  />
                    <p class="danger-text" id="amountErr"></p>
                </div>

                <div class="form-group">
                    <label for="bankName">Bank Number</label>
                    <input type="text" id="bankName" name="bankName" placeholder="Enter your Bank name"  />
                    <p class="danger-text" id="bankNameErr"></p>
                </div>

                <div class="form-group">
                    <label for="acctNumber">Account Number</label>
                    <input type="number" id="acctNumber" name="acctNumber" placeholder="Enter your Account number"  />
                    <p class="danger-text" id="acctNumberErr"></p>
                </div>

                <div class="form-group">
                    <label for="acctName">Account Name</label>
                    <input type="text" id="acctName" name="acctName" placeholder="Enter your Account name"  />
                    <p class="danger-text" id="acctNameErr"></p>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="save-btn">Withdraw now</button>
                </div>
            </form>
        </section>
    </main>

    <script src="js/withdrawal.js"></script>
    <script src="js/navbar.js"></script>
</body>
</html>