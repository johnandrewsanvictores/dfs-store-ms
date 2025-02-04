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
    //get specific staff acc data
    if (isset($_POST['action']) && $_POST['action'] == "get_specific_data") {
        $response = $staff_acc_model->get_staff_acc_data(['id' => $_POST['id']]);
        echo $response;
        exit();
    }

    //adding staff account
    if (isset($_POST['action']) && $_POST['action'] === 'add_data') {

        $name = $_POST['name'];
        $username = $_POST['username'];
        $phone_number = $_POST['pnumber'];
        $role = $_POST['role'];
        $password = $_POST['password'];
        $staff_id = $staff_acc_model->generate_next_staff_id();

        $email = $_POST['email'];
        $status = $_POST['status'];
        $profile_pic = $_FILES['profile_pic'];
        $address = $_POST['address'];

        $response = $staff_acc_model->add_staff_acc($staff_id, $name, $username, $phone_number, $role, $password, $email, $status, $profile_pic, $address);

        echo $response;
        return $response;
    }

    //updating staff account
    if (isset($_POST['action']) && $_POST['action'] == "update_data") {
        $staff_id = $_POST['staff-id'];
        $name = $_POST['name'];
        $username = $_POST['username'];
        $phone_number = $_POST['pnumber'];
        $role = $_POST['role'];
        $password = $_POST['password'];

        $email = $_POST['email'];
        $status = $_POST['status'];
        $profile_pic = $_FILES['profile_pic'];
        $address = $_POST['address'];

        if (isset($profile_pic) && $profile_pic['name']) {
            $uploadDir = 'assets/uploads/staff_profile/';
            $fileExtension = pathinfo($profile_pic['name'], PATHINFO_EXTENSION);
            $uniqueFilename = uniqid() . '.' . $fileExtension;
            $targetFile = $uploadDir . $uniqueFilename;

            if (!file_exists('../' . $uploadDir)) {
                mkdir('../' . $uploadDir, 0777, true);
            }

            if (move_uploaded_file($profile_pic['tmp_name'], '../' . $targetFile)) {
                $image_path = $targetFile;
                if (isset($_POST['old-img-src']) && file_exists('../' . $_POST['old-img-src'])) {
                    unlink('../' . $_POST['old-img-src']);
                }
            }
        } else {
            $image_path = $_POST['old-img-src'] ?? null;
        }

        $response = $staff_acc_model->update_staff_acc($staff_id, $name, $username, $phone_number, $role, $password, $email, $status, $profile_pic, $address);
        echo $response;
        return $response;
    }

    //removing staff account/s
    if (isset($_POST['action']) && $_POST['action'] === 'remove_data' && isset($_POST['ids'])) {
        $response = $staff_acc_model->remove_staff_acc('ids');

        echo $response;
        return $response;
    }
}
