<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Forgot Password - E-mine</title>
    <base href="http://localhost/php/e-mine//" />
    <link rel="stylesheet" href="css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <main>
        <div class="signup-main-dark">
            <div class="container-fluid">
                <div class="button-otr">
                    <a href="#" class="member body-sb">Not a member?</a>
                    
                    <div class="action-otr">
                        <a class='btn-fill-white btn-signup' href='signup'>Sign Up</a>
                    </div>
                </div>

                <div class="sign-up">
                    <div class="row row-login">
                        <div class="container">
                            <?php 
                                if ((isset($_GET["user_id"]) && !empty($_GET["user_id"])) && (isset($_GET["passkey"]) && !empty($_GET["passkey"]))) {
                                    require_once("users/config/functions.php");
                                    require_once("users/config/PPC.php");
                                    $user = new PPCUser($_GET["user_id"]);
                                    $correctKey = $user->checkResetKey($_GET["passkey"]);
                                    
                                    if ($correctKey) { ?>
                                        <div class="content">
                                            <a class='logo-inr' href=''>
                                                <center> <img class="logo-img" src="images/light3-logo.png" width="200" alt="logo"></center>
                                            </a>

                                            <div class="alert success mb-3 d-none" id="resetSuccess">
                                                <p class="alert pl-2">Password changed successfully</p>
                                            </div>

                                            <div class="alert danger mb-3 d-none" id="resetFailed">
                                                <p class="alert pl-2">Please check all inputs</p>
                                            </div>

                                            <form class="form-main" id="reset-password-form" method="post">
                                                <input type="hidden" name="user_id" value="<?= $_GET["user_id"] ?>" id="user_id">

                                                <div class="input-otr ">
                                                    <div class="password-area">
                                                        <input class="input" type="password" name="password" id="password" placeholder="Enter new Password">
                                                        <i class="far fa-eye password-eye" id="togglePassword"></i>
                                                    </div>
                                                    <p class="danger-text" id="passwordErr"></p>
                                                </div>

                                                <div class="input-otr ">
                                                    <div class="password-area">
                                                        <input class="input" type="password" name="cpassword" id="cpassword" placeholder="Confirm Password">
                                                        <i class="far fa-eye password-eye" id="togglecPassword"></i>
                                                    </div>
                                                    <p class="danger-text" id="cpasswordErr"></p>
                                                </div>

                                                <div class="action-otrs">
                                                    <input class="button body-sb" name="reset_password" id="forgot-button" type="submit" value="Reset password">
                                                </div>
                                            </form>
                                        </div>
                                    <?php } else { ?>
                                        <div class="content">
                                            <a class='logo-inr' href=''>
                                                <center> <img class="logo-img" src="images/light3-logo.png" width="200" alt="logo"></center>
                                            </a>

                                            <div class="text-center">
                                                <h3>Invalid or Expired Reset Link</h3>
                                                <p>The password reset link you clicked on is either invalid or has expired. Please check your email for a new reset link or request a new one below.</p
                                            </div>

                                            <div class="action-otrs">
                                                <a href="" class="button body-sb" name="send_link" id="forgot-button">Request new Password Reset link</a>
                                            </div>
                                        </div>
                                    <?php } ?>
                            <?php } else { ?>
                                <div class="content">
                                    <a class='logo-inr' href=''>
                                        <center> <img class="logo-img" src="images/light3-logo.png" width="200" alt="logo"></center>
                                    </a>

                                    <div class="alert success mb-3 d-none" id="forgotSuccess">
                                        <p class="alert pl-2">Reset link has been sent to your email</p>
                                    </div>

                                    <div class="alert danger mb-3 d-none" id="forgotFailed">
                                        <p class="alert pl-2">Please check all inputs</p>
                                    </div>

                                    <form class="form-main" id="forgot-password-form" method="post">
                                        <div class="input-otr ">
                                            <input class="input" type="email" name="email" placeholder="Enter your account email">
                                            <p class="danger-text" id="emailErr"></p>
                                        </div>
                                        
                                        <div class="check-main">
                                            <div class="check">
                                                <label>
                                                    <a class="/login">Login to Account</a>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="action-otrs">
                                            <input class="button body-sb" name="send_link" id="forgot-button" type="submit" value="Request Reset link">
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="back-to-menu">
                        <a href="/">Click here to the homepage</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="js/account.js"></script>
</body>
</html>