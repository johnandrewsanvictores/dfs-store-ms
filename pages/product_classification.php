<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dream Fashion Shop SMS | Product Classification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="../styles/product_classification.css" />
    <link rel="stylesheet" href="../global.css">
</head>

<body>
    <?php include('../includes/navbar.php'); ?>

    <main class="main">
        <div class="header-staff">
            <h4>Product Classificaiton</h4>
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
</body>

</html>