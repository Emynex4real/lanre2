<?php 
    $subject = "Password Reset Request";
    $body = '
        <!DOCTYPE html>
            <html>
            <head>
                <title>Password Reset - E-MINE</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        color: #fff;
                        margin: 0;
                        padding: 0;
                    }
                    .email-container {
                        max-width: 600px;
                        margin: 20px auto;
                        background-color: #000000;
                        color: #ffffff;
                        border-radius: 8px;
                        overflow: hidden;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    }
                    .header {
                        padding: 20px;
                        text-align: center;
                        background: linear-gradient(to left, #530278 0%, #F3893F 100%);

                    }
                    .header h1 {
                        margin: 0;
                        color: #fff;
                        font-size: 26px;
                        text-transform: uppercase;
                    }
                    .header p {
                        margin: 0;
                        font-size: 14px;
                        opacity: 0.9;
                    }
                    .content {
                        color: #fff;
                        padding: 20px;
                        border-radius: 0 0 8px 8px;
                    }
                    .content h2 {
                        color: #fff;
                        font-size: 20px;
                    }
                    .content p {
                        color: #fff;
                        font-size: 16px;
                        line-height: 1.5;
                        margin: 10px 0;
                    }
                    .reset-button {
                        display: block;
                        width: fit-content;
                        background-color: #F3893F;
                        color: #ffffff;
                        text-decoration: none;
                        padding: 12px 20px;
                        border-radius: 4px;
                        text-align: center;
                        margin: 20px 0;
                        font-weight: bold;
                        font-size: 16px;
                    }
                    .footer {
                        text-align: center;
                        font-size: 12px;
                        color: #ffffff;
                        padding: 10px;
                        background: linear-gradient(to left, #530278 0%, #F3893F 100%);
                        border-top: 1px solid rgba(255, 255, 255, 0.2);
                    }
                    .footer a {
                        color: #ffffff;
                        text-decoration: underline;
                    }
                </style>
            </head>
            <body>
                <div class="email-container">
                    <!-- Header Section -->
                    <div class="header">
                        <h1>Password Reset Request</h1>
                        <p>E-Mine</p>
                    </div>

                    <!-- Content Section -->
                    <div class="content">
                        <p>Hello, '. ucfirst($username) . '</p>
                        <p>We received a request to reset your password for your E-MINE account. Click the button below to reset your password:</p>
                        <a href="' .  $reset_link . '" class="reset-button">Reset Password</a>
                        <p>If you didn’t request a password reset, you can safely ignore this email. Your password will remain unchanged.</p>
                    </div>

                    <!-- Footer Section -->
                    <div class="footer">
                        <p>&copy; 2025 E-MINE. All rights reserved.</p>
                        <p><a href="https://emine.com.ng/privacy-policy">Privacy Policy</a> | <a href="https://emine.com.ng/terms-and-conditions">Terms of Service</a></p>
                    </div>
                </div>
            </body>
            </html>
        ';

    require 'includes/Exception.php';
    require 'includes/PHPMailer.php';
    require 'includes/SMTP.php';


    // Include library PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;



    // Start
    $mail = new PHPMailer(true);

    try {
        // Configuration SMTP
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                         // Show output (Disable in production)
        $mail->isSMTP();                                               // Activate SMTP sending
        $mail->Host  = 'smtp.gmail.com';                     // SMTP Server
        $mail->SMTPAuth  = true;                                       // SMTP Identification
        $mail->Username  = 'techniquesconsult7@gmail.com';                  // SMTP User
        $mail->Password  = 'lxejfiassjrsilic';	          // SMTP Password
        $mail->SMTPSecure = 'ssl';
        $mail->Port  = 465;
        $mail->setFrom("techniquesconsult7@gmail.com", "Techniques Consult");                // Mail sender

        // Recipients
        $mail->addAddress($email, $username); 

        // Mail content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body  = $body;
        $mail->addReplyTo("techniquesconsult7@gmail.com", "Emine Admin");
        $mail->send();
        
    } catch (Exception $e) {
    }