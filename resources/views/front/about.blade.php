
@extends('layouts.front')

@section('content')

<!-- About Hero Section -->
<section class="py-5 bg-dark text-white">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center">
            <h1 class="display-4 fw-bolder">
                About Black-Berry !
            </h1>

            <p class="lead fw-normal text-white-50 mb-0">
                Your Trusted Online Shopping Partner
            </p>
        </div>
    </div>
</section>


<!-- About Content Section -->
<section class="py-5">
    <div class="container px-4 px-lg-5">

        <div class="row gx-4 gx-lg-5 justify-content-center">

            <div class="col-lg-8 text-center">

                <h2 class="fw-bolder mb-4">
                    Welcome to Black-Berry !
                </h2>

                <p class="lead">
                    Black-Berry is your trusted online shopping
                    destination.
                </p>

                <p>
                    We are dedicated to providing quality products
                    and a convenient shopping experience for our
                    customers.
                </p>

                <p>
                    Our online shop allows you to explore products,
                    discover new items, and place your orders easily
                    from the comfort of your home.
                </p>

                <p>
                    Customer satisfaction is our priority.
                    We believe in quality, trust, and excellent
                    service.
                </p>

            </div>

        </div>

    </div>
</section>


<!-- Why Choose Black-Berry -->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5">

        <div class="text-center mb-5">

            <h2 class="fw-bolder">
                Why Choose Black-Berry?
            </h2>

            <p class="lead text-muted">
                We care about your shopping experience.
            </p>

        </div>


        <div class="row gx-4 gx-lg-5">

            <!-- Quality Products -->
            <div class="col-md-4 mb-4">

                <div class="card h-100 border-0 shadow-sm">

                    <div class="card-body text-center p-4">

                        <i class="bi bi-bag-heart-fill fs-1 mb-3"></i>

                        <h4 class="fw-bolder">
                            Quality Products
                        </h4>

                        <p class="text-muted">
                            We aim to provide quality products
                            for our customers.
                        </p>

                    </div>

                </div>

            </div>


            <!-- Easy Shopping -->
            <div class="col-md-4 mb-4">

                <div class="card h-100 border-0 shadow-sm">

                    <div class="card-body text-center p-4">

                        <i class="bi bi-cart-check-fill fs-1 mb-3"></i>

                        <h4 class="fw-bolder">
                            Easy Shopping
                        </h4>

                        <p class="text-muted">
                            Browse products and order online
                            with a simple shopping experience.
                        </p>

                    </div>

                </div>

            </div>


            <!-- Customer Satisfaction -->
            <div class="col-md-4 mb-4">

                <div class="card h-100 border-0 shadow-sm">

                    <div class="card-body text-center p-4">

                        <i class="bi bi-heart-fill fs-1 mb-3"></i>

                        <h4 class="fw-bolder">
                            Customer Satisfaction
                        </h4>

                        <p class="text-muted">
                            Your satisfaction and trust
                            are important to us.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>
</section>


<!-- Contact Section -->
<section class="py-5">
    <div class="container px-4 px-lg-5">

        <div class="text-center">

            <h2 class="fw-bolder mb-4">
                Contact Us
            </h2>

            <p class="lead">
                Have questions? We are happy to help.
            </p>

            <p>
                <i class="bi bi-envelope-fill"></i>
                blackberryonlineshop@gmail.com
            </p>

            <p>
                <i class="bi bi-telephone-fill"></i>
                09531110158
            </p>

            <a href="{{ route('shop') }}"
               class="btn btn-dark mt-3">

                <i class="bi bi-shop"></i>
                Continue Shopping

            </a>

        </div>

    </div>
</section>

@endsection
