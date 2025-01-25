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

        if ($classification == "category") {
            $category_name = $_POST['category'];
            $category_image = $_FILES['category-image'];
            $response = $classification_model->add_category($category_name, $category_image);
        } else if ($classification == "brand") {
            $brand_name = $_POST['brand'];
            $brand_image = $_FILES['brand-image'];
            $category_id = $_POST['category_id'];
            $response = $classification_model->add_brand($brand_name, $brand_image, $category_id);
        } else {
            $response = $classification_model->add_classification($classification, $texture, $material, $hex_value);
        }
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
        $ids = explode(',', $_POST['ids']);
        $classification = $_POST['classification'];
        $response = $classification_model->delete_items($classification, $ids);
        echo $response;
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action'])) {
    if ($_GET['action'] == "get_all") {
        $response = $classification_model->get_all_classifications();
        echo $response;
        exit();
    } elseif ($_GET['action'] == "get_all_categorys") {
        $response = $classification_model->get_all_categories();
        echo $response;
        exit();
    } elseif ($_GET['action'] == "get_all_brands") {
        $response = $classification_model->get_all_brands();
        echo $response;
        exit();
    } elseif ($_GET['action'] == "get_all_textures") {
        $response = $classification_model->get_all_textures();
        echo $response;
        exit();
    } elseif ($_GET['action'] == "get_all_materials") {
        $response = $classification_model->get_all_materials();
        echo $response;
        exit();
    } elseif ($_GET['action'] == "get_all_colors") {
        $response = $classification_model->get_all_colors();
        echo $response;
        exit();
    } elseif ($_GET['action'] == "get_brands_by_category" && isset($_GET['category_id'])) {
        $category_id = $_GET['category_id'];
        $response = $classification_model->get_brands_by_category($category_id);
        echo $response;
        exit();
    }
}
