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
        <div class="classification-header">
            <h4>Online Product Classification</h4>
            <div class="controls-container">
                <div class="controls-left">
                    <button id="csf-new-btn">
                        <i class="fas fa-plus"></i>
                        <span>New</span>
                    </button>

                    <button id="selectAll-btn">
                        <span>Select All</span>
                    </button>
                    <button id="deselect-btn">
                        <span>Deselect All</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="filter-tabs">
            <button class="filter-tab active" data-filter="category">Category</button>
            <button class="filter-tab" data-filter="brand">Brand</button>
            <button class="filter-tab" data-filter="texture">Texture</button>
            <button class="filter-tab" data-filter="material">Material</button>
            <button class="filter-tab" data-filter="color">Color</button>
        </div>

        <div class="list-header">
            <div style="display: flex; align-items: center; gap: 1em;">
                <h5 id="list-title">List of Categories</h5>
                <input type="search" id="search-input" placeholder="Search...">
            </div>
            <div class="list-controls">
                <div class="filter-group category-type-filter" style="display: none;">
                    <label>Category Type:</label>
                    <select id="category-type-dropdown">
                        <option value="">All Types</option>
                        <option value="physical">Physical</option>
                        <option value="online">Online</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Sort:</label>
                    <select class="sort-dropdown">
                        <option value="default">Default</option>
                        <option value="name-asc">Name (A-Z)</option>
                        <option value="name-desc">Name (Z-A)</option>
                        <option value="date-asc">Oldest First</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Status:</label>
                    <select id="status-dropdown">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <button id="remove-selected-btn" disabled>Remove selected (0)</button>
            <button id="change-status-selected-btn" disabled>Change Status selected (0)</button>
        </div>

        <div class="card-container" id="card-container">
            <!-- Cards will be dynamically inserted here -->
        </div>
    </main>

    <?php include("../includes/modals/classification_form.php") ?>

    <script src="../js/classification_form.js"></script>
    <script src="../js/product_classification.js"></script>

    <script>
        document.querySelectorAll('nav a').forEach(el => {
            el.classList.remove("navlink-active");
        });

        document.querySelector('a[href="product_classification.php"]').classList.add('navlink-active');
    </script>

</body>

</html>