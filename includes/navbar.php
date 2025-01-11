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
                <a href="#">Dashboard</a>
            </li>

            <li class="item">
                <a href="#" class="navlink-active">Staff Account Management</a>
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
                        <a href="#">Classification</a>
                    </li>
                    <li class="item">
                        <a href="#">Brand/Category</a>
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
                        <a href="#">Add Supplier</a>
                        <a href="#">Supply Order</a>
                    </li>
                </ul>
            </li>

            <li class="item">
                <a href="#">Inventory</a>
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
        <p>Rhesty Adormeo <span class="role-text-nav">(Admin)</span></p>
        <i class="fa-solid fa-right-from-bracket"></i>
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
        cursor: pointer;
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

    .user-nav-div i {
        cursor: pointer;
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
        background: #e7f2fd;
    }
</style>



<script>
    const sidebar = document.querySelector(".sidebar");
    const sidebarClose = document.querySelector("#sidebar-close");
    const menu = document.querySelector(".menu-content");
    const menuItems = document.querySelectorAll(".submenu-item");
    const subMenuTitles = document.querySelectorAll(".submenu .menu-title");

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
</script>