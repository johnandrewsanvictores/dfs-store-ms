<?php
require '../includes/connection.php';
require '../models/Staff_model.php';

$staff_acc_model = new Staff_Account_Model($connection);

if (isset($_POST['action']) && $_POST['action'] == "datatableDisplay") {
    $output = $staff_acc_model->get_staff_acc_datatable();

    echo $output;
    exit();
}
