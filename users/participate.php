<?php 
	$page__css = '
		<link rel="stylesheet" href="css/participate.css" />
		<link rel="stylesheet" href="css/navbar.css" />
	';
    require_once("config/session.php");
    $page__title = "Task Participation";

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
                    <input type="hidden" value="<?= $ad["ad_id"] ?>" id="ad_idValue" name="ad_id">
                    <input type="hidden" value="<?= $ad["ad_url"] ?>" id="ad_url" name="ad_url">
                    <input type="hidden" value="<?= $ad["cost_per_click"] ?>" id="cppValue" name="cpp">

                    <div class="name">
                        <p class="head">Name</p>
                        <div class="text ad_text"><?= ucfirst($ad["ad_name"]) ?></div>
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

                        $user_has_participation_count = $PPC->checkUserClickRecordByAd($ad_id, $user_id); 

                        if ($user_has_participation_count > 0) { ?>
                            <button class="start-task">Participated</button>
                        <?php } elseif ($ad["clicks"] >= $ad["max_attempt"]) { ?>
                            <button class="start-task">Ended</button>
                        <?php } else { ?>
                            <button class="start-task" id="play-ad">Start Task</button>
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


    <div id="ad-center" class="w-100 h-100 hidden">
        <div class="navigation-links underline flex-between">
            <div class="logo-image">
                <img src="images/logo.png" alt="Logo" />
            </div>
            <p id="ad-name" class="md b-3">Watching First Ad</p>
        </div>

        <!-- Preloader -->
        <div id="preloader" class="preloader">
            <div class="spinner"></div>
            <p>Loading Ad...</p>
        </div>

        <!-- Progress Bar -->
        <div class="progress-bar-container">
            <div id="progressBar" class="progress-bar"></div>
        </div>

        <!-- Ad Iframe -->
        <iframe 
            id="advertIframe" 
            class="w-100" 
            src="about:blank" 
            frameborder="0">
        </iframe>

        <!-- Controls -->
        <div class="controls hidden">
            <button id="playPauseBtn" class="play-pause-btn">Play</button>
            <span id="timeIndicator" style="color: #fff;">0:00 / 0:30</span>
        </div>
    </div>

    <div id="adCompleteModal" class="modal hidden">
        <div class="modal-content">
            <h2>Ad Completed!</h2>
            <p>Thank you for watching the ad. You may now proceed.</p>
            <button id="closeModalBtn">Close</button>
        </div>
    </div>

    <script src="js/navbar.js"></script>
    <script src="js/participate.js"></script>
</body>
</html>