<?php
require '../includes/connection.php';
require '../models/Staff_model.php';

$staff_acc_model = new Staff_Account_Model($connection);

if (isset($_POST['action']) && $_POST['action'] == "datatableDisplay") {
    $output = $staff_acc_model->get_staff_acc_datatable();

    echo $output;
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //adding staff account
    if (isset($_POST['action']) && $_POST['action'] === 'add_data') {

        $name = $_POST['name'];
        $username = $_POST['username'];
        $phone_number = $_POST['pnumber'];
        $role = $_POST['role'];
        $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $staff_id = $staff_acc_model->generate_next_staff_id();

        $response = $staff_acc_model->add_staff_acc($staff_id, $name, $username, $phone_number, $role, $hashedPassword);

        echo $response;
        return $response;
    }
}
