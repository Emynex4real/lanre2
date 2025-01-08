<?php 
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = [];
        // Get USER ID
        $userID = trim($_POST['user_id'] ?? '');

        require_once("functions.php");
        require_once("PPC.php");
        $user = new PPCUser($userID);
        $userDetails = $user->getUserDetails();

        // Update User Info
        if (isset($_POST['username'])) {
            // Fetch form data
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $image = trim($_POST['image'] ?? '');

            // Validate inputs
            if (empty($username)) {
                $response['errors']['username'] = "Username is required.";
            }

            if (empty($email)) {
                $response['errors']['email'] = "Email is required.";
            }

            
            // Handle file upload
            $imagePath = null;

            // Check if the file was uploaded without errors
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['image']['tmp_name'];
                $fileName = $_FILES['image']['name'];
                $fileSize = $_FILES['image']['size'];
                $fileType = $_FILES['image']['type'];

                $uploadDir = '../uploads/users/'; // Set the directory where you want to save the uploaded images
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
                }

                $imageFile = $_FILES['image'];
                $imageName = uniqid() . "_" . basename($imageFile['name']); // Generate a unique filename
                $imagePath = $uploadDir . $imageName;

                if (!move_uploaded_file($imageFile['tmp_name'], $imagePath)) {
                    $response['errors']['image'] = "Image could not be uploaded.";
                }
            } else {
                $imageName = $userDetails["image"];
            }


            // If validation passes
            if (empty($response['errors'])) {
                $result = $user->updateUserDetails($email, $username,  $imageName);

                if ($result) {
                    $response['success'] = true;
                } else {
                    $response['success'] = false;
                }

            } else {
                $response['success'] = false;
            }


        
        
        } elseif (isset($_POST["password"])) {
            // Update Password form data
            $password = trim($_POST['password'] ?? '');
            $new_password = trim($_POST['new_password'] ?? '');
            $cpassword = trim($_POST['new_password'] ?? '');

            // Validate inputs
            if (empty($password)) {
                $response['errors']['password'] = "Enter new password.";
            } else {
                $hashed_password = $userDetails["password"];

                if (!password_verify($password, $hashed_password)) { 
                    $response['errors']['password'] = "Incorrect password.";
                } elseif (empty($new_password)) {
                    $response['errors']['new_password'] = "Enter a new password.";
                } elseif (strlen($new_password) < 5) {
                    $response['errors']['new_password'] = "New password cannot be less than 5 characters.";
                } elseif (empty($cpassword)) {
                    $response['errors']['cpassword'] = "Re-enter the password.";
                } elseif ($new_password != $cpassword) {
                    $response['errors']['cpassword'] = "Confirm password does not match new password.";
                }
            }


            // If validation passes
            if (empty($response['errors'])) {
                $result = $user->updateUserPassword(  $new_password);

                if ($result) {
                    $response['success'] = true;
                } else {
                    $response['success'] = false;
                }

            } else {
                $response['success'] = false;
            }


        } elseif (isset($_POST["account_number"])) {
            // Update User Account Details form data
            $bank_name = trim($_POST['bank_name'] ?? '');
            $account_name = trim($_POST['account_name'] ?? '');
            $account_number = trim($_POST['account_number'] ?? '');


            // Validate inputs
            if (empty($bank_name)) {
                $response['errors']['bank_name'] = "Bank name is required.";
            }

            if (empty($account_name)) {
                $response['errors']['account_name'] = "Account name is required.";
            }

            if (empty($account_number)) {
                $response['errors']['account_number'] = "Account number is required.";
            } elseif (strlen((string) $account_number) < 10) {
                $response['errors']['account_number'] = "Account number cannot be less than 10 characters.";
            }
            
            
            // If validation passes
            if (empty($response['errors'])) {
                $result = $user->updateUserBandDetails(  $account_number, $bank_name, $account_name);

                if ($result) {
                    $response['success'] = true;
                } else {
                    $response['success'] = false;
                }

            } else {
                $response['success'] = false;
            }


        } elseif (isset($_POST["facebook"])) {
            // Update user Social acount form data
            $facebook = trim($_POST['facebook'] ?? '');
            $instagram = trim($_POST['instagram'] ?? '');
            $twitter = trim($_POST['twitter'] ?? '');
            $whatsapp = trim($_POST['whatsapp'] ?? '');

            // Validate inputs
            if (empty($facebook)) {
                $response['errors']['facebook'] = "Facebook link is required.";
            } elseif (!validate_url($facebook)) {
                $response['errors']['facebook'] = "Input is not a url link.";
            }

            if (empty($instagram)) {
                $response['errors']['instagram'] = "Instagram link is required.";
            } elseif (!validate_url($instagram)) {
                $response['errors']['instagram'] = "Input is not a url link.";
            }

            if (empty($twitter)) {
                $response['errors']['twitter'] = "Twitter link is required.";
            } elseif (!validate_url($twitter)) {
                $response['errors']['twitter'] = "Input is not a url link.";
            }

            if (empty($whatsapp)) {
                $response['errors']['whatsapp'] = "Whatsapp number is required.";
            } elseif (strlen((string) $whatsapp) < 11) {
                $response['errors']['whatsapp'] = "Whatsapp number cannot be less than 9 characters.";
            }
            
            
            // If validation passes
            if (empty($response['errors'])) {
                $result = $user->updateUserSocialDetails(  $facebook, $instagram, $twitter, $whatsapp);

                if ($result) {
                    $response['success'] = true;
                } else {
                    $response['success'] = false;
                }

            } else {
                $response['success'] = false;
            }
        }



        // Send response as JSON
        echo json_encode($response);
    }