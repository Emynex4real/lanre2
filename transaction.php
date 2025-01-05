<?php 
	$page__css = '
		<link rel="stylesheet" href="css/transaction.css" />
        <link rel="stylesheet" href="css/navbar.css" />
	'; 

  require_once("layout/user-header.php"); ?>

    <main>
        <div class="transaction-panel">
            <p class="head">Transactions History</p>
        </div>

        <section class="transaction">
            <div class="categories-status">
                <select name="categories" id="category">
                    <option value="Categories">All Categories</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="April">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select>

                <select name="status" id="status">
                    <option value="Categories">Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Successful">Successful</option>
                    <option value="Failed">Failed</option>
                </select>
            </div>

            <div>
                <?php	
                    try {
                        global $db;
                        require_once("config/PPC.php");
                        $PPC = new PPCTransaction();
                        $transactions = $PPC->getUserTransactionHistory();

                        if (count($transactions) > 0) { 
                            foreach ($transactions as $transaction):  ?>

                            <?php endforeach;
                        }
                    } catch (PDOException $e) {}
                ?>

                <div class="transaction-container content mb-3">
                    <div class="date">
                        <p class="bold">13 December, 2024</p>
                    </div>

                    <div class="transaction-details">
                        <div class="details success">
                            <div class="info">
                                <i class="fas fa-arrow-down-long"></i>
                                <div class="name-time">
                                    <p class="name">Task Income</p>
                                    <p class="time">5.05 AM</p>
                                </div>
                            </div>

                            <div class="price-status">
                                <p class="price">
                                    +$350
                                </p>

                                <p class="status" style="font-size: 14px;">
                                    Success
                                </p>
                            </div>
                        </div>

                        <hr>
                        <div class="details withdraw">
                            <div class="info">
                                <i class="fas fa-arrow-up-long"></i>
                                <div class="name-time">
                                    <p class="name">Income Withdraw</p>
                                    <p class="time">5.05 AM</p>
                                </div>
                            </div>
                            <div class="price-status">
                                <p class="price">
                                    -$250
                                </p>
                                <p class="status">
                                    Success
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="details pending">
                            <div class="info">
                                <i class="fas fa-hourglass"></i>
                                <div class="name-time">
                                    <p class="name">Task Income</p>
                                    <p class="time">5.05 AM</p>
                                </div>
                            </div>
                            <div class="price-status">
                                <p class="price">
                                    +$50
                                </p>
                                <p class="status">
                                    Pending
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="details fail">
                            <div class="info">
                                <i class="fas fa-exclamation"></i>
                                <div class="name-time">
                                    <p class="name">VIP 3 Subscription</p>
                                    <p class="time">5.05 AM</p>
                                </div>
                            </div>
                            <div class="price-status">
                                <p class="price">
                                    $100
                                </p>
                                <p class="status">
                                    Fail
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>
    </main>

    <script src="js/navbar.js"></script>
</body>
</html>