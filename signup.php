<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-mine</title>
    <base href="http://localhost/php/e-mine//" />
    <link rel="stylesheet" href="css/signup.css">
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
                    <a href="#" class="member body-sb">Already a member?</a>

                    <a class='btn-fill-white btn-signup' href='login'>
                        <div class="action-otr b-3" style="font-weight: 800;">
                            Login
                        </div>
                    </a>
                </div>

                <div class="sign-up">
                    <div class="row row-login">
                        <div class="container">
                            <div class="content">
                                <a class='logo-inr' href=''>
                                    <center> <img class="logo-img" src="images/light3-logo.png" width="200" alt="logo"></center>
                                </a>

                                <div class="alert success mb-3 d-none" id="registerationSuccess">
                                    <p class="alert pl-2">Account created successfully</p>
                                </div>

                                <div class="alert danger mb-3 d-none" id="registerationFailed">
                                    <p class="alert pl-2">Please check all inputs</p>
                                </div>

                                <form class="form-main" id="register-form" method="post">
                                    <div class="input-otr">
                                        <input class="input" type="text" name="username" placeholder="Enter Username">
                                        <p class="danger-text" id="usernameErr"></p>
                                    </div>

                                    <div class="input-otr ">
                                        <input class="input" type="email" name="email" placeholder="Enter  your email">
                                        <p class="danger-text" id="emailErr"></p>
                                    </div>

                                    <div class="input-otr ">
                                        <input class="input" type="text" value="<?php if(isset($_GET["referral_code"])): echo $_GET["referral_code"]; endif; ?>" name="refUsername" placeholder="You dont have an upline" readonly>
                                    </div>

                                    <div class="check-main">
                                        <div class="check">
                                            <label>
                                                <a href='vendors' class="coupon">Buy coupon</a>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="input-otr">
                                        <input class="input" type="text" placeholder="Paste Coupon" name="coupon">
                                        <p class="danger-text" id="couponErr"></p>
                                    </div>

                                    <div class="input-otr">
                                        <div class="password-area">
                                            <input class="input" type="password" name="password" id="password" placeholder="Your password">
                                            <i class="far fa-eye password-eye" id="togglePassword"></i>
                                        </div>
                                        <p class="danger-text" id="passwordErr"></p>
                                    </div>

                                    <div class="action-otrs">
                                        <input class="button body-sb" name="signup" type="submit" value="Register">
                                    </div>
                                </form>
                            </div>
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