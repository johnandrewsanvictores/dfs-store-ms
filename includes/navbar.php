<nav>
    <div class="nav-bar">
        <div class="left-nav">
            <i class="fa-solid fa-bars sidebarOpen"></i>
            <div class="logo-div">
                <img src="../assets/images/main/logo.jpg" alt="" srcset="">
                <span class="logo navLogo"><a href="#">Dream Shop Bags</a></span>
            </div>
        </div>

        <div class="right-nav">

            <div class="menu">
                <div class="logo-toggle">
                    <span class="logo"><a href="#">Dream Shop Bags</a></span>
                    <i class="fa-solid fa-xmark siderbarClose"></i>

                </div>
                <ul class=" nav-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <div id="btns-unauthenticated">
                        <a href="#">Login</a>
                        <a href="#" id="register-btn">Register</a>
                    </div>
                    <li style="display:none"><a href="#">My Account</a></li>
                </ul>
            </div>
            <div class="nav-icons-container">
                <i class="fa-solid fa-cart-shopping" id="cart-icon"></i>
                <div class="darkLight-searchBox">
                    <div class="searchBox">
                        <div class="searchToggle">
                            <i class="fa-solid fa-xmark" id="nav-search-x"></i>
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <div class="search-field">
                            <input type="text" placeholder="Search...">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>


<script>
    const body = document.querySelector("body"),
        nav = document.querySelector("nav"),
        searchToggle = document.querySelector(".searchToggle"),
        sidebarOpen = document.querySelector(".sidebarOpen"),
        siderbarClose = document.querySelector(".siderbarClose");


    // js code to toggle search box
    searchToggle.addEventListener("click", () => {
        searchToggle.classList.toggle("active");
    });


    //   js code to toggle sidebar
    sidebarOpen.addEventListener("click", () => {
        nav.classList.add("active");
    });
    body.addEventListener("click", e => {
        let clickedElm = e.target;
        if (!clickedElm.classList.contains("sidebarOpen") && !clickedElm.classList.contains("menu")) {
            nav.classList.remove("active");
        }
    });
</script>

