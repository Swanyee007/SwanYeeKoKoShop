@extends('layouts.front')

@section('content')

    <!-- Product Header -->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">

            <div class="text-center text-white">

                <!-- Logo + Shop Name -->
                <div class="d-flex justify-content-center align-items-center">

                    <!-- Black-Berry Logo -->
                    <img
                        src="{{ asset('front-asset/images/blackberry-logo.jpeg') }}"
                        alt="Black-Berry Logo"
                        class="shop-item-logo me-3"
                    >

                    <!-- Shop Name -->
                    <h1 class="display-4 fw-bolder mb-0">
                        Black-Berry !
                    </h1>

                </div>

                <!-- Tagline -->
                <p class="lead fw-normal text-white-50 mb-0">
                    Your Trusted Online Shopping Partner
                </p>

            </div>

        </div>
    </header>


    <!-- Product section-->
    <section class="py-5">

        <div class="container px-4 px-lg-5 my-5">

            <div class="row gx-4 gx-lg-5 align-items-center">

                <div class="col-md-6">

                    <img
                        class="card-img-top mb-5 mb-md-0"
                        src="{{ asset($item->image) }}"
                        alt="{{ $item->name }}"
                    >

                </div>


                <div class="col-md-6">

                    <div class="small mb-1">
                        Code No:{{$item->code_no}}
                    </div>

                    <h1 class="display-5 fw-bolder">
                        {{$item->name}}
                    </h1>

                    <div class="fs-5 mb-5">

                        @if($item->discount>0)

                            <span class="text-decoration-line-through">
                                {{$item->price}}
                            </span>

                            {{$item->price-($item->price*($item->discount/100))}}MMK

                        @else

                            {{$item->price}}MMK

                        @endif

                    </div>

                    <p class="lead">
                        {{$item->description}}
                    </p>

                    <div class="d-flex">

                        <input
                            class="form-control text-center me-3 qty"
                            id="inputQuantity"
                            type="num"
                            value="1"
                            style="max-width: 3rem"
                        />

                        <button
                            class="btn btn-sm btn-dark addToCart"
                            data-id="{{$item->id}}"
                            data-name="{{$item->name}}"
                            data-price="{{$item->price}}"
                            data-discount="{{$item->discount}}"
                            data-image="{{$item->image}}"
                        >
                            Add to Cart
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- Related items section-->
    <section class="py-5 bg-light">

        <div class="container px-4 px-lg-5 mt-5">

            <h2 class="fw-bolder mb-4">
                Related products
            </h2>

            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

                @foreach ($related_items as $item)

                    <div class="col mb-5">

                        <div class="card h-100">

                            <!-- Product image-->
                            <img
                                class="card-img-top"
                                src="{{asset($item->image)}}"
                                alt="..."
                            />

                            <!-- Product details-->
                            <div class="card-body p-4">

                                <div class="text-center">

                                    <!-- Product name-->
                                    <h5 class="fw-bolder">
                                        {{$item->name}}
                                    </h5>

                                    <!-- Product price-->
                                    @if($item->discount>0)

                                        <span class="text-decoration-line-through">
                                            {{$item->price}}
                                        </span>

                                        {{$item->price-($item->price*($item->discount/100))}}MMK

                                    @else

                                        {{$item->price}}MMK

                                    @endif

                                </div>

                            </div>


                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">

                                <div class="text-center row">

                                    <div class="d-flex justify-content-between align-item-center mt-2">

                                        <a
                                            class="btn btn-sm btn-outline-dark"
                                            href="{{route('shop-item',$item->id)}}"
                                        >
                                            Detail
                                        </a>

                                        <input
                                            type="hidden"
                                            name=''
                                            class="qty"
                                            value='1'
                                        >

                                        <button
                                            class="btn btn-sm btn-dark addToCart"
                                            data-id="{{$item->id}}"
                                            data-name="{{$item->name}}"
                                            data-price="{{$item->price}}"
                                            data-discount="{{$item->discount}}"
                                            data-image="{{$item->image}}"
                                        >
                                            Add to Cart
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </section>


    <!-- Shop Item Header CSS -->
    <style>

        .shop-item-logo {
            width: 75px;
            height: 75px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ffffff;
        }


        @media (max-width: 576px) {

            .shop-item-logo {
                width: 60px;
                height: 60px;
            }

        }

    </style>

@endsection
