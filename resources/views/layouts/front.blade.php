<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    {{-- ajax set up link connection --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Shop Homepage - Start Bootstrap Template</title>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
        rel="stylesheet" />

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('front-asset/css/styles.css') }}" rel="stylesheet" />

    <style>

        /* ==============================
           Footer Contact
        ============================== */

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

        /* Email and Phone Button */
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

        /* Icon Design */
        .contact-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            color: #ffffff;
            background: linear-gradient(135deg, #6f42c1, #0d6efd);
            font-size: 15px;
        }

        /* Hover Effect */
        .contact-item:hover {
            color: #ffffff;
            background: rgba(13, 110, 253, 0.25);
            border-color: #0d6efd;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.25);
        }

        .contact-item:hover .contact-icon {
            background: linear-gradient(135deg, #0d6efd, #6f42c1);
        }


        /* ==============================
           Shop Nested Dropdown
        ============================== */

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
        }

        .main-category-link:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
        }

        /* Arrow */
        .category-arrow {
            font-size: 12px;
            margin-left: 20px;
        }

        /* Child Category Submenu */
        .child-category-menu {
            display: none;
            position: absolute;
            top: 0;
            left: 100%;
            min-width: 190px;
            padding: 8px 0;
            margin: 0;
            background-color: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            list-style: none;
            z-index: 1000;
        }

        /* Show Child Categories */
        .main-category-item:hover > .child-category-menu {
            display: block;
        }

        /* Child Category Link */
        .child-category-link {
            display: block;
            padding: 8px 16px;
            color: #212529;
            text-decoration: none;
            white-space: nowrap;
        }

        .child-category-link:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
        }


        /* ==============================
           Mobile Responsive
        ============================== */

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

        /* Mobile Navbar */
        @media (max-width: 991.98px) {

            .child-category-menu {
                position: static;
                display: none;
                margin-left: 15px;
                border: none;
                box-shadow: none;
                border-radius: 0;
            }

            .main-category-item:hover > .child-category-menu {
                display: none;
            }

            .main-category-item.show > .child-category-menu {
                display: block;
            }

            .main-category-link {
                cursor: pointer;
            }

        }

    </style>

</head>


<body>

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <div class="container px-4 px-lg-5">

            <a class="navbar-brand" href="{{ route('shop') }}">
                Black-Berry !
            </a>


            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>


            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">


                    <!-- Home -->
                    <li class="nav-item">

                        <a class="nav-link active"
                           aria-current="page"
                           href="{{ route('shop') }}">

                            Home

                        </a>

                    </li>


                    <!-- About -->
                    <li class="nav-item">

                        <a class="nav-link"
                           href="{{ route('about') }}">

                            About

                        </a>

                    </li>


                    <!-- Shop -->
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle"
                           id="navbarDropdown"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">

                            Shop

                        </a>


                        @php

                            $mainCategories = \App\Models\Category::whereNull('parent_id')
                                ->with('children')
                                ->orderBy('name')
                                ->get();

                        @endphp


                        <ul class="dropdown-menu shop-dropdown"
                            aria-labelledby="navbarDropdown">


                            @foreach($mainCategories as $mainCategory)


                                <!-- Main Category -->
                                <li class="main-category-item">


                                    <a class="main-category-link"
                                       href="{{ route('item.categories', $mainCategory->id) }}">

                                        <span>
                                            {{ $mainCategory->name }}
                                        </span>


                                        @if($mainCategory->children->count() > 0)

                                            <span class="category-arrow">
                                                <i class="bi bi-chevron-right"></i>
                                            </span>

                                        @endif

                                    </a>


                                    <!-- Child Categories -->
                                    @if($mainCategory->children->count() > 0)

                                        <ul class="child-category-menu">


                                            @foreach($mainCategory->children as $childCategory)

                                                <li>

                                                    <a class="child-category-link"
                                                       href="{{ route('item.categories', $childCategory->id) }}">

                                                        {{ $childCategory->name }}

                                                    </a>

                                                </li>

                                            @endforeach


                                        </ul>

                                    @endif


                                </li>


                            @endforeach


                        </ul>

                    </li>

                </ul>


                <!-- Cart -->
                <form class="d-flex">

                    <a href="{{ route('item-carts.carts') }}"
                       class="btn btn-outline-dark"
                       type="submit">

                        <i class="bi-cart-fill me-1"></i>

                        Cart

                        <span class="badge bg-dark text-white ms-1 rounded-pill"
                              id="item-count">

                            0

                        </span>

                    </a>

                </form>


                <!-- Authentication -->
                @guest

                    <a href="/login"
                       class="btn mx-3">

                        Login

                    </a>


                    <a href="/register"
                       class="btn btn-dark">

                        Register

                    </a>

                @else


                    <div class="dropdown mx-3">


                        <a href=""
                           class="text-decoration-none text-dark dropdown-toggle"
                           role="button"
                           id="userDropdown"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">

                            {{ Auth::user()->name }}

                        </a>


                        <ul class="dropdown-menu">


                            @if(Auth::user()->role == "User")

                                <li>

                                    <a href=""
                                       class="dropdown-item">

                                        Profile

                                    </a>

                                </li>

                            @else

                                <li>

                                    <a href="/backend"
                                       class="dropdown-item">

                                        Admin Panel

                                    </a>

                                </li>

                            @endif


                            <li>

                                <a class="dropdown-item"
                                   href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">

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


    @yield('content')


    <!-- Footer-->
    <footer class="py-5 bg-dark">

        <div class="col-lg-4 col-md-6 mb-4 mb-md-0 text-end">

            <h5 class="text-uppercase mb-4">
                Contact Us
            </h5>


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

    </footer>


    <!-- Bootstrap core JS-->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NK+N-CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js">
    </script>


    <!-- Core theme JS-->
    <script src="{{ asset('front-asset/js/scripts.js') }}">
    </script>

    <script src="{{ asset('front-asset/js/add_to_cart.js') }}">
    </script>


    @yield('script')


</body>

</html>
