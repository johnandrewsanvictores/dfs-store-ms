
<?php
session_start();

// Check if it's a POST request and if 'action' is set
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] === 'logout') {
        // Perform logout actions
        session_unset();
        session_destroy();

        // Return a JSON response
        echo json_encode([
            'success' => true,
            'message' => 'Logout successful'
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