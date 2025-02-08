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
            $category_type = $_POST['category-type'];
            $category_image = $_FILES['category-image'];
            $response = $classification_model->add_classification_with_img($classification, $category_name, $category_image, null, $category_type);
        } else if ($classification == "brand") {
            $brand_name = $_POST['brand'];
            $brand_image = $_FILES['brand-image'];
            $category_id = $_POST['category_id'];
            $response = $classification_model->add_classification_with_img($classification, $brand_name, $brand_image, $category_id, null);
        } else {
            $response = $classification_model->add_classification($classification, $texture, $material, $hex_value);
        }
        echo $response;
        exit();
    }

    if ($action == "update_data") {
        $id = $_POST['id'];
        $classification = $_POST['classification'];

        if ($classification == 'category') {
            $name = $_POST['category'];
            $category_type = $_POST['category-type'];
            if (isset($_FILES['category-image']) && $_FILES['category-image']['name']) {
                $uploadDir = 'assets/uploads/category/';
                $fileExtension = pathinfo($_FILES['category-image']['name'], PATHINFO_EXTENSION);
                $uniqueFilename = uniqid('category', true) . '.' . $fileExtension;
                $targetFile = $uploadDir . $uniqueFilename;

                if (!file_exists('../' . $uploadDir)) {
                    mkdir('../' . $uploadDir, 0777, true);
                }

                if (move_uploaded_file($_FILES['category-image']['tmp_name'], '../' . $targetFile)) {
                    $image_path = $targetFile;
                    if (isset($_POST['old_img_src']) && file_exists('../' . $_POST['old_img_src'])) {
                        unlink('../' . $_POST['old_img_src']);
                    }
                }
            } else {
                $image_path = $_POST['old_img_src'] ?? null;
            }
            $response = $classification_model->update_classification_with_image("category", $id, $name, $image_path, null, $category_type);
        } else if ($classification == 'brand') {
            $name = $_POST['brand'];
            if (isset($_FILES['brand-image']) && $_FILES['brand-image']['name']) {
                $uploadDir = 'assets/uploads/brand/';
                $fileExtension = pathinfo($_FILES['brand-image']['name'], PATHINFO_EXTENSION);
                $uniqueFilename = uniqid('brand', true) . '.' . $fileExtension;
                $targetFile = $uploadDir . $uniqueFilename;

                if (!file_exists('../' . $uploadDir)) {
                    mkdir('../' . $uploadDir, 0777, true);
                }

                if (move_uploaded_file($_FILES['brand-image']['tmp_name'], '../' . $targetFile)) {
                    $image_path = $targetFile;
                    if (isset($_POST['old_img_src']) && file_exists('../' . $_POST['old_img_src'])) {
                        unlink('../' . $_POST['old_img_src']);
                    }
                }
            } else {
                $image_path = $_POST['old_img_src'] ?? null;
            }
            $category_id = $_POST['category_id'];
            $response = $classification_model->update_classification_with_image("brand", $id, $name, $image_path, $category_id, null);
        } else {
            // For texture, material, and color
            $texture = null;
            $material = null;
            $hex_value = null;

            switch ($classification) {
                case 'texture':
                    $texture = $_POST['texture'];
                    break;
                case 'material':
                    $material = $_POST['material'];
                    break;
                case 'color':
                    $hex_value = $_POST['hexvalue'];
                    break;
            }

            $response = $classification_model->update_classification($id, $classification, $texture, $material, $hex_value);
        }
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

    if ($action == "change_status") {
        $ids = explode(',', $_POST['ids']);
        $classification = $_POST['classification'];
        $response = $classification_model->update_status($classification, $ids);
        echo $response;
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action'])) {
    $search = $_GET['search'] ?? '';
    $sort = $_GET['sort'] ?? 'default';
    $status = $_GET['status'] ?? '';
    $categoryType = $_GET['categoryType'] ?? '';

    if ($_GET['action'] == "get_specific_data") {
        $id = $_GET['id'];
        $classification = $_GET['classification'];

        // Fetch business data
        $response = $classification_model->get_specific_classification($classification, $id);
        // $response = $workerModel->getWorkers($filters = ['name' => 'j', 'education_level' => 'undergraduate'], $orderBy = 'worker.name', $orderDir = 'DESC', $limit = -1, $offset = 0);

        echo $response;
        exit();
    }

    if ($_GET['action'] == "get_all_categorys") {
        $response = $classification_model->get_all_items('category', 'category_name', $search, $sort, $status, null, $categoryType);
        echo $response;
        exit();
    } elseif ($_GET['action'] == "get_all_brands") {
        $response = $classification_model->get_all_items('brand', 'brand_name', $search, $sort, $status);
        echo $response;
        exit();
    } elseif ($_GET['action'] == "get_all_textures") {
        $response = $classification_model->get_all_items('texture', 'texture_name', $search, $sort, $status);
        echo $response;
        exit();
    } elseif ($_GET['action'] == "get_all_materials") {
        $response = $classification_model->get_all_items('material', 'material_name', $search, $sort, $status);
        echo $response;
        exit();
    } elseif ($_GET['action'] == "get_all_colors") {
        $response = $classification_model->get_all_items('color', 'hex_value', $search, $sort, $status);
        echo $response;
        exit();
    } elseif ($_GET['action'] == "get_brands_by_category" && isset($_GET['category_id'])) {

        $category_id = $_GET['category_id'];
        $response = $classification_model->get_all_items('brand', 'brand_name', $search, $sort, $status, $category_id);
        echo $response;
        exit();
    }
}
