<?php 
	$page__css = '
    	<link rel="stylesheet" href="css/profile.css" />
	    <link rel="stylesheet" href="css/navbar.css" />
	'; 

    	
	try {
		global $db;
		require_once("config/PPC.php");
		$user = new PPCUser($user);
		$user_details = $user->getUserDetails();

	} catch (PDOException $e) {}

	require_once("layout/user-header.php"); ?>

    <main>
        <div class="dashboard-panel">
            <p class="head">Create Withdrawal Request</p>
        </div>

        <div class="alert success mb-3 d-none" id="withdrawalSuccess">
            <p class="alert pl-2">Withdrawal request initiated successfully</p>
        </div>

        <div class="alert danger mb-3 d-none" id="withdrawalFailed">
            <p class="alert pl-2">Please check all inputs</p>
        </div>

        <section class="dashboard">
            <form class="withdrawal-form" id="profile-form">
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
                    <input type="number" id="acctNumber" name="password" placeholder="Enter your Account number"  />
                    <p class="danger-text" id="acctNumberErr"></p>
                </div>

                <div class="form-group">
                    <label for="acctName">Account Name</label>
                    <input type="text" id="acctName" name="password" id="acctName" placeholder="Enter your Account name"  />
                    <p class="danger-text" id="acctNameErr"></p>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="save-btn">Create request</button>
                </div>
            </form>
        </section>
    </main>

    <script src="js/withdrawal.js"></script>
    <script src="js/navbar.js"></script>
</body>
</html>