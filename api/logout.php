<?php
session_start();

// Check if it's a POST request and if 'action' is set
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] === 'logout') {
        if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
            // If the current domain contains 'localhost' (local environment), use relative paths
            $base_url = '../../dfs-ecommerce/';
        } else {
            // Otherwise, use the full URL for the live server (production)
            $base_url = 'https://www.yourdomain.com/';
        }

        // Perform logout actions
        session_unset();
        session_destroy();

        // Return the response with the redirect URL
        echo json_encode([
            'success' => true,
            'message' => 'Logout successful',
            'redirect_url' => $base_url . 'pages/login.php' // Send the login page URL to the client
        ]);
        exit();
    }
}

// If accessed directly without a valid action
http_response_code(400);
echo json_encode([
    'success' => false,
    'message' => 'Invalid request'
]);
?>
