<?php
require '../includes/connection.php';
require '../models/Classification_model.php';

$classification_model = new Classification_Model($connection);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == "add_data") {
        $classification = $_POST['classification'];
        $texture = $_POST['texture'] ?? null;
        $material = $_POST['material'] ?? null;
        $hex_value = $_POST['hexvalue'] ?? null;
        $response = $classification_model->add_classification($classification, $texture, $material, $hex_value);
        echo $response;
        exit();
    }

    if ($action == "update_data") {
        $id = $_POST['id'];
        $classification = $_POST['classification'];
        $name = $_POST['name'];
        $hex_value = $_POST['hexvalue'] ?? null;
        $response = $classification_model->update_classification($id, $classification, $name, $hex_value);
        echo $response;
        exit();
    }

    if ($action == "delete_data") {
        $id = $_POST['id'];
        $response = $classification_model->delete_classification($id);
        echo $response;
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == "get_all") {
    $response = $classification_model->get_all_classifications();
    echo $response;
    exit();
}
