<?php
require '../includes/connection.php';
require '../models/Staff_model.php';

session_start();
$staff_acc_model = new Staff_Account_Model($connection);
$response = json_decode($staff_acc_model->get_staff_acc_data(['username' => $_SESSION["username"]]));

$login_user_data = $response->data[0];
?>

<nav class="sidebar">
    <div class="sidebar-header">
        <img src="../assets/images/dfs_logo.jpg" alt="logo">
        <a href="#" class="logo">
            <h6>Store Management System</h6>
        </a>
    </div>

    <div class="menu-content">
        <ul class="menu-items">
            <li class="item">
                <a href="dashboard.php" class="navlink-active">Dashboard</a>
            </li>

            <li class="item">
                <a href="staff.php">Staff Account Management</a>
            </li>

            <li class="item">
                <div class="submenu-item">
                    <span>Product Classification</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>

                <ul class="menu-items submenu">
                    <div class="menu-title">
                        <i class="fa-solid fa-chevron-left"></i>
                        Product Classification
                    </div>
                    <li class="item">
                        <a href="product_classification.php">Classification</a>
                    </li>
                    <li class="item">
                        <a href="category_brand.php">Brand/Category</a>
                    </li>
                </ul>
            </li>

            <li class="item">
                <div class="submenu-item">
                    <span>Supplier</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>

                <ul class="menu-items submenu">
                    <div class="menu-title">
                        <i class="fa-solid fa-chevron-left"></i>
                        Supplier
                    </div>
                    <li class="item">
                        <a href="supplier.php">Add Supplier</a>
                        <a href="supply_order.php">Supply Order</a>
                    </li>
                </ul>
            </li>

            <li class="item">
                <a href="inventory.php">Inventory</a>
            </li>

            <li class="item">
                <a href="#">Sales Report</a>
            </li>

            <hr>

            <li class="item">
                <a href="#">Online Products</a>
            </li>

            <li class="item">
                <div class="submenu-item">
                    <span>Online Orders</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>

                <ul class="menu-items submenu">
                    <div class="menu-title">
                        <i class="fa-solid fa-chevron-left"></i>
                        Online Orders
                    </div>
                    <li class="item">
                        <a href="#">Orders</a>
                        <a href="#">Returned</a>
                    </li>
                </ul>
            </li>

            <li class="item">
                <a href="#">Vouchers and Discounts</a>
            </li>

            <li class="item">
                <a href="#">Ratings and Reviews</a>
            </li>

            <li class="item">
                <a href="#">Ads/Banner</a>
            </li>

        </ul>
    </div>
</nav>

<nav class="navbar">
    <i class="fa-solid fa-bars" id="sidebar-close"></i>
    <div class="user-nav-div">


        <div class="user-container">
            <p><?php echo ucfirst($login_user_data->name); ?> <span class="role-text-nav">(<?php echo ucfirst($login_user_data->role); ?>)</span></p>
            <button id="caret-down-btn">
                <i class="fa-solid fa-caret-down" id="caret-down"></i>
            </button>
            <div class="user-info">
                <ul class="dropdown">
                    <p><?php echo ucfirst($login_user_data->name); ?> <span class="role-text-nav">(<?php echo ucfirst($login_user_data->role); ?>)</span></p>
                    <hr>
                    <li><a href="#">Manage Account</a></li>
                    <li><button id="logout-btn">Log out<i class="fa-solid fa-right-from-bracket"></i></button></li>
                </ul>
            </div>
        </div>
    </div>
</nav>


