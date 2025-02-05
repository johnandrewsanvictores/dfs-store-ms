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

            <?php if ($login_user_data->role == 'superadmin') { ?>
                <li class="item">
                    <a href="staff.php">Staff Account Management</a>
                </li>
            <?php } ?>

            <li class="item">
                <a href="product_classification.php">Product Classification</a>
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

            <li class="item">
                <a href="pos.php">POS</a>
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
    <div class="user-nav-div" id="user-dropdown-trigger">
        <div class="user-container">
            <div class="user-info-display">
                <img src="<?php echo '../' . ($login_user_data->image_path ?? 'assets/images/default_profile.png'); ?>" alt="Profile Picture" class="nav-profile-pic">
                <p><?php echo ucfirst($login_user_data->name); ?> <span class="role-text-nav">(<?php echo ucfirst($login_user_data->role); ?>)</span></p>
                <i class="fa-solid fa-caret-down" id="caret-down"></i>
            </div>
            <div class="dropdown-menu">
                <div class="dropdown-header">
                    <img src="<?php echo '../' . ($login_user_data->image_path ?? 'assets/images/default_profile.png'); ?>" alt="Profile Picture" class="dropdown-profile-pic">
                    <div class="dropdown-user-info">
                        <p class="user-name"><?php echo ucfirst($login_user_data->name); ?></p>
                        <p class="user-role">(<?php echo ucfirst($login_user_data->role); ?>)</p>
                    </div>
                </div>
                <hr>
                <ul class="dropdown-links">
                    <li>
                        <a href="#" class="dropdown-item">
                            <i class="fa-solid fa-user-gear"></i>
                            Manage Account
                        </a>
                    </li>
                    <li>
                        <button id="logout-btn" type="button"class="dropdown-item">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Log out
                        </button>
                    </li>
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
        z-index: 1000;
    }

    .navbar #sidebar-close {
        cursor: pointer;
    }

    .user-nav-div {
        display: flex;
        align-items: center;
        gap: 1em;
        cursor: pointer;
        padding: 0.3em;
        border-radius: 8px;
        transition: background-color 0.2s;
    }

    .user-nav-div:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .user-container {
        position: relative;
    }

    .user-info-display {
        display: flex;
        align-items: center;
        gap: 0.8em;
    }

    .nav-profile-pic {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--white-bg);
    }

    .user-info-display p {
        font-size: var(--body);
        color: var(--font-white);
    }

    .role-text-nav {
        color: var(--font-white);
        opacity: 0.8;
    }

    .dropdown-menu {
        position: absolute;
        top: calc(100% + 0.5em);
        right: 0;
        background: var(--white-bg);
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        width: 250px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
    }

    .dropdown-menu.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-header {
        padding: 1.5em;
        text-align: center;
        background-color: var(--white-bg);
        border-radius: 8px 8px 0 0;
        display:flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .dropdown-profile-pic {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 1em;
        border: 3px solid var(--primary);
    }

    .dropdown-user-info .user-name {
        color: var(--font-dark);
        font-weight: 600;
        font-size: var(--body);
    }

    .dropdown-user-info .user-role {
        color: var(--primary);
        font-size: var(--small);
    }

    .dropdown-menu hr {
        margin: 0;
        border: none;
        border-top: 1px solid var(--stroke-grey);
    }

    .dropdown-links {
        list-style: none;
        padding: 0.8em;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.8em;
        padding: 0.8em 1em;
        color: var(--font-dark);
        text-decoration: none;
        border-radius: 6px;
        transition: all 0.2s ease;
        width: 100%;
        font-size: var(--small);
        background: none;
        border: none;
        cursor: pointer;
        font-family: inherit;
    }

    .dropdown-item:hover {
        background-color: var(--stroke-grey);
    }

    #logout-btn {
        color: var(--red);
    }

    #logout-btn i {
        color: var(--red);
    }

    #caret-down {
        font-size: 14px;
        transition: transform 0.3s ease;
    }

    #caret-down.active {
        transform: rotate(180deg);
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

    const userDropdownTrigger = document.querySelector('#user-dropdown-trigger');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    const caretIcon = document.querySelector('#caret-down');

    userDropdownTrigger.addEventListener('click', () => {
        dropdownMenu.classList.toggle('active');
        caretIcon.classList.toggle('active');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.user-nav-div')) {
            dropdownMenu.classList.remove('active');
            caretIcon.classList.remove('active');
        }
    });
</script>