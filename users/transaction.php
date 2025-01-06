<?php 
	$page__css = '
		<link rel="stylesheet" href="css/transaction.css" />
        <link rel="stylesheet" href="css/navbar.css" />
	'; 	
    $page__title = "My  Transactions";

	require_once("config/session.php");
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
                        $PPC = new PPCTransaction($user_id);
                        $transactions = $PPC->getUserTransactionHistory();

                        if (count($transactions) > 0) { 
                            // Initialize a multidimensional array to hold results grouped by date
                            $transactionsPerDay = [];
                        
                            // Fetch and loop through the results
                            foreach ($transactions  as $transaction) {
                                // Extract the date part from created_on (Y-m-d format)
                                $transactionDate = date('Y-m-d', strtotime($transaction['created_on']));
                        
                                // Group the withdrawals by date and append each row under the date key
                                $transactionPerDay[$transactionDate][] = $transaction;
                            }
                        
                            foreach ($transactionPerDay as $date => $all_transaction_this_date): ?>
                                <div class="transaction-container content">
                                    <div class="date">
                                        <p class="bold"><?= format_timestamp_Date($date )?></p>
                                    </div>

                                    <?php foreach ($all_transaction_this_date as $transaction): ?>
                                        <div class="transaction-details w-100">
                                            <div class="details w-100 <?= $transaction["status"] ?>">
                                                <div class="info">
                                                    <?php if ($transaction["status"] != "failed") { ?>
                                                        <?php if ($transaction["transaction_type"] == "income") { ?>
                                                            <i class="fas fa-arrow-down-long"></i>
                                                        <?php } elseif ($transaction["transaction_type"] == "withdrawal") { ?>
                                                            <i class="fas fa-arrow-up-long"></i>
                                                        <?php } elseif ($transaction["transaction_type"] == "referrals") { ?>
                                                            <i class="fas fa-share"></i>
                                                        <?php } else { ?>
                                                            <i class="fas fa-hourglass"></i>
                                                        <?php } 
                                                    } else { ?>
                                                        <i class="fas fa-exclamation"></i>
                                                    <?php } ?>
                                                        
                                                    <div class="name-time">
                                                        <p class="name"><?= ucfirst($transaction["description"]) ?></p>
                                                        <p class="time"><?= get_transaction_time($transaction["created_on"]) ?></p>
                                                    </div>
                                                </div>

                                                <div class="price-status">
                                                    <p class="price">
                                                        +₦<?= number_format($transaction["amount"]) ?>
                                                    </p>

                                                    <p class="status" style="font-size: 14px;">
                                                        <?= ucfirst($transaction["status"]) ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach;
                        }
                    } catch (PDOException $e) {}
                ?>
            </div>

        </section>
    </main>

    <script src="js/navbar.js"></script>
</body>
</html>