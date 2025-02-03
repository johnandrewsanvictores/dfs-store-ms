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

        <div class="filter-tabs">
            <button class="filter-tab active" data-filter="category">Category</button>
            <button class="filter-tab" data-filter="brand">Brand</button>
            <button class="filter-tab" data-filter="texture">Texture</button>
            <button class="filter-tab" data-filter="material">Material</button>
            <button class="filter-tab" data-filter="color">Color</button>
        </div>

        <div class="title-search-sort-container">
            <h5 id="list-title">List of Categories</h5>
            <div class="search-sort-container">
                <input type="text" id="search-input" placeholder="Search..." class="search-input">
                <div class="filter-status-dropdown-container">
                    <select class="filter-status-dropdown">
                        <option value="">All</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="sort-dropdown-container">
                    <select class="sort-dropdown">
                        <option value="default">Default</option>
                        <option value="name-asc">Name (A-Z)</option>
                        <option value="name-desc">Name (Z-A)</option>
                        <option value="date-asc">Oldest First</option>
                        <option value="date-desc">Newest First</option>
                    </select>
                    <i class="fas fa-sort"></i>
                </div>
            </div>
        </div>

        <button class="remove-selected-btn" id="remove-selected-btn" disabled>Remove selected (0)</button>

        <div class="card-container" id="card-container">
            <!-- Cards will be dynamically inserted here -->
        </div>
    </main>

    <?php include("../includes/modals/classification_form.php") ?>

    <script src="../js/classification_form.js"></script>
    <script src="../js/product_classification.js"></script>

</body>

</html>