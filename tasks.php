<?php 
	$page__css = '
		<link rel="stylesheet" href="css/task.css" />
	<link rel="stylesheet" href="css/navbar.css" />
	'; 

require_once("layout/user-header.php"); ?>


	<main>
		<div class="task-panel">
			<p class="head">Tasks</p>
		</div>
		
		<section class="task">
			<?php	
				try {
					global $db;
					require_once("config/PPC.php");
					$PPC = new PPCAd();
					$ads = $PPC->getAds();

					if (count($ads) > 0) { 
						foreach ($ads as $ad): ?>

							<div class="task-container">
								<div class="header">
									<p class="head"><?= ucfirst($ad["ad_name"]) ?></p>
									<p class="date"><?= format_timestamp_Date($ad["start_date"]) ?> <span class="time">15:43:16</span></p>
									
									<div class="participate-active">
										<button class="participate mr-3">
											<a href="participate.php?ad_id=<?= $ad["ad_id"] ?>">Participate</a>
										</button>
										
										<button class="active">
											<a>Active</a>
										</button>
									</div>
								</div>

								<div class="task-content">
									<div class="reward">
										<p class="price">&#8358;<?= ucfirst($ad["cost_per_click"]) ?></p>
										<p class="text">Reward</p>
									</div>
									
									<div class="attempts">
										<p class="price"><?= ucfirst($ad["clicks"]) ?></p>
										<p class="text">Total Attempts</p>
									</div>

									<div class="entry">
										<p class="price"><?= ucfirst(string: $ad["max_attempt"]) ?></p>
										<p class="text">Max. Entry</p>
									</div>
								</div>
							</div>
						<?php endforeach;
					}
				} catch (PDOException $e) {}
			?>
		</section>
	</main>

	<script src="navbar.js"></script>
</body>
</html>
