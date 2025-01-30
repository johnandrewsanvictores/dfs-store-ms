<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dream Fashion Shop - Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../styles/register.css">
</head>

<body>
    <?php require("../includes/navbar.php") ?>

    <div class="register-page">
        <div class="register-container">
            <div class="register-left">
                <h1>Let's Make it Happen Together!</h1>
                <p>Join our fashion community and discover amazing styles</p>
                <div class="illustration">
                    <img src="../assets/images/main/rgs.svg" alt="Registration Illustration">
                </div>
            </div>
            <div class="register-right">
                <div class="register-form-container">
                    <h2>Create Account</h2>
                    <form action="register_process.php" method="post">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" id="firstname" name="firstname">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" id="lastname" name="lastname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="email_otp">Email OTP</label>
                            <div class="input-with-button">
                                <input type="text" id="email_otp" name="email_otp">
                                <button type="button" class="otp-btn">Send OTP</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="phone_otp">Phone OTP</label>
                            <div class="input-with-button">
                                <input type="text" id="phone_otp" name="phone_otp">
                                <button type="button" class="otp-btn">Send OTP</button>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="password-input">
                                    <input type="password" id="password" name="password">
                                    <i class="fas fa-eye-slash toggle-password"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <div class="password-input">
                                    <input type="password" id="confirm_password" name="confirm_password">
                                    <i class="fas fa-eye-slash toggle-password"></i>
                                </div>
                            </div>
                        </div>
                        <div class="terms">
                            <input type="checkbox" id="terms">
                            <label for="terms">
                                I agree to the <a href="#">Terms & Conditions</a>
                            </label>
                        </div>
                        <button type="submit" class="register-btn">Create Account</button>
                    </form>
                    <p class="login-link">Already have an account? <a href="login.php">Sign in here</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/register.js"></script>
</body>

</html>