<style>
    nav {
        position: fixed;
        top: 0;
        left: 0;
        height: 70px;
        width: 100%;
        background-color: var(--white-bg);
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        z-index: 100;
    }

    body.dark nav {
        border: 1px solid #393838;
    }

    nav .nav-bar {
        position: relative;
        height: 100%;
        width: 100%;
        margin: 0 auto;
        padding: 0 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    nav .nav-bar .sidebarOpen {
        color: var(--font-dark);
        font-size: 25px;
        padding: 5px;
        cursor: pointer;
        display: none;
    }

    nav .nav-bar .logo a {
        font-size: 25px;
        font-weight: 500;
        color: var(--font-dark);
        text-decoration: none;
    }

    .menu .logo-toggle {
        display: none;
    }


    .logo-div {
        display: flex;
        gap: 1em;
        align-items: center;
    }

    .logo-div img {
        height: 50px;
        width: 50px;
        border-radius: 50%;
    }

    .left-nav {
        display: flex;
        gap: 2em;
        align-items: center;
    }

    .right-nav {
        display: flex;
        align-items: center;
        gap: 2em;
    }

    .logo-div span a {
        font-size: var(--h6);
        font-weight: 500;
        font-family: "Lobster", serif;

    }

    .nav-bar .nav-links {
        display: flex;
        align-items: center;
    }

    .nav-bar .nav-links li {
        margin: 0 5px;
        list-style: none;
    }

    .nav-links li a {
        position: relative;
        font-size: var(--body);
        font-weight: 400;
        color: var(--font-dark);
        text-decoration: none;
        padding: 10px;
    }

    .nav-links li a::before {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        height: 6px;
        width: 6px;
        border-radius: 50%;
        background-color: var(--font-white);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .nav-links li:hover a::before {
        opacity: 1;
    }

    #btns-unauthenticated {
        display: flex;
        gap: 0.5em;
    }


    #btns-unauthenticated a {
        text-decoration: none;
        color: inherit;
        background-color: var(--primary);
        padding: 0.75em 1.5em;
        color: var(--font-white);
        border-radius: 10px;
        font-size: var(--small);
        display: flex;
        justify-content: center;
        align-items: center;
    }


    #register-btn {
        color: var(--font-dark) !important;
        background: transparent !important;
        border: 2px solid var(--primary);
    }

    #btns-unauthenticated a:hover {
        background-color: var(--primary-hover-color) !important;
    }

    #register-btn:hover {
        background-color: var(--tertiary) !important;
        color: var(--font-white) !important;
    }

    .nav-icons-container {
        display: flex;
        align-items: center;
        gap: .25em;
    }

    .nav-bar .darkLight-searchBox {
        display: flex;
        align-items: center;
    }

    #cart-icon {
        font-size: 20px;
    }

    .darkLight-searchBox .dark-light,
    .darkLight-searchBox .searchToggle {
        height: 40px;
        width: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 5px;
    }

    .dark-light i,
    .searchToggle i {
        position: absolute;
        color: var(--font-dark);
        font-size: 22px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .searchToggle i.fa-xmark {
        opacity: 0;
        pointer-events: none;
    }

    .searchToggle.active i.fa-xmark {
        opacity: 1;
        pointer-events: auto;
    }

    .searchToggle.active i.fa-magnifying-glass {
        opacity: 0;
        pointer-events: none;
    }

    .searchBox {
        position: relative;
    }

    .searchBox .search-field {
        position: absolute;
        bottom: -85px;
        right: 5px;
        height: 50px;
        width: 300px;
        display: flex;
        align-items: center;
        background-color: var(--primary);
        padding: 3px;
        border-radius: 6px;
        box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1);
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    .searchToggle.active~.search-field {
        bottom: -74px;
        opacity: 1;
        pointer-events: auto;
    }

    .search-field::before {
        content: '';
        position: absolute;
        right: 14px;
        top: -4px;
        height: 12px;
        width: 12px;
        background-color: var(--primary);
        transform: rotate(-45deg);
        z-index: -1;
    }

    .search-field input {
        height: 100%;
        width: 100%;
        padding: 0 45px 0 15px;
        outline: none;
        border: none;
        border-radius: 4px;
        font-size: var(--small);
        font-weight: 400;
        color: var(--font-dark);
        background-color: var(--white-bg);
    }

    .search-field i {
        position: absolute;
        color: var(--primary);
        right: 15px;
        font-size: 22px;
        cursor: pointer;
    }


    @media (max-width: 790px) {
        nav .nav-bar .sidebarOpen {
            display: block;
        }

        .nav-links li a,
        nav .nav-bar .logo-toggle .logo a {
            color: var(--font-white);
        }

        nav .nav-bar .logo-toggle .logo a {
            font-size: var(--h4);
            font-family: "Lobster", serif;
        }

        .menu {
            position: fixed;
            height: 100%;
            width: 320px;
            left: -100%;
            top: 0;
            padding: 20px;
            background-color: var(--dark-bg);
            z-index: 100;
            transition: all 0.4s ease;
        }

        nav.active .menu {
            left: -0%;
        }

        nav.active .nav-bar .navLogo a {
            opacity: 0;
            transition: all 0.3s ease;
        }

        .menu .logo-toggle {
            display: block;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-toggle .siderbarClose {
            color: var(--font-white);
            font-size: 24px;
            cursor: pointer;
        }

        .nav-bar .nav-links {
            flex-direction: column;
            padding-top: 30px;
        }

        .nav-links li a {
            display: block;
            margin-top: 20px;
        }

        #btns-unauthenticated {
            margin-top: 2em;
            flex-direction: column;
            color: var(--font-white);
        }

        #register-btn {
            color: var(--font-white) !important;
        }
    }

    @media screen and (max-width: 466px) {
        .logo-div span {
            display: none;
        }

    }
</style>