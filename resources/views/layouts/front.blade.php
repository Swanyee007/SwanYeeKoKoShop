<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />

    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <meta name="description" content="" />
    <meta name="author" content="" />

    {{-- AJAX / CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Black-Berry Online Shop</title>

    <!-- Favicon -->
    <link rel="icon"
          type="image/jpeg"
          href="{{ asset('front-asset/images/blackberry-logo.jpeg') }}" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
          rel="stylesheet" />

    <!-- Core Theme CSS -->
    <link href="{{ asset('front-asset/css/styles.css') }}"
          rel="stylesheet" />


    <style>

        /* =========================================================
           STICKY FOOTER
        ========================================================= */

        html,
        body {
            min-height: 100%;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }


        /* =========================================================
           BRAND LOGO
        ========================================================= */

        .brand-logo {
            height: 52px;
            width: auto;
            max-width: 160px;
            object-fit: contain;
            display: block;
        }

        .brand-name {
            margin-left: 10px;
            font-size: 24px;
            font-weight: 700;
            color: #212529;
            white-space: nowrap;
            letter-spacing: 0.5px;
        }


        /* =========================================================
           FOOTER CONTACT
        ========================================================= */

        .footer-contact {
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            width: 100%;
            margin-top: 20px;
        }


        /* Email / Phone Button */

        .contact-item {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            padding: 10px 15px;

            border-radius: 30px;

            color: #f8f9fa;

            background: rgba(255, 255, 255, 0.08);

            border: 1px solid rgba(255, 255, 255, 0.18);

            text-decoration: none;

            font-size: 14px;

            white-space: nowrap;

            transition: all 0.3s ease;
        }


        /* Contact Icon */

        .contact-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            width: 32px;
            height: 32px;

            border-radius: 50%;

            color: #ffffff;

            background: linear-gradient(
                135deg,
                #6f42c1,
                #0d6efd
            );

            font-size: 15px;
        }


        /* Contact Hover */

        .contact-item:hover {
            color: #ffffff;

            background: rgba(
                13,
                110,
                253,
                0.25
            );

            border-color: #0d6efd;

            transform: translateY(-3px);

            box-shadow:
                0 5px 15px
                rgba(13, 110, 253, 0.25);
        }


        .contact-item:hover .contact-icon {

            background: linear-gradient(
                135deg,
                #0d6efd,
                #6f42c1
            );
        }



        /* =========================================================
           SHOP NESTED DROPDOWN
        ========================================================= */

        .shop-dropdown {
            min-width: 220px;
            padding: 8px 0;
        }


        /* Main Category */

        .main-category-item {
            position: relative;
        }


        .main-category-link {
            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 8px 16px;

            color: #212529;

            text-decoration: none;

            white-space: nowrap;

            cursor: pointer;
        }


        .main-category-link:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
        }


        /* Arrow */

        .category-arrow {
            font-size: 12px;
            margin-left: 20px;
            transition: transform 0.2s ease;
        }


        /* Rotate arrow */

        .main-category-item:hover
        > .main-category-link
        .category-arrow {

            transform: translateX(3px);
        }


        /* =========================================================
           CHILD CATEGORY SUBMENU
        ========================================================= */

        .child-category-menu {
            display: none;

            position: absolute;

            top: 0;

            left: 100%;

            min-width: 190px;

            padding: 8px 0;

            margin: 0;

            background-color: #ffffff;

            border: 1px solid rgba(
                0,
                0,
                0,
                0.15
            );

            border-radius: 0.375rem;

            box-shadow:
                0 0.5rem 1rem
                rgba(0, 0, 0, 0.15);

            list-style: none;

            z-index: 1050;
        }


        /* Desktop Hover */

        @media (min-width: 992px) {

            .main-category-item:hover
            > .child-category-menu {

                display: block;
            }

        }


        /* Child Category Link */

        .child-category-link {
            display: block;

            padding: 8px 16px;

            color: #212529;

            text-decoration: none;

            white-space: nowrap;

            transition:
                background-color 0.2s ease,
                color 0.2s ease;
        }


        .child-category-link:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
        }



        /* =========================================================
           MOBILE NAVBAR
        ========================================================= */

        @media (max-width: 991.98px) {

            .brand-logo {
                height: 45px;
                max-width: 135px;
            }

            .brand-name {
                margin-left: 8px;
                font-size: 19px;
            }

            .shop-dropdown {
                width: 100%;

                min-width: 0;

                border: none;

                box-shadow: none;

                padding: 0;
            }


            .main-category-item {
                width: 100%;
            }


            .main-category-link {
                width: 100%;
                padding: 10px 16px;
            }


            /* Child Menu */

            .child-category-menu {
                position: static;

                display: none;

                width: 100%;

                min-width: 0;

                margin: 0;

                padding: 0;

                border: none;

                border-radius: 0;

                box-shadow: none;

                background-color: #f8f9fa;
            }


            /* Opened on Mobile */

            .main-category-item.show
            > .child-category-menu {

                display: block;
            }


            /* Mobile Child Link */

            .child-category-link {
                padding: 9px 16px 9px 35px;

                border-top: 1px solid
                    rgba(0, 0, 0, 0.05);
            }


            /* Mobile Arrow */

            .main-category-item.show
            > .main-category-link
            .category-arrow {

                transform: rotate(90deg);
            }

        }



        /* =========================================================
           SMALL SCREEN FOOTER
        ========================================================= */

        @media (max-width: 576px) {

            .footer-contact {
                justify-content: center;
                gap: 8px;
            }


            .contact-item {
                padding: 8px 11px;
                font-size: 12px;
            }


            .contact-icon {
                width: 28px;
                height: 28px;
                font-size: 13px;
            }

        }

    </style>

