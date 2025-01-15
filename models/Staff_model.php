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

    public function add_staff_acc($staff_id, $name, $username, $phone_number, $role, $password)
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

            $stmt = $this->pdo->prepare("INSERT INTO staff_acc (staff_id, name, username, phone_number, role, password)
                                     VALUES (:staff_id, :name, :uname, :pnumber, :role, :password)");

            $stmt->bindParam(':staff_id', $staff_id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':uname', $username);
            $stmt->bindParam(':pnumber', $phone_number);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':password', $password);

            $stmt->execute();

            $this->response['success'] = true;
            $this->response['message'] = "Staff account data added successfully.";
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
}
