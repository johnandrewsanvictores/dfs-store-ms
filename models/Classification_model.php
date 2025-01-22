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

    public function update_classification($id, $classification, $name, $hex_value = null)
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare("UPDATE classification SET classification = :classification, name = :name, hex_value = :hex_value WHERE id = :id");
            $stmt->bindParam(':classification', $classification);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':hex_value', $hex_value);
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

    public function delete_classification($id)
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare("DELETE FROM classification WHERE id = :id");
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            $this->response['success'] = true;
            $this->response['message'] = "Classification deleted successfully.";
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error deleting classification: " . $e->getMessage();
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
}