</head>


<body>


    <!-- =========================================================
         NAVIGATION
    ========================================================= -->

    <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <div class="container px-4 px-lg-5">


            <!-- Brand -->

            <a class="navbar-brand d-flex align-items-center"
               href="{{ route('shop') }}">

                <img src="{{ asset('front-asset/images/blackberry-logo.jpeg') }}"
                     alt="Black-Berry Logo"
                     class="brand-logo">

                <span class="brand-name">
                    Black-Berry !
                </span>

            </a>



            <!-- Mobile Toggle -->

            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>



            <!-- Navbar Content -->

            <div class="collapse navbar-collapse"
                 id="navbarSupportedContent">


                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">


                    <!-- =================================================
                         HOME
                    ================================================= -->

                    <li class="nav-item">

                        <a class="nav-link active"
                           aria-current="page"
                           href="{{ route('shop') }}">

                            Home

                        </a>

                    </li>



                    <!-- =================================================
                         ABOUT
                    ================================================= -->

                    <li class="nav-item">

                        <a class="nav-link"
                           href="{{ route('about') }}">

                            About

                        </a>

                    </li>



                    <!-- =================================================
                         SHOP
                    ================================================= -->

                    <li class="nav-item dropdown">


                        <!-- Shop Button -->

                        <a class="nav-link dropdown-toggle"
                           id="navbarDropdown"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">

                            Shop

                        </a>



                        {{-- =================================================
                             GET MAIN CATEGORIES + CHILDREN
                        ================================================= --}}

                        @php

                            $mainCategories =
                                \App\Models\Category::whereNull('parent_id')
                                    ->with('children')
                                    ->orderBy('name')
                                    ->get();

                        @endphp



                        <!-- Shop Dropdown -->

                        <ul class="dropdown-menu shop-dropdown"
                            aria-labelledby="navbarDropdown">


                            @forelse($mainCategories as $mainCategory)


                                <!-- =================================================
                                     MAIN CATEGORY
                                ================================================= -->

                                <li class="main-category-item">


                                    <a class="main-category-link"
                                       href="{{ route(
                                           'item.categories',
                                           $mainCategory->id
                                       ) }}">


                                        <span>
                                            {{ $mainCategory->name }}
                                        </span>



                                        <!-- Arrow -->

                                        @if($mainCategory->children->count() > 0)

                                            <span class="category-arrow">

                                                <i class="bi bi-chevron-right"></i>

                                            </span>

                                        @endif


                                    </a>



                                    <!-- =================================================
                                         CHILD CATEGORIES
                                    ================================================= -->

                                    @if($mainCategory->children->count() > 0)


                                        <ul class="child-category-menu">


                                            @foreach(
                                                $mainCategory->children
                                                as $childCategory
                                            )


                                                <li>


                                                    <a class="child-category-link"
                                                       href="{{ route(
                                                           'item.categories',
                                                           $childCategory->id
                                                       ) }}">

                                                        {{ $childCategory->name }}

                                                    </a>


                                                </li>


                                            @endforeach


                                        </ul>


                                    @endif


                                </li>


                            @empty


                                <!-- No Category -->

                                <li>

                                    <span class="dropdown-item text-muted">

                                        No categories available.

                                    </span>

                                </li>


                            @endforelse


                        </ul>

                    </li>


                </ul>



                <!-- =========================================================
                     CART
                ========================================================= -->

                <form class="d-flex">

                    <a href="{{ route('item-carts.carts') }}"
                       class="btn btn-outline-dark">

                        <i class="bi-cart-fill me-1"></i>

                        Cart

                        <span class="badge bg-dark text-white ms-1 rounded-pill"
                              id="item-count">

                            0

                        </span>

                    </a>

                </form>



                <!-- =========================================================
                     AUTHENTICATION
                ========================================================= -->

                @guest


                    <!-- Login -->

                    <a href="/login"
                       class="btn mx-3">

                        Login

                    </a>



                    <!-- Register -->

                    <a href="/register"
                       class="btn btn-dark">

                        Register

                    </a>


                @else


                    <!-- User Dropdown -->

                    <div class="dropdown mx-3">


                        <a href="#"
                           class="text-decoration-none text-dark dropdown-toggle"
                           role="button"
                           id="userDropdown"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">

                            {{ Auth::user()->name }}

                        </a>



                        <ul class="dropdown-menu">


                            @if(Auth::user()->role == "User")


                                <!-- Profile -->

                                <li>

                                    <a href="#"
                                       class="dropdown-item">

                                        Profile

                                    </a>

                                </li>


                            @else


                                <!-- Admin Panel -->

                                <li>

                                    <a href="/backend"
                                       class="dropdown-item">

                                        Admin Panel

                                    </a>

                                </li>


                            @endif



                            <!-- Logout -->

                            <li>

                                <a class="dropdown-item"
                                   href="{{ route('logout') }}"
                                   onclick="
                                       event.preventDefault();
                                       document
                                           .getElementById('logout-form')
                                           .submit();
                                   ">

                                    {{ __('Logout') }}

                                </a>


                                <form id="logout-form"
                                      action="{{ route('logout') }}"
                                      method="POST"
                                      class="d-none">

                                    @csrf

                                </form>

                            </li>


                        </ul>

                    </div>


                @endif


            </div>

        </div>

    </nav>



    <!-- =========================================================
         PAGE CONTENT
    ========================================================= -->

    <main class="flex-grow-1">

        @yield('content')

    </main>



    <!-- =========================================================
         FOOTER
    ========================================================= -->

    <footer class="py-5 bg-dark mt-auto">


        <div class="container">

            <div class="row align-items-center">


                <!-- Footer Contact -->

                <div class="col-12 text-end">


                    <div class="footer-contact">


                        <!-- Email -->

                        <a href="mailto:blackberryonlineshop@gmail.com"
                           class="contact-item">

                            <i class="bi bi-envelope-fill contact-icon"></i>

                            <span>
                                blackberryonlineshop@gmail.com
                            </span>

                        </a>



                        <!-- Phone -->

                        <a href="tel:09531110158"
                           class="contact-item">

                            <i class="bi bi-telephone-fill contact-icon"></i>

                            <span>
                                09531110158
                            </span>

                        </a>


                    </div>


                </div>


            </div>

        </div>


    </footer>



    <!-- =========================================================
         JQUERY
    ========================================================= -->

    <script src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous">
    </script>



    <!-- =========================================================
         BOOTSTRAP JS
    ========================================================= -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js">
    </script>



    <!-- =========================================================
         CORE THEME JS
    ========================================================= -->

    <script src="{{ asset('front-asset/js/scripts.js') }}">
    </script>



    <!-- =========================================================
         ADD TO CART JS
    ========================================================= -->

    <script src="{{ asset('front-asset/js/add_to_cart.js') }}">
    </script>



    <!-- =========================================================
         MOBILE NESTED CATEGORY JS
    ========================================================= -->

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                /*
                ================================================
                Mobile Category Handling
                ================================================
                */

                const mainCategoryItems =
                    document.querySelectorAll(
                        '.main-category-item'
                    );


                mainCategoryItems.forEach(
                    function (item) {

                        const link =
                            item.querySelector(
                                ':scope > .main-category-link'
                            );

                        const submenu =
                            item.querySelector(
                                ':scope > .child-category-menu'
                            );


                        /*
                        ----------------------------------------
                        Only process categories that have children
                        ----------------------------------------
                        */

                        if (!submenu || !link) {
                            return;
                        }


                        link.addEventListener(
                            'click',
                            function (event) {

                                /*
                                --------------------------------
                                Desktop
                                --------------------------------
                                */

                                if (window.innerWidth >= 992) {
                                    return;
                                }


                                /*
                                --------------------------------
                                Mobile
                                --------------------------------

                                First click:
                                Open child categories.

                                Second click:
                                Go to Main Category page.
                                --------------------------------
                                */

                                if (!item.classList.contains('show')) {

                                    event.preventDefault();


                                    /*
                                    Close other categories
                                    */

                                    mainCategoryItems.forEach(
                                        function (otherItem) {

                                            if (
                                                otherItem !== item
                                            ) {

                                                otherItem.classList.remove(
                                                    'show'
                                                );

                                            }

                                        }
                                    );


                                    /*
                                    Open current category
                                    */

                                    item.classList.add('show');

                                }

                            }
                        );

                    }
                );


                /*
                ================================================
                Close mobile child menus when Shop dropdown closes
                ================================================
                */

                const shopButton =
                    document.querySelector(
                        '#navbarDropdown'
                    );


                if (shopButton) {

                    shopButton.addEventListener(
                        'click',
                        function () {

                            /*
                            Wait for Bootstrap dropdown state
                            */

                            setTimeout(
                                function () {

                                    /*
                                    If Shop dropdown is closed,
                                    close all child menus.
                                    */

                                    if (
                                        !shopButton.classList.contains(
                                            'show'
                                        )
                                    ) {

                                        mainCategoryItems.forEach(
                                            function (item) {

                                                item.classList.remove(
                                                    'show'
                                                );

                                            }
                                        );

                                    }

                                },
                                200
                            );

                        }
                    );

                }

            }
        );

    </script>



    @yield('script')


</body>

</html>
