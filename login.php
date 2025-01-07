<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>E-mine</title>
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
                            <div class="content">
                                <a class='logo-inr' href=''>
                                    <center> <img class="logo-img" src="images/light3-logo.png" width="200" alt="logo"></center>
                                </a>

                                <div class="alert success mb-3 d-none" id="loginSuccess">
                                    <p class="alert pl-2">Login request successfully</p>
                                </div>

                                <div class="alert danger mb-3 d-none" id="loginFailed">
                                    <p class="alert pl-2">Please check all inputs</p>
                                </div>

                                <form class="form-main" id="login-form" method="post">
                                    <div class="input-otr">
                                        <input class="input" type="text" name="username" placeholder="Enter Username">
                                        <p class="danger-text" id="usernameErr"></p>
                                    </div>

                                    <div class="input-otr">
                                        <div class="password-area">
                                            <input class="input" type="password" name="password" id="password" placeholder="Enter your password">
                                            <i class="far fa-eye password-eye" id="togglePassword"></i>
                                        </div>
                                        <p class="danger-text" id="passwordErr"></p>
                                    </div>
                                    
                                    <div class="check-main">
                                        <div class="check">
                                            <label>
                                                <a href='forgot-password' class="forgot">Forgot Password?</a>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="action-otrs">
                                        <input class="button body-sb" name="signup" type="submit" value="Login">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="back-to-menu">
                        <a href="">Click here to the homepage</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="js/account.js"></script>
</body>
</html>