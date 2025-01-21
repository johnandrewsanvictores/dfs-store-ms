<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dream Fashion Shop SMS | Staff Account Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />

    <link rel="stylesheet" href="../styles/product_classification.css" />
    <link rel="stylesheet" href="../global.css">
</head>

<body>
    <?php include('../includes/navbar.php'); ?>

    <main class="main">
        <h4>Online Product Classification</h4>
        <div class="form-container">
            <form action="#" method="Post" id="product-property-form">
                <h6>Add Product Property</h6>
                <div class="form-content">
                    <div class="classification-form-container">
                        <label for="role">Classification<span>*</span></label>
                        <div class="container">
                            <div class="select">
                                <select name="classification" id="classification-select">
                                    <option value="" disabled selected>Select an option</option>
                                    <option value="texture">Texture</option>
                                    <option value="material">Material</option>
                                    <option value="color">Color</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="property-name texture-container-form">
                        <label for="texture">Texture</label>
                        <input type="text" name="texture" value="" id="texture" placeholder="Input texture name">
                    </div>

                    <div class="property-name material-container-form">
                        <label for="material">Material</label>
                        <input type="text" name="material" value="" id="material" placeholder="Input material name">
                    </div>

                    <div class="color-form-container">
                        <label for="color">Hex Value</label>
                        <input type="text" name="hexvalue" value="" id="hexvalue" placeholder="Input hexvalue or select color">

                    </div>

                    <div class="color-input">
                        <label for="color">Select Color</label>
                        <input type="color" name="color">
                    </div>

                </div>
                <button type="submit" id="classification-add-btn">Add</button>

            </form>
        </div>
    </main>

    <script src="../js/product_classification.js"></script>
</body>

</html>