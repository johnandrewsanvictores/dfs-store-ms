<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dream Fashion Shop SMS | Staff Account Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../styles/product_classification.css" />
    <link rel="stylesheet" href="../global.css">
</head>

<body>
    <?php include('../includes/navbar.php'); ?>

    <main class="main">
        <div class="header-classification">
            <h4>Online Product Classification</h4>
            <button id="csf-new-btn">
                <i class="fas fa-plus"></i>
                <span>New</span>
            </button>
        </div>

        <div class="table-container">
            <div class="text-table-container">
                <div class="table-wrapper">
                    <h5>Texture</h5>
                    <table id="texture-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Texture</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Matte</td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Glossy</td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Satin</td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Metallic</td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Velvet</td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Leather</td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-wrapper">
                    <h5>Material</h5>
                    <table id="material-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Material</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Cotton</td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Polyester</td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Wool</td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Silk</td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Linen</td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Denim</td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-wrapper">
                    <h5>Color</h5>
                    <table id="color-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Hex Value</th>
                                <th>Preview</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>#FF5733</td>
                                <td>
                                    <div class="color-preview color-1"></div>
                                </td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>#33FF57</td>
                                <td>
                                    <div class="color-preview color-2"></div>
                                </td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>#3357FF</td>
                                <td>
                                    <div class="color-preview color-3"></div>
                                </td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>#F1C40F</td>
                                <td>
                                    <div class="color-preview color-4"></div>
                                </td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>#8E44AD</td>
                                <td>
                                    <div class="color-preview color-5"></div>
                                </td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>#2ECC71</td>
                                <td>
                                    <div class="color-preview color-6"></div>
                                </td>
                                <td>
                                    <button class="edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <?php include("../includes/modals/classification_form.php") ?>

    <script src="../js/classification_form.js"></script>
    <script src="../js/product_classification.js"></script>

</body>

</html>