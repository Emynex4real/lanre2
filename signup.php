<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-mine</title>
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
                    <div class="action-otr">
                    <a class='btn-fill-white btn-signup' href='login'>Login</a>
                    </div>
                </div>
                <div class="sign-up">
                    <div class="row row-login">
                        <div class="container">
                            <div class="content">
                                <a class='logo-inr' href=''>
                                <center> <img class="logo-img" src="images/light3-logo.png" width="200" alt="logo"></center>
                                </a>


                                <form class="form-main" method="post">
                                <div class="input-otr">
                                    <input class="input" type="text" name="username" value="" placeholder="Enter Username" required="">
                                </div>
                                <div class="input-otr ">
                                    <input class="input" type="text" name="fullname" value="" placeholder="Enter Fullname" required="">
                                </div>
                                <div class="input-otr ">
                                    <input class="input" type="email" name="email" value="" placeholder="Enter email" required="">
                                </div>
                                <div class="input-otr ">
                                    <input class="input" type="number" name="phoneNumber" value="" placeholder="Enter Phone number" required="">
                                </div>
                                <div class="input-otr ">
                                    <input class="input" type="text" name="refUsername" value="" placeholder="You dont have an upline" readonly>
                                </div>



                                <input type="hidden" name="couponType" value="jumbo">

                                <div class="check-main">

                                    <div class="check">

                                    <label>

                                        <a href='vendors' class="coupon">Buy coupon</a>
                                    </label>
                                    </div>
                                </div>
                                <div class="input-otr ">
                                    <input class="input" type="text" placeholder="Paste Coupon" name="coupon" value="" required="">
                                </div>
                                <div class="input-otr">
                                    <input class="input" type="text" name="password" value="" placeholder="Your password" required="">
                                </div>

                                <div class="action-otrs">
                                    <input class="button body-sb" name="signup" type="submit" value="Register">
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
    <script src="project.js"></script>
    </body>
    </html>