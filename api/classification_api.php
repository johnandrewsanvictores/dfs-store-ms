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
        if ($_POST['classification'] == 'category') {
            $old_img = $_POST['old_img_src'];

            if ($_FILES['category-image']['name']) {
                $uploadDir = 'assets/uploads/category/'; // Ensure this directory exists

                // Get the original file extension
                $fileExtension = pathinfo($_FILES['category-image']['name'], PATHINFO_EXTENSION);

                // Generate a unique file name using a combination of a timestamp and the original file extension
                $uniqueFilename = uniqid('category', true) . '.' . $fileExtension;
                $targetFile = $uploadDir . $uniqueFilename;

                if (move_uploaded_file($_FILES['category-image']['tmp_name'], '../' . $targetFile)) {
                    $pic = $targetFile;

                    if (file_exists('../' . $old_img)) {
                        unlink('../' . $old_img); // Delete the image file
                    }
                }
            } else {
                $pic = $old_img;
            }
            $name = $_POST['category'];
        } else if ($_POST["classification"] == 'brand') {
            $old_img = $_POST['old_img_src'];

            if ($_FILES['brand-image']['name']) {
                $uploadDir = 'assets/uploads/brand/'; // Ensure this directory exists

                // Get the original file extension
                $fileExtension = pathinfo($_FILES['brand-image']['name'], PATHINFO_EXTENSION);

                // Generate a unique file name using a combination of a timestamp and the original file extension
                $uniqueFilename = uniqid('brand', true) . '.' . $fileExtension;
                $targetFile = $uploadDir . $uniqueFilename;

                if (move_uploaded_file($_FILES['brand-image']['tmp_name'], '../' . $targetFile)) {
                    $pic = $targetFile;

                    if (file_exists('../' . $old_img)) {
                        unlink('../' . $old_img); // Delete the image file
                    }
                }
            } else {
                $pic = $old_img;
            }
            $name = $_POST['brand'];
        } else {
            $name = $_POST['texture'] ?? $_POST['material'] ?? null;
            $pic = null;
        }
        $id = $_POST['id'];
        $classification = $_POST['classification'];
        $hex_value = $_POST['hexvalue'] ?? null;
        $category_id = $_POST['category_id'] ?? null;
        $response = $classification_model->update_classification($id, $classification, $name, $hex_value, $category_id, $pic);
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

    if ($_GET['action'] == "get_specific_data") {
        $id = $_GET['id'];
        $classification = $_GET['classification'];

        // Fetch business data
        $response = $classification_model->get_specific_classification($classification, $id);
        // $response = $workerModel->getWorkers($filters = ['name' => 'j', 'education_level' => 'undergraduate'], $orderBy = 'worker.name', $orderDir = 'DESC', $limit = -1, $offset = 0);

        echo $response;
        exit();
    }

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
