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

    // Get all items based on the classification type
    public function get_all_items($classification_type, $name_field, $search = '', $sort = 'default', $status = '', $category_id = null, $category_type = null)
    {
        $params = [];
        $conditions = [];

        try {
            // Determine the base SQL query based on the classification type
            if ($classification_type == "category") {
                $sql = "SELECT * FROM category";
            } else if ($classification_type == "brand") {
                if ($category_id) {
                    $sql = "SELECT * FROM brand WHERE category_id = :category_id";
                    $params[':category_id'] = $category_id;
                } else {
                    $sql = "SELECT * FROM brand";
                }
            } else {
                $sql = "SELECT * FROM classification WHERE classification = :classification";
                $params[':classification'] = $classification_type;
            }

            // Add search condition if provided
            if (!empty($search)) {
                $conditions[] = "{$name_field} LIKE :search";
                $params[':search'] = "%{$search}%";
            }

            // Add status condition if provided
            if (!empty($status)) {
                $conditions[] = "status = :status";
                $params[':status'] = $status;
            }

            if (!empty($category_type)) {
                $conditions[] = "category_type = :category_type";
                $params[':category_type'] = $category_type;
            }


            // Combine conditions with the base SQL query
            if (!empty($conditions)) {
                // Check if the base query already has a WHERE clause
                if (strpos($sql, 'WHERE') !== false) {
                    // If it already has a WHERE clause, append conditions with AND
                    $sql .= " AND " . implode(" AND ", $conditions);
                } else {
                    // If it doesn't have a WHERE clause, add WHERE
                    $sql .= " WHERE " . implode(" AND ", $conditions);
                }
            }

            // Add sorting based on the provided sort option
            $sortField = match ($sort) {
                'name-asc' => "{$name_field} ASC",
                'name-desc' => "{$name_field} DESC",
                'date-asc' => "created_at ASC",
                'date-desc' => "created_at DESC",
                default => "id DESC"
            };
            $sql .= " ORDER BY " . $sortField;

            // Prepare and execute the SQL query
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            // Set the response
            $this->response['success'] = true;
            $this->response[$classification_type . 's'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error retrieving items: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    // Get specific item based on the classification type use for edit filling form
    public function get_specific_classification($classification, $id)
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            switch ($classification) {
                case "category":
                    $stmt = $this->pdo->prepare("SELECT * FROM category WHERE id = :id");

                    break;
                case "brand":
                    $stmt = $this->pdo->prepare("SELECT * FROM brand WHERE id = :id");
                    break;
                default:
                    $stmt = $this->pdo->prepare("SELECT * FROM classification WHERE id = :id");
                    break;
            }

            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->response['success'] = true;
            $this->response['data'] = $results;
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error retrieving data: " . $e->getMessage();
        }
        return json_encode($this->response);
    }

    // Add new classification (texture, material, color)
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

    // Add new classification with image (category, brand)
    public function add_classification_with_img($classification, $name, $image, $category_id = null, $category_type = null)
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($classification == "brand") {
                $table = "brand";
                $name_field = "brand_name";
                $image_path = 'assets/uploads/brand/';
                $sql = "INSERT INTO brand (brand_name, image_path, category_id) VALUES (:name, :image_path, :category_id)";
            } else if ($classification == "category") {
                $table = "category";
                $name_field = "category_name";
                $image_path = 'assets/uploads/category/';
                $sql = "INSERT INTO category (category_name, image_path, category_type) VALUES (:name, :image_path, :category_type)";
            }

            $nameCheckSql = "SELECT COUNT(*) FROM {$table} WHERE {$name_field} = :name";
            $nameCheckStmt = $this->pdo->prepare($nameCheckSql);
            $nameCheckStmt->bindValue(':name', $name);
            $nameCheckStmt->execute();
            $exists = $nameCheckStmt->fetchColumn();

            if ($exists > 0) {
                $this->response['success'] = false;
                $this->response['message'] = "The Property already exists!";
                return json_encode($this->response);
            }

            $unique_image_name = uniqid() . '_' . basename($image['name']);
            $image_path = $image_path . $unique_image_name;


            if (!move_uploaded_file($image['tmp_name'], "../" . $image_path)) {
                $this->response['success'] = false;
                $this->response['message'] = "Error Uploading Image";
            } else {

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':image_path', $image_path);

                if ($category_id) {
                    $stmt->bindParam(':category_id', $category_id);
                }

                if ($category_type) {
                    $stmt->bindParam(':category_type', $category_type);
                }


                $stmt->execute();
                $this->response['success'] = true;
                $this->response['message'] = "Property added successfully.";
            }
        } catch (Exception $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error adding Property: " . $e->getMessage();
        }
        return json_encode($this->response);
    }

    // Update classification (texture, material, color)
    public function update_classification($id, $classification, $texture = null, $material = null, $hex_value = null)
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check for existing values
            if ($classification == 'texture' && $texture) {
                $nameCheckSql = "SELECT COUNT(*) FROM classification WHERE texture_name = :name AND id != :id";
                $nameCheckStmt = $this->pdo->prepare($nameCheckSql);
                $nameCheckStmt->bindValue(':name', $texture);
            } elseif ($classification == 'material' && $material) {
                $nameCheckSql = "SELECT COUNT(*) FROM classification WHERE material_name = :name AND id != :id";
                $nameCheckStmt = $this->pdo->prepare($nameCheckSql);
                $nameCheckStmt->bindValue(':name', $material);
            } elseif ($classification == 'color' && $hex_value) {
                $nameCheckSql = "SELECT COUNT(*) FROM classification WHERE hex_value = :name AND id != :id";
                $nameCheckStmt = $this->pdo->prepare($nameCheckSql);
                $nameCheckStmt->bindValue(':name', $hex_value);
            }

            if (isset($nameCheckStmt)) {
                $nameCheckStmt->bindValue(':id', $id);
                $nameCheckStmt->execute();
                if ($nameCheckStmt->fetchColumn() > 0) {
                    $this->response['success'] = false;
                    $this->response['message'] = "This value already exists!";
                    return json_encode($this->response);
                }
            }

            // Update the appropriate field based on classification type
            $sql = "UPDATE classification SET classification = :classification";
            $params = [':classification' => $classification, ':id' => $id];

            if ($classification == 'texture') {
                $sql .= ", texture_name = :texture_name, material_name = NULL, hex_value = NULL";
                $params[':texture_name'] = $texture;
            } elseif ($classification == 'material') {
                $sql .= ", material_name = :material_name, texture_name = NULL, hex_value = NULL";
                $params[':material_name'] = $material;
            } elseif ($classification == 'color') {
                $sql .= ", hex_value = :hex_value, texture_name = NULL, material_name = NULL";
                $params[':hex_value'] = $hex_value;
            }

            $sql .= " WHERE id = :id";

            $stmt = $this->pdo->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->execute();
            $this->response['success'] = true;
            $this->response['message'] = "Classification updated successfully.";
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error updating classification: " . $e->getMessage();
        }
        return json_encode($this->response);
    }

    // Update classification with image (category, brand)
    public function update_classification_with_image($classification, $id, $name, $image_path = null, $category_id = null, $category_type = null)
    {
        try {
            if ($classification == "brand") {
                $table = "brand";
                $name_field = "brand_name";
            } else if ($classification == "category") {
                $table = "category";
                $name_field = "category_name";
            }

            $checkStmt = $this->pdo->prepare("SELECT COUNT(*) FROM {$table} WHERE {$name_field} = :name AND id != :id");
            $checkStmt->bindParam(':name', $name);

            $checkStmt->bindParam(':id', $id);
            $checkStmt->execute();

            if ($checkStmt->fetchColumn() > 0) {
                return json_encode([
                    'success' => false,
                    'message' => 'The Property already exists!'
                ]);
            }

            $sql = "UPDATE {$table} SET {$name_field} = :name";
            $params = [':name' => $name, ':id' => $id];

            if ($image_path !== null) {
                $sql .= ", image_path = :image_path";
                $params[':image_path'] = $image_path;
            }

            if ($category_id !== null) {
                $sql .= ", category_id = :category_id";
                $params[':category_id'] = $category_id;
            }

            if ($category_type !== null) {
                $sql .= ", category_type = :category_type";
                $params[':category_type'] = $category_type;
            }


            $sql .= " WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);

            if ($stmt->execute($params)) {
                return json_encode([
                    'success' => true,
                    'message' => 'Property updated successfully'
                ]);
            }
            return json_encode([
                'success' => false,
                'message' => 'Failed to update Property'
            ]);
        } catch (Exception $e) {
            return json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    // Delete classification (texture, material, color)
    public function delete_classification($ids)
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $deleteCsfStmt = $this->pdo->prepare("DELETE FROM classification WHERE id IN ($placeholders)");
            $deleteCsfStmt->execute($ids);

            $this->response['success'] = true;
            $this->response['message'] = "Classification deleted successfully.";
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error deleting classification: " . $e->getMessage();
        }
        return json_encode($this->response);
    }

    // Delete category and its brands
    public function delete_category_with_brands($category_ids)

    {
        try {
            $this->pdo->beginTransaction();
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $placeholders = implode(',', array_fill(0, count($category_ids), '?'));

            $getCategoryImagesStmt = $this->pdo->prepare("SELECT image_path FROM category WHERE id IN ($placeholders)");
            $getCategoryImagesStmt->execute($category_ids);
            $categoryImages = $getCategoryImagesStmt->fetchAll(PDO::FETCH_COLUMN);

            foreach ($categoryImages as $image) {
                if (file_exists("../" . $image)) {
                    unlink("../" . $image);
                }
            }

            $getBrandImagesStmt = $this->pdo->prepare("SELECT image_path FROM brand WHERE category_id IN ($placeholders)");
            $getBrandImagesStmt->execute($category_ids);
            $brandImages = $getBrandImagesStmt->fetchAll(PDO::FETCH_COLUMN);

            foreach ($brandImages as $image) {
                if (file_exists("../" . $image)) {
                    unlink("../" . $image);
                }
            }

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

    // Delete brand
    public function delete_brand($ids)
    {
        try {
            $this->pdo->beginTransaction();
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            $getBrandImagesStmt = $this->pdo->prepare("SELECT image_path FROM brand WHERE id IN ($placeholders)");
            $getBrandImagesStmt->execute($ids);
            $brandImages = $getBrandImagesStmt->fetchAll(PDO::FETCH_COLUMN);

            foreach ($brandImages as $image) {
                if (file_exists("../" . $image)) {
                    unlink("../" . $image);
                }
            }

            $deleteBrandStmt = $this->pdo->prepare("DELETE FROM brand WHERE id IN ($placeholders)");
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

    // Delete items (category, brand, texture, material, color)
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

    //change status of data
    public function update_status($classification, $ids)
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Determine the table based on the classification
            if ($classification == 'category') {
                $table = "category";
            } elseif ($classification == 'brand') {
                $table = "brand";
            } else {
                $table = "classification";
            }

            // Create placeholders for the IDs
            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            // Fetch the current status of the items
            $selectStmt = $this->pdo->prepare("SELECT id, status FROM $table WHERE id IN ($placeholders)");
            $selectStmt->execute($ids);
            $items = $selectStmt->fetchAll(PDO::FETCH_ASSOC);

            // Update the status of each item
            foreach ($items as $item) {
                $newStatus = ($item['status'] == 'active') ? 'inactive' : 'active';
                $updateStmt = $this->pdo->prepare("UPDATE $table SET status = :status WHERE id = :id");
                $updateStmt->execute([
                    ':status' => $newStatus,
                    ':id' => $item['id']
                ]);
            }

            $this->response['success'] = true;
            $this->response['message'] = "Status updated successfully.";
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error updating status: " . $e->getMessage();
        }
        return json_encode($this->response);
    }
}
