<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-mine</title>

    <?php if ($page__css) { echo $page__css;  } ?>

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Quicksand:wght@300..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css"
      integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
  </head>

  <body class="darkMode">
    <header id="home">
      <nav id="nav">
        <div class="navigation-links underline">
            <div class="logo-image">
                <img src="images/logo.png" alt="" />
            </div>

            <div class="flex">
                <div class="light-dark mr-3">
                    <i class="fas fa-sun light"></i>
                    <i class="fa-solid fa-moon dark"></i>
                </div>

                <div class="menu">
                    <i class="fas fa-bars"></i></div>
                    
                    <div class="side-bar">
                        <p class="text underline pb-2">NAVIGATION</p>
                        <ul>
                            <li><a href="index.php">Dashboard</a></li>
                            <li><a href="profile.php">Profile</a></li>
                            <!-- <li><a href="subscription.php">My Subscriptions</a></li> -->
                            <li><a href="task.php">Tasks</a></li>
                            <li><a href="transaction.php">Wallet History</a></li>
                            <li><a href="referral.php">Referrals</a></li>
                            <li><a href="javascript:void(0)">Cashouts</a></li>
                            <li><a href="javascript:void(0)">Games</a></li>
                        </ul>

                        <!-- Coming Soon links -->
                        <div>
                            <p class="coming-soon">COMING SOON</p>
                            <ul>
                                <li><a href="">Contest</a></li>
                                <li><a href="">VTU Services</a></li>
                                <li><a href="">Bank Settings</a></li>
                                <li><a href="">Bank Settings</a></li>
                                <li><a href="">Market Place</a></li>
                                <li><a href="">Blog</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </nav>
    </header>