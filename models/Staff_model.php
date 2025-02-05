<?php

class Staff_Account_Model
{
    private $pdo;
    private $response;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->response = array();
    }

    public function get_staff_acc_datatable()
    {
        try {

            $sql = "SELECT 
                    staff_acc.id,
                    staff_acc.staff_id,
                    staff_acc.name,
                    staff_acc.username,
                    staff_acc.phone_number,
                    staff_acc.role,
                    staff_acc.date_added,
                    staff_acc.last_login
                FROM 
                    staff_acc";

            $whereClauses = [];
            $params = [];

            $columns = [
                0 => 'staff_acc.id',
                1 => 'staff_acc.staff_id',
                2 => 'staff_acc.name',
                3 => 'staff_acc.username',
                4 => 'staff_acc.phone_number',
                5 => 'staff_acc.role',
                6 => 'staff_acc.date_added',
                7 => 'staff_acc.last_login',
            ];

            if (isset($_POST['search']['value']) && $_POST['search']['value'] != '') {
                $search_value = $_POST['search']['value'];
                $whereClauses[] = "(staff_acc.name LIKE :search OR staff_acc.username LIKE :search)";
                $params[':search'] = "%$search_value%";
            }

            if (!empty($whereClauses)) {
                $sql .= " WHERE " . implode(" AND ", $whereClauses);
            }

            $countSql = "SELECT COUNT(*) FROM (" . $sql . ") AS total";
            $countStmt = $this->pdo->prepare($countSql);

            foreach ($params as $param => $value) {
                $countStmt->bindValue($param, $value);
            }
            $countStmt->execute();
            $totalRecords = $countStmt->fetchColumn();

            if (isset($_POST['order'])) {
                $column_name = $_POST['order'][0]['column'];
                $order = $_POST['order'][0]['dir'];
                $sql .= " ORDER BY " . $columns[$column_name] . " " . $order;
            } else {
                $sql .= " ORDER BY staff_acc.staff_id ASC";
            }

            if ($_POST['length'] != -1) {
                $limit = $_POST['length'];
                $offset = $_POST['start'];
                $sql .= " LIMIT :limit OFFSET :offset";
            }

            $stmt = $this->pdo->prepare($sql);

            foreach ($params as $param => $value) {
                $stmt->bindValue($param, $value);
            }

            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $output = [
                'draw' => intval($_POST['draw']),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $results,
            ];

            return json_encode($output);
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error retrieving staff account: " . $e->getMessage();
            return json_encode($this->response);
        }
    }

    public function add_staff_acc($staff_id, $name, $username, $phone_number, $role, $password, $email, $status, $profile_pic, $address)
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the name already exists in the staff_acc table
            $nameCheckSql = "SELECT COUNT(*) FROM staff_acc WHERE name = :name OR username = :uname";
            $nameCheckStmt = $this->pdo->prepare($nameCheckSql);
            $nameCheckStmt->bindValue(':name', $name);
            $nameCheckStmt->bindValue(':uname', $username);
            $nameCheckStmt->execute();

            // Get the count of matching names
            $exists = $nameCheckStmt->fetchColumn();

            if ($exists > 0) {
                $this->response['success'] = false;
                $this->response['message'] = "The Staff already exists!";
                return json_encode($this->response);
            }

            $image_path = 'assets/uploads/staff_profile/';
            $unique_image_name = uniqid() . '_' . basename($profile_pic['name']);
            $image_path = $image_path . $unique_image_name;

            if (!move_uploaded_file($profile_pic['tmp_name'], "../" . $image_path)) {
                $this->response['success'] = false;
                $this->response['message'] = "Error Uploading Image";
            } else {
                

                $stmt = $this->pdo->prepare("INSERT INTO staff_acc (staff_id, name, username, phone_number, role, password, image_path, email, status, address)
                                        VALUES (:staff_id, :name, :uname, :pnumber, :role, :password, :image_path, :email, :status, :address)");

                $password_hash = password_hash($password, PASSWORD_BCRYPT);

                $stmt->bindParam(':staff_id', $staff_id);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':uname', $username);
                $stmt->bindParam(':pnumber', $phone_number);
                $stmt->bindParam(':role', $role);
                $stmt->bindParam(':password', $password_hash);
                $stmt->bindParam(':image_path', $image_path);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':address', $address);

                $stmt->execute();

                $this->response['success'] = true;
                $this->response['message'] = "Staff account data added successfully.";
            }
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error adding Staff account data: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    public function generate_next_staff_id()
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Retrieve the last staff_id from the database
            $query = "SELECT staff_id FROM staff_acc ORDER BY id DESC LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            $lastStaffId = $stmt->fetchColumn();

            if ($lastStaffId) {
                $numericPart = (int)substr($lastStaffId, 3);
                $nextNumericPart = $numericPart + 1;
                $staff_id = 'STF' . str_pad($nextNumericPart, 3, '0', STR_PAD_LEFT);
            } else {
                // If no records exist, start with STF001
                $staff_id = 'STF001';
            }

            return $staff_id;
        } catch (PDOException $e) {
            return "Error generating staff_id: " . $e->getMessage();
        }
    }

    public function get_staff_acc_data($filters = [])
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Base SQL query with dynamic column selection
            $sql = "SELECT * FROM staff_acc";

            $whereClauses = [];
            $params = [];

            // Process filters
            foreach ($filters as $column => $value) {
                $whereClauses[] = "$column = :$column";
                $params[":$column"] = $value;
            }

            if (!empty($whereClauses)) {
                $sql .= " WHERE " . implode(" AND ", $whereClauses);
            }

            $sql .= " LIMIT 1";

            $stmt = $this->pdo->prepare($sql);

            foreach ($params as $param => $value) {
                $stmt->bindValue($param, $value);
            }

            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->response['success'] = true;
            $this->response['message'] = "Retrieved";
            $this->response['data'] = $results;

            return json_encode($this->response);
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error retrieving staff account data: " . $e->getMessage();
            return json_encode($this->response);
        }
    }

    public function update_staff_acc($staff_id, $name, $username, $pnumber, $role, $password)
    {
        $sql = "";
        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the business exists
            $staff_acc_check_stmt = $this->pdo->prepare("SELECT COUNT(*) FROM staff_acc WHERE staff_id = :id");
            $staff_acc_check_stmt->bindParam(':id', $staff_id);
            $staff_acc_check_stmt->execute();
            $staff_exists = $staff_acc_check_stmt->fetchColumn();

            if (!$staff_exists) {
                $this->response['success'] = false;
                $this->response['message'] = "Staff ID does not exist. " . $staff_id;
                return json_encode($this->response);
            }


            $sql = "UPDATE staff_acc 
                                     SET name = :name, username = :uname, phone_number = :pnumber, 
                                         role = :role";

            if (!empty($password)) {
                $sql .= ", password = :password";
            }

            $sql .= " WHERE staff_id = :staff_id";

            // Update the business table
            $stmt = $this->pdo->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':uname', $username);
            $stmt->bindParam(':pnumber', $pnumber);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':staff_id', $staff_id);

            if (!empty($password)) {
                $password_hash = password_hash($password, PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $password_hash);
            }

            // Execute the update statement
            $stmt->execute();

            $this->response['success'] = true;
            $this->response['message'] = "$staff_id updated successfully.";
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error updating data: " . $e->getMessage();
        }

        return json_encode($this->response);
    }

    function remove_staff_acc($ids)
    {
        $idsArray = json_decode($_POST[$ids], true);
        $placeholders = [];
        foreach ($idsArray as $id) {
            $placeholders[] = '?';
        }
        $placeholdersString = implode(',', $placeholders);

        try {
            $deleteQuery = "DELETE FROM staff_acc WHERE id IN ($placeholdersString)";
            $deleteStmt = $this->pdo->prepare($deleteQuery);
            $deleteStmt->execute($idsArray); // Execute with the IDs array

            // Check if the delete was successful
            if ($deleteStmt->rowCount() > 0) {
                $this->response['success'] = true;
                $this->response['message'] = "Staff account/s removed successfully.";
            } else {
                $this->response['success'] = false;
                $this->response['message'] = "No accounts were removed.";
            }
        } catch (PDOException $e) {
            $this->response['success'] = false;
            $this->response['message'] = "Error removing account: " . $e->getMessage();
        }

        return json_encode($this->response);
    }
}
