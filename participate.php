<?php 
	$page__css = '
		<link rel="stylesheet" href="css/participate.css" />
		<link rel="stylesheet" href="css/navbar.css" />
	';

    if ($_GET["ad_id"]) {
        $ad_id = $_GET["ad_id"];
        require_once("config/PPC.php");
        $PPC = new PPCAd();
        $ad = $PPC->getAdById($ad_id);
    } else {
        go_back();
    }

	require_once("layout/user-header.php"); ?>


    <main>
        <div class="participate-panel">
            <p class="head">Tasks</p>
        </div>

        <section class="participate-task">
            <div class="participate-container">
                <div class="participate-text">
                    <div class="name">
                        <p class="head">Name</p>
                        <div class="text"><?= ucfirst($ad["ad_name"]) ?></div>
                    </div>

                    <div class="name">
                        <p class="head">Reward</p>
                        <div class="text"><?= number_format($ad["cost_per_click"]) ?></div>
                    </div>

                    <div class="name">
                        <p class="head">Allowed Attempts</p>
                        <div class="text"><?= $ad["max_attempt"] ?></div>
                    </div>
                    <div class="name">
                        <p class="head">Already Attempted</p>
                        <div class="text"><?= $ad["clicks"] ?></div>
                    </div>

                    <div class="name">
                        <p class="head">Description</p>
                        <div class="text"><?= ucfirst($ad["cost_per_click"]) ?></div>
                    </div>

                    <?php if ($ad["status"] == "active") { 
                        $PPC = new PPCClick();

                        $user_has_participation_count = $PPC->checkUserClickRecordByAd($ad_id, 3); 

                        if ($user_has_participation_count > 0) { ?>
                            <button class="start-task">Participated</button>
                        <?php } elseif ($ad["clicks"] >= $ad["max_attempt"]) { ?>
                            <button class="start-task">Ended</button>
                        <?php } else { ?>
                            <button class="start-task" id="view-advert">Start Task</button>
                        <?php } ?>

                    <?php } else { ?>
                        <button class="start-task">Inactive</button>
                    <?php } ?>
                </div>
            </div>

            <div class="participate-container1">
                <div class="panel">
                    <p class="head">Atempted Members</p>
                    <p class="number p-1 br-3"><?= ($ad["cost_per_click"] >= 100) ? "100+" : $ad["cost_per_click"] ?></p>
                </div>

                <div class="members">
                    <div class="line">
                        <i class="fas fa-user"></i>
                        <i class="fas fa-user"></i>
                        <i class="fas fa-user"></i>
                        <i class="fas fa-user"></i>
                    </div>

                    <div class="line">
                        <i class="fas fa-user"></i>
                        <i class="fas fa-user"></i>
                        <i class="fas fa-user"></i>
                        <i class="fas fa-user"></i>
                    </div>
                   
                </div>
            </div>

        </section>
    </main>

    <div id="advertIframe">
        <div class="navigation-links underline flex-between">
            <div class="logo-image">
                <img src="images/logo.png" alt="" />
            </div>

            <h4 id="ad-name">Watching First Ad</h4>
        </div>

        <iframe src="" frameborder="0" class="w-100 h-100"></iframe>
    </div>

    <script src="navbar.js"></script>
</body>
</html>