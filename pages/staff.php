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
                <div class="controls-staff-left">
                    <button id="staff-new-btn">
                        <i class="fas fa-plus"></i>
                        <span>New</span>
                    </button>
                    <button id="edit-btn">
                        <i class="fas fa-pencil-alt"></i>
                        <span>Edit</span>
                    </button>
                    <button id="view-btn" class="btn btn-secondary">
                        <i class="fa-solid fa-eye"></i>
                        <span>View</span>
                    </button>

                    <button id="selectAll-btn">
                        <span>Select All</span>
                    </button>
                    <button id="deselect-btn">
                        <span>Deselect All</span>
                    </button>
                </div>

                <div class="controls-staff-right">
                    <div class="filter-group">
                        <label>Role:</label>
                        <select id="role-filter">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="cashier">Cashier</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label>Status:</label>
                        <select id="status-filter">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
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
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

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
                        <th>Status</th>
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

    <script>
        document.querySelectorAll('nav a').forEach(el => {
            el.classList.remove("navlink-active");
        });

        document.querySelector('a[href="staff.php"]').classList.add('navlink-active');
    </script>
</body>

</html>