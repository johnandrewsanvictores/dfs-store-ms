<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: staff.php");
    exit();
}

require('../includes/connection.php');

$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if (!empty($username) && !empty($password)) {
        try {
            $query = "SELECT * FROM staff_acc WHERE username = :username";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            // Check if the user exists
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    $_SESSION['username'] = $user['username'];
                    header("Location: staff.php");
                    exit();
                } else {
                    $errorMsg = "Invalid username or password!";
                }
            } else {
                $errorMsg = "Username does not exist!";
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            $errorMsg = "Something went wrong. Please try again later.";
        }
    } else {
        $errorMsg = "Both username and password are required!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/login.css" />
    <link rel="stylesheet" href="../global.css" />
    <title>DFS SMS - Staff Login</title>
</head>

<body>
    <section class="wrapper">
        <div class="login-main-container">
            <div class="header-container">
                <img src="../assets/images/dfs_logo.jpg" alt="Business logo" />
                <h6>Store Management System</h6>
            </div>

            <div class="content-container">
                <h4>STAFF LOGIN</h4>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username">

                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">

                    <div class="btn-div">
                        <input type="submit" name="submit" value="Login" id="submit-btn" />
                    </div>

                    <?php
                    if (!empty($errorMsg)) {
                        echo "<p class='error-msg'>$errorMsg</p>";
                    }
                    ?>

                </form>

            </div>
        </div>
    </section>
</body>

</html>