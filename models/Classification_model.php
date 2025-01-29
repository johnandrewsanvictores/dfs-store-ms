<?php

class Classification_Model
{
    private $pdo;
    private $response;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->response = array();
    }

    public function add_classification($classification, $texture, $material, $hex_value = null)
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($classification == 'texture') {
                $nameCheckSql = "SELECT COUNT(*) FROM classification WHERE texture_name = :texture AND :texture IS NOT NULL";
                $nameCheckStmt = $this->pdo->prepare($nameCheckSql);
                $nameCheckStmt->bindValue(':texture', $texture);
            } elseif ($classification == 'material') {
                $nameCheckSql = "SELECT COUNT(*) FROM classification WHERE material_name = :material AND :material IS NOT NULL";
                $nameCheckStmt = $this->pdo->prepare($nameCheckSql);
                $nameCheckStmt->bindValue(':material', $material);
            } elseif ($classification == 'color') {
                $nameCheckSql = "SELECT COUNT(*) FROM classification WHERE hex_value = :hex_value AND :hex_value IS NOT NULL";
                $nameCheckStmt = $this->pdo->prepare($nameCheckSql);
                $nameCheckStmt->bindValue(':hex_value', $hex_value);
            } else {
                $this->response['success'] = false;
                $this->response['message'] = "Invalid classification type." . $classification;
                return json_encode($this->response);
            }

            $nameCheckStmt->execute();

            // Get the count of matching names
            $exists = $nameCheckStmt->fetchColumn();

            if ($exists > 0) {
                $this->response['success'] = false;
                $this->response['message'] = "The Property already exists!";
                return json_encode($this->response);
            }

            $stmt = $this->pdo->prepare("INSERT INTO classification (classification, texture_name, material_name, hex_value) VALUES (:classification, :texture_name, :material_name, :hex_value)");
            $stmt->bindParam(':classification', $classification);
            $stmt->bindParam(':texture_name', $texture);
            $stmt->bindParam(':material_name', $material);
            $stmt->bindParam(':hex_value', $hex_value);

            $stmt->execute();

            $this->response['success'] = true;
            $this->response['message'] = "Property added successfully.";
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error adding Property: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    public function update_classification($id, $classification, $name, $hex_value = null, $category_id = null, $picture = null)
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($classification === "category") {
                $stmt = $this->pdo->prepare("UPDATE category SET category_name = :name, image_path = :img WHERE id = :id");
                $stmt->bindParam(':img', $picture);
                $stmt->bindParam(':name', $name);
            } else if ($classification === "brand") {
                $stmt = $this->pdo->prepare("UPDATE brand SET brand_name = :name, image_path = :img, category_id = :category_id WHERE id = :id");
                $stmt->bindParam(':img', $picture);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':category_id', $category_id);
            } else {
                $column_name = '';
                if ($classification == 'brand') {
                    $column_name = 'brand_name';
                } elseif ($classification == 'texture') {
                    $column_name = 'texture_name';
                } elseif ($classification == 'color') {
                    $column_name = '';
                } else {
                    throw new Exception("Invalid classification type");
                }

                if ($column_name) {
                    $stmt = $this->pdo->prepare("UPDATE classification SET $column_name = :name, hex_value = :hex_value WHERE id = :id");
                    $stmt->bindParam(':name', $name);
                } else {
                    $stmt = $this->pdo->prepare("UPDATE classification SET hex_value = :hex_value WHERE id = :id");
                }

                $stmt->bindParam(':hex_value', $hex_value);
            }
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $this->response['success'] = true;
            $this->response['message'] = "Classification updated successfully.";
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error updating classification: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    public function delete_classification($ids)
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            // Prepare the delete statement
            $deleteCsfStmt = $this->pdo->prepare("DELETE FROM classification WHERE id IN ($placeholders)");

            // Bind the parameters
            $deleteCsfStmt->execute($ids);

            $this->response['success'] = true;
            $this->response['message'] = "Classification deleted successfully.";
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error deleting classification: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    public function delete_category_with_brands($category_ids)
    {
        try {
            $this->pdo->beginTransaction();

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $placeholders = implode(',', array_fill(0, count($category_ids), '?'));

            // Get the category images
            $getCategoryImagesStmt = $this->pdo->prepare("SELECT image_path FROM category WHERE id IN ($placeholders)");
            $getCategoryImagesStmt->execute($category_ids);
            $categoryImages = $getCategoryImagesStmt->fetchAll(PDO::FETCH_COLUMN);

            // Unlink the category images
            foreach ($categoryImages as $image) {
                if (file_exists("../" . $image)) {
                    unlink("../" . $image);
                }
            }

            // Get the brand images under the categories
            $getBrandImagesStmt = $this->pdo->prepare("SELECT image_path FROM brand WHERE category_id IN ($placeholders)");
            $getBrandImagesStmt->execute($category_ids);
            $brandImages = $getBrandImagesStmt->fetchAll(PDO::FETCH_COLUMN);

            // Unlink the brand images
            foreach ($brandImages as $image) {
                if (file_exists("../" . $image)) {
                    unlink("../" . $image);
                }
            }

            // Delete the categories
            $deleteCategoryStmt = $this->pdo->prepare("DELETE FROM category WHERE id IN ($placeholders)");
            $deleteCategoryStmt->execute($category_ids);

            $this->pdo->commit();

            $this->response['success'] = true;
            $this->response['message'] = "Category and its brands deleted successfully.";
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            $this->response['success'] = false;
            $this->response['message'] = "Error deleting category: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    public function delete_brand($ids)
    {
        try {
            $this->pdo->beginTransaction();

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            // Get the category images
            $getBrandImagesStmt = $this->pdo->prepare("SELECT image_path FROM brand WHERE id IN ($placeholders)");
            $getBrandImagesStmt->execute($ids);
            $brandImages = $getBrandImagesStmt->fetchAll(PDO::FETCH_COLUMN);

            // Unlink the category images
            foreach ($brandImages as $image) {
                if (file_exists("../" . $image)) {
                    unlink("../" . $image);
                }
            }

            // Prepare the delete statement
            $deleteBrandStmt = $this->pdo->prepare("DELETE FROM brand WHERE id IN ($placeholders)");

            // Bind the parameters
            $deleteBrandStmt->execute($ids);

            $this->pdo->commit();

            $this->response['success'] = true;
            $this->response['message'] = "Brand deleted successfully.";
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            $this->response['success'] = false;
            $this->response['message'] = "Error deleting brand: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    public function delete_items($classification, $ids)
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($classification == 'category') {
                $this->delete_category_with_brands($ids);
            } elseif ($classification == 'brand') {
                $this->delete_brand($ids);
            } else {
                $this->delete_classification($ids);
            }

            $this->response['success'] = true;
            $this->response['message'] = "Selected items deleted successfully.";
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error deleting items: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    public function get_all_classifications()
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare("SELECT * FROM classification");
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $textures = array_filter($results, function ($item) {
                return $item['classification'] == 'texture';
            });

            $materials = array_filter($results, function ($item) {
                return $item['classification'] == 'material';
            });

            $colors = array_filter($results, function ($item) {
                return $item['classification'] == 'color';
            });

            $this->response['success'] = true;
            $this->response['textures'] = $textures;
            $this->response['materials'] = $materials;
            $this->response['colors'] = $colors;
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error retrieving classifications: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    public function add_category($category_name, $category_image)
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if category name already exists
            $nameCheckSql = "SELECT COUNT(*) FROM category WHERE category_name = :category_name";
            $nameCheckStmt = $this->pdo->prepare($nameCheckSql);
            $nameCheckStmt->bindValue(':category_name', $category_name);
            $nameCheckStmt->execute();
            $exists = $nameCheckStmt->fetchColumn();

            if ($exists > 0) {
                $this->response['success'] = false;
                $this->response['message'] = "The category already exists!";
                return json_encode($this->response);
            }

            // Handle image upload
            $unique_image_name = uniqid() . '_' . basename($category_image['name']);
            $image_path = 'assets/uploads/category/' . $unique_image_name;
            if (!move_uploaded_file($category_image['tmp_name'], "../" . $image_path)) {
                $this->response['success'] = false;
                $this->response['message'] = "Error Uploading Image";
            } else {
                $stmt = $this->pdo->prepare("INSERT INTO category (category_name, image_path) VALUES (:category_name, :image_path)");
                $stmt->bindParam(':category_name', $category_name);
                $stmt->bindParam(':image_path', $image_path);

                $stmt->execute();

                $this->response['success'] = true;
                $this->response['message'] = "Category added successfully.";
            }
        } catch (Exception $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error adding category: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    public function add_brand($brand_name, $brand_image, $category_id)
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if brand name already exists
            $nameCheckSql = "SELECT COUNT(*) FROM brand WHERE brand_name = :brand_name";
            $nameCheckStmt = $this->pdo->prepare($nameCheckSql);
            $nameCheckStmt->bindValue(':brand_name', $brand_name);
            $nameCheckStmt->execute();
            $exists = $nameCheckStmt->fetchColumn();

            if ($exists > 0) {
                $this->response['success'] = false;
                $this->response['message'] = "The brand already exists!";
                return json_encode($this->response);
            }

            // Handle image upload
            $unique_image_name = uniqid() . '_' . basename($brand_image['name']);
            $image_path = 'assets/uploads/brand/' . $unique_image_name;
            if (!move_uploaded_file($brand_image['tmp_name'], "../" . $image_path)) {
                $this->response['success'] = false;
                $this->response['message'] = "Error Uploading Image";
            } else {
                $stmt = $this->pdo->prepare("INSERT INTO brand (brand_name, image_path, category_id) VALUES (:brand_name, :image_path, :category_id)");
                $stmt->bindParam(':brand_name', $brand_name);
                $stmt->bindParam(':image_path', $image_path);
                $stmt->bindParam(':category_id', $category_id);

                $stmt->execute();

                $this->response['success'] = true;
                $this->response['message'] = "Brand added successfully.";
            }
        } catch (Exception $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error adding brand: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    public function get_all_categories()
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare("SELECT * FROM category");
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->response['success'] = true;
            $this->response['categorys'] = $results;
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error retrieving categories: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    public function get_brands_by_category($category_id)
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare("SELECT * FROM brand WHERE category_id = :category_id");
            $stmt->bindParam(':category_id', $category_id);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->response['success'] = true;
            $this->response['brands'] = $results;
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error retrieving brands: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    public function get_all_brands()
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare("SELECT * FROM brand");
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->response['success'] = true;
            $this->response['brands'] = $results;
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error retrieving brands: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    public function get_all_textures()
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare("SELECT * FROM classification WHERE classification = 'texture'");
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->response['success'] = true;
            $this->response['textures'] = $results;
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error retrieving textures: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    public function get_all_materials()
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare("SELECT * FROM classification WHERE classification = 'material'");
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->response['success'] = true;
            $this->response['materials'] = $results;
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error retrieving materials: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    public function get_all_colors()
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare("SELECT * FROM classification WHERE classification = 'color'");
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->response['success'] = true;
            $this->response['colors'] = $results;
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error retrieving colors: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    public function get_specific_classification($classification, $id)
    {
        if ($classification === "category") {
            try {
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $this->pdo->prepare("SELECT * FROM category WHERE id = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $this->response['success'] = true;
                $this->response['data'] = $results;
            } catch (PDOException $e) {
                $this->response['success'] = false;
                $this->response['message'] = "Error retrieving categories: " . $e->getMessage();
            }

            return json_encode($this->response);
        } else if ($classification === "brand") {
            try {
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $this->pdo->prepare("SELECT * FROM brand WHERE id = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $this->response['success'] = true;
                $this->response['data'] = $results;
            } catch (PDOException $e) {
                $this->response['success'] = false;
                $this->response['message'] = "Error retrieving brand: " . $e->getMessage();
            }

            return json_encode($this->response);
        } else {
            try {
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $this->pdo->prepare("SELECT * FROM classification WHERE id = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $this->response['success'] = true;
                $this->response['data'] = $results;
            } catch (PDOException $e) {
                $this->response['success'] = false;
                $this->response['message'] = "Error retrieving brand: " . $e->getMessage();
            }

            return json_encode($this->response);
        }
    }
}
