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
            <div class="register-image" style="background-color: #f0f0f0;">
                <img src="../assets/images/main/signup.svg" alt="E-commerce Image">
            </div>
            <div class="register-form">
                <h2>Register</h2>
                <form action="register_process.php" method="post">
                    <div class="form-group">
                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group otp-group">
                        <input type="email" name="email" placeholder="Email" required>
                        <button type="button" class="otp-button">Send OTP</button>
                    </div>
                    <div class="form-group">
                        <input type="text" name="email_otp" placeholder="Enter Email OTP" required>
                    </div>
                    <div class="form-group otp-group">
                        <input type="text" name="phone" placeholder="Phone Number" required>
                        <button type="button" class="otp-button">Send OTP</button>
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone_otp" placeholder="Enter Phone OTP" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    </div>
                    <button type="submit">Register</button>
                    <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>