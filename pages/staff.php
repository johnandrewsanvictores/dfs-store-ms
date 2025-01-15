<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dream Fashion Shop SMS | Staff Account Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="../styles/staff.css" />
    <link rel="stylesheet" href="../global.css">
</head>

<body>
    <?php include('../includes/navbar.php'); ?>

    <main class="main">

        <div class="header-staff">
            <h4>Staff Account Management</h4>
            <div class="controls-staff">
                <button id="staff-new-btn">
                    <i class="fas fa-plus"></i>
                    <span>New</span>
                </button>
                <button id="edit-btn">
                    <i class="fas fa-pencil-alt"></i>
                    <span>Edit</span>
                </button>
                <button id="remove-btn">
                    <i class="fas fa-trash"></i>
                    <span>Remove</span>
                </button>

                <button id="selectAll-btn">
                    <span>Select All</span>
                </button>
                <button id="deselect-btn">
                    <span>Deselect All</span>
                </button>
            </div>
        </div>

        <div class="table-div">
            <table id="staff-table" class="display stripe" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Staff Id</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Phone Number </th>
                        <th>Role</th>
                        <th>Date Added</th>
                        <th>Last Login</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td></td>
                        <td>STF001</td>
                        <td>John Andrew San Victores</td>
                        <td>Drew</td>
                        <td>09167003378</td>
                        <td>Admin</td>
                        <td>09-12-24</td>
                        <td>2025-01-11 15:30:45</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>STF002</td>
                        <td>Andrew San Victores</td>
                        <td>Drew</td>
                        <td>09167003378</td>
                        <td>Admin</td>
                        <td>09-12-24</td>
                        <td>2025-01-11 15:30:45</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>STF003</td>
                        <td>John </td>
                        <td>Drew</td>
                        <td>09167003378</td>
                        <td>Cashier</td>
                        <td>09-12-24</td>
                        <td>2025-01-11 15:30:45</td>
                    </tr>

                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Staff Id</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Phone Number </th>
                        <th>Role</th>
                        <th>Date Added</th>
                        <th>Last Login</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </main>

    <?php include('../includes/modals/new_staff_form.php'); ?>


    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>

    <script src="../js/new_staff_form.js"></script>
    <script src="../js/staff.js"></script>

</body>

</html>