<style>
    .sidebar {
        position: fixed;
        height: 100%;
        width: 260px;
        background: var(--white-bg);
        z-index: 99;
        border-right: 1px solid var(--stroke-grey);
    }

    .sidebar-header {
        background-color: var(--primary);
        display: flex;
        flex-direction: column;
        gap: 0.5em;
        align-items: center;
        justify-content: center;
        padding: 1.5em;
        text-align: center;
    }

    .sidebar-header h6 {
        color: var(--font-white);
    }

    .sidebar-header img {
        width: 5em;
        height: 5em;
        border-radius: 50%;
    }

    .sidebar a {
        color: var(--font-dark);
        text-decoration: none;
    }

    .menu-content {
        position: relative;
        height: 100%;
        width: 100%;
        overflow-y: scroll;
    }

    .menu-content::-webkit-scrollbar {
        display: none;
    }

    .menu-items {
        height: 100%;
        width: 100%;
        list-style: none;
        transition: all 0.4s ease;
    }

    .submenu-active .menu-items {
        transform: translateX(-56%);
    }

    .menu-title {
        color: var(--font-dark);
        font-size: var(--body);
        padding: 15px 20px;
    }

    .item a,
    .submenu-item {
        padding: 16px;
        display: inline-block;
        width: 100%;
        border-radius: 12px;
    }

    .item i {
        font-size: 12px;
    }

    .item a:hover,
    .submenu-item:hover,
    .submenu .menu-title:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .submenu-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--font-dark);
        cursor: pointer;
    }

    .submenu {
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0;
        right: calc(-100% - 26px);
        height: calc(100% + 100vh);
        background: var(--white-bg);
        display: none;
    }

    .show-submenu~.submenu {
        display: block;
    }

    .submenu .menu-title {
        border-radius: 12px;
        cursor: pointer;
    }

    .submenu .menu-title i {
        margin-right: 10px;
    }

    .navbar,
    .main {
        left: 260px;
        width: calc(100% - 260px);
        transition: all 0.5s ease;
        z-index: 1000;
    }

    .sidebar.close~.navbar,
    .sidebar.close~.main {
        left: 0;
        width: 100%;
    }

    .navbar {
        position: fixed;
        color: var(--font-white);
        padding: 15px 20px;
        font-size: 25px;
        background: var(--primary);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .navbar #sidebar-close {
        cursor: pointer;
    }

    .user-nav-div {
        display: flex;
        gap: 1em;
        align-items: center;
    }

    .user-nav-div p {
        font-size: var(--body);
    }

    #caret-down {
        font-size: 14px;
        color: inherit;
    }

    #caret-down-btn {
        cursor: pointer;
        color: inherit;
        background: transparent;
        outline: none;
        border: none;
    }

    .user-container {
        display: flex;
        gap: 0.5em;
        align-items: center;
        -webkit-user-select: none;
        /* Safari */
        -ms-user-select: none;
        /* IE 10 and IE 11 */
        user-select: none;
        /* Standard syntax */
    }

    .user-container div {
        cursor: pointer;
        position: relative;
    }

    .user-container .clicked {
        visibility: visible;
        opacity: 1;
        text-align: left;
        margin-left: 30px;
        padding-top: 20px;
        box-shadow: 0px 3px 5px -1px #ccc;
        z-index: 999;
        top: 30px;
        color: var(--font-dark);
    }

    .user-container .dropdown {
        position: absolute;
        padding-left: 0;
        right: 0;
        background: white;
        min-width: 10em;
        color: var(--font-dark);
        visibility: hidden;
        opacity: 0;

        border-radius: 5px;
        padding: 1.5em 1em;
        box-shadow: 0px 3px 5px -1px #ccc;
        display: flex;
        flex-direction: column;
        gap: 0.5em;
        align-items: flex-end;
        list-style-type: none;
        font-size: var(--body);
        width: 15em;
        margin-top: -10px;
        transition: 0.3s all ease-out;
    }

    .user-container .clicked {
        visibility: visible;
        opacity: 1;
        text-align: left;
        z-index: 999;
        box-shadow: 0px 3px 5px -1px #ccc;
        margin-top: -10px;
        color: var(--font-dark);
    }

    .user-container .dropdown p {
        font-size: var(--body);
        display: flex;
        flex-direction: column;
        align-items: center;
        align-self: center;
        text-align: center;
    }

    .dropdown .role-text-nav {
        color: var(--primary);
    }

    .user-container .dropdown hr {
        border: 1px solid var(--stroke-grey);
        width: 100%;
    }

    .user-container .dropdown li a {
        text-decoration: none;
        color: var(--font-dark);
    }

    .user-container .dropdown li a:hover {
        color: #bbb;
    }

    #logout-btn {
        cursor: pointer;
        border: none;
        outline: none;
        background: transparent;
        display: flex;
        gap: 0.5em;
        align-items: center;
        font-size: inherit;
        color: inherit;
    }

    #logout-btn:hover {
        color: #bbb;
    }



    .user-container div ul .user-nav-div p {
        font-size: var(--body);
    }

    .role-text-nav {
        font-weight: 700;
        color: var(--green);
    }


    hr {
        border: 0.3px solid rgb(199, 199, 199);
    }

    .navlink-active {
        color: var(--secondary) !important;
    }

    .main {
        padding: 2em;
        padding-top: calc(2em + 45px);
        position: relative;
        min-height: 100vh;
        z-index: 100;
        background: rgb(250, 250, 248);
    }
</style>



<script>
    const sidebar = document.querySelector(".sidebar");
    const sidebarClose = document.querySelector("#sidebar-close");
    const menu = document.querySelector(".menu-content");
    const menuItems = document.querySelectorAll(".submenu-item");
    const subMenuTitles = document.querySelectorAll(".submenu .menu-title");

    const logout_btn = document.getElementById('logout-btn');

    sidebarClose.addEventListener("click", () => sidebar.classList.toggle("close"));

    menuItems.forEach((item, index) => {
        item.addEventListener("click", () => {
            menu.classList.add("submenu-active");
            item.classList.add("show-submenu");
            menuItems.forEach((item2, index2) => {
                if (index !== index2) {
                    item2.classList.remove("show-submenu");
                }
            });
        });
    });

    subMenuTitles.forEach((title) => {
        title.addEventListener("click", () => {
            menu.classList.remove("submenu-active");
        });
    });

    var caretdown = document.querySelector('#caret-down');

    caretdown.addEventListener('click', () => {
        document.querySelector('.dropdown').classList.toggle('clicked');
    })

    logout_btn.addEventListener('click', () => Popup1.show_confirm_dialog("Are you sure you want to logout?", logout));


    function logout() {
        const xhr = new XMLHttpRequest();
        const requestBody = 'action=logout'; // Define the action for logout

        xhr.open('POST', '/dfs-store-ms/api/logout.php', true); // Point to your PHP logout script
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Parse the response
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    console.log(response.message); // Optional: Log the message
                    // Redirect to the login page
                    window.location.href = '/dfs-store-ms/pages/login.php';
                } else {
                    console.error('Logout failed:', response.message);
                    alert('Error: ' + response.message);
                }
            }
        };

        xhr.send(requestBody); // Send the action to the server
    }

    const Popup1 = (function() {
        function show_message(msg, icon) {
            Swal.fire({
                position: "top right",
                icon: icon,
                title: msg,
                showConfirmButton: false,
                timer: 1500
            });
        }

        function show_confirm_dialog(msg, callback) {
            Swal.fire({
                text: msg,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            });
        }

        return {
            show_message,
            show_confirm_dialog
        }
    })();
</script>