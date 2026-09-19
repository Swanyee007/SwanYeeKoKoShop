@extends('layouts.front')

@section('content')

<!-- ========================================================= -->
<!-- Product Header -->
<!-- ========================================================= -->

<header class="bg-dark py-5">

    <div class="container px-4 px-lg-5 my-5">

        <div class="text-center text-white">

            <!-- Logo + Shop Name -->
            <div class="d-flex justify-content-center align-items-center">

                <img
                    src="{{ asset('front-asset/images/blackberry-logo.jpeg') }}"
                    alt="Black-Berry Logo"
                    class="shop-item-logo me-3"
                >

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


<!-- ========================================================= -->
<!-- Product Section -->
<!-- ========================================================= -->

<section class="py-5">

    <div class="container px-4 px-lg-5 my-5">

        <div class="row gx-5 align-items-start">


            <!-- ================================================= -->
            <!-- Product Photo Album -->
            <!-- ================================================= -->

            <div class="col-md-6 mb-5 mb-md-0">

                <div class="product-gallery">


                    <!-- ========================================= -->
                    <!-- Main Image -->
                    <!-- ========================================= -->

                    <div class="product-image-wrapper">

                        @if($item->image)

                            <img
                                id="productMainImage"
                                class="product-main-image"
                                src="{{ asset($item->image) }}"
                                alt="{{ $item->name }}"
                            >

                        @else

                            <div
                                id="productImagePlaceholder"
                                class="product-image-placeholder"
                            >
                                No Image
                            </div>

                        @endif

                    </div>


                    <!-- ========================================= -->
                    <!-- Photo Album Thumbnails -->
                    <!-- ========================================= -->

                    <div
                        id="productGalleryThumbnails"
                        class="product-gallery-thumbnails"
                    >

                        @if($item->image)

                            <button
                                type="button"
                                class="gallery-thumbnail active"
                                data-gallery-image="{{ asset($item->image) }}"
                            >

                                <img
                                    src="{{ asset($item->image) }}"
                                    alt="{{ $item->name }}"
                                >

                            </button>

                        @endif

                    </div>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- Product Information -->
            <!-- ================================================= -->

            <div class="col-md-6">


                <!-- ============================================= -->
                <!-- Code -->
                <!-- ============================================= -->

                <div class="small mb-2 text-muted">

                    Code No:

                    <strong>
                        {{ $item->code_no }}
                    </strong>

                </div>


                <!-- ============================================= -->
                <!-- Product Name -->
                <!-- ============================================= -->

                <h1 class="display-5 fw-bolder mb-3">
                    {{ $item->name }}
                </h1>


                <!-- ============================================= -->
                <!-- Main Price -->
                <!-- ============================================= -->

                <div
                    id="productPrice"
                    class="product-price mb-4"
                >

                    @if($item->discount > 0)

                        <span class="text-decoration-line-through text-muted me-2">

                            {{ number_format($item->price) }} MMK

                        </span>

                        <strong>

                            {{ number_format(
                                $item->price -
                                ($item->price * ($item->discount / 100))
                            ) }} MMK

                        </strong>

                    @else

                        <strong>
                            {{ number_format($item->price) }} MMK
                        </strong>

                    @endif

                </div>


                <!-- ============================================= -->
                <!-- Description -->
                <!-- ============================================= -->

                <p class="lead mb-4">
                    {{ $item->description }}
                </p>


                <!-- ================================================= -->
                <!-- Product Options -->
                <!-- ================================================= -->

                @if($item->options->count() > 0)

                    <div class="product-options mb-4">

                        @foreach($item->options as $optionIndex => $option)

                            <div
                                class="mb-4 product-option"
                                data-option-id="{{ $option->id }}"
                                data-option-index="{{ $optionIndex }}"
                            >

                                <h6 class="fw-bold mb-2">
                                    {{ $option->name }}
                                </h6>


                                <div class="d-flex flex-wrap gap-2">

                                    @foreach($option->values as $valueIndex => $value)

                                        @php

                                            /*
                                            |--------------------------------------------------------------------------
                                            | Find first variant image for this option value
                                            |--------------------------------------------------------------------------
                                            */

                                            $optionValueVariant =
                                                $item->variants
                                                    ->first(function ($variant) use ($value) {

                                                        return $variant->optionValues
                                                            ->contains('id', $value->id)
                                                            &&
                                                            !empty($variant->image);

                                                    });

                                            $optionButtonImage =
                                                $optionValueVariant
                                                    ? $optionValueVariant->image
                                                    : $item->image;

                                        @endphp


                                        <button
                                            type="button"
                                            class="btn btn-outline-dark option-btn"
                                            data-option-id="{{ $option->id }}"
                                            data-option-index="{{ $optionIndex }}"
                                            data-value-id="{{ $value->id }}"
                                            data-value-index="{{ $valueIndex }}"
                                            data-value="{{ $value->value }}"
                                            data-option-name="{{ $option->name }}"
                                            data-option-image="{{ $optionButtonImage ? asset($optionButtonImage) : '' }}"
                                        >

                                            @if($optionButtonImage)

                                                <span class="option-btn-image-wrapper">

                                                    <img
                                                        src="{{ asset($optionButtonImage) }}"
                                                        alt="{{ $value->value }}"
                                                        class="option-btn-image"
                                                    >

                                                </span>

                                            @endif


                                            <span class="option-btn-text">
                                                {{ $value->value }}
                                            </span>

                                        </button>

                                    @endforeach

                                </div>

                            </div>

                        @endforeach

                    </div>

                @endif


                <!-- ================================================= -->
                <!-- Selected Options -->
                <!-- ================================================= -->

                @if($item->options->count() > 0)

                    <div class="selected-options-box mb-4">

                        <h6 class="fw-bold mb-3">
                            Selected:
                        </h6>

                        <div id="selectedOptions">

                            <span class="text-muted">
                                Please select your options.
                            </span>

                        </div>

                    </div>

                @endif


                <!-- ================================================= -->
                <!-- Variant Information -->
                <!-- ================================================= -->

                <div
                    id="variantInformation"
                    class="variant-information mb-4"
                    style="display:none;"
                >

                    <div class="row g-3">

                        <!-- SKU -->

                        <div class="col-12">

                            <div class="variant-info-item">

                                <span class="variant-label">
                                    SKU:
                                </span>

                                <strong id="variantSku">
                                    -
                                </strong>

                            </div>

                        </div>


                        <!-- Stock -->

                        <div class="col-md-6">

                            <div class="variant-info-item">

                                <span class="variant-label">
                                    Stock:
                                </span>

                                <strong id="variantStock">
                                    -
                                </strong>

                            </div>

                        </div>


                        <!-- Price -->

                        <div class="col-md-6">

                            <div class="variant-info-item">

                                <span class="variant-label">
                                    Price:
                                </span>

                                <strong id="variantPrice">
                                    -
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ================================================= -->
                <!-- No Variant Found -->
                <!-- ================================================= -->

                <div
                    id="variantNotFound"
                    class="alert alert-warning"
                    style="display:none;"
                >

                    This combination is not available.

                </div>


                <!-- ================================================= -->
                <!-- Quantity -->
                <!-- ================================================= -->

                <div class="quantity-section mb-4">

                    <label class="form-label fw-bold">
                        Quantity
                    </label>


                    <div class="quantity-control">

                        <button
                            type="button"
                            class="quantity-btn"
                            id="decreaseQty"
                        >
                            −
                        </button>


                        <input
                            type="number"
                            id="inputQuantity"
                            class="quantity-input"
                            value="1"
                            min="1"
                        >


                        <button
                            type="button"
                            class="quantity-btn"
                            id="increaseQty"
                        >
                            +
                        </button>

                    </div>

                </div>


                <!-- ================================================= -->
                <!-- Add To Cart -->
                <!-- ================================================= -->

                <div class="d-flex align-items-center gap-3">

                    <button
                        type="button"
                        id="addProductToCart"
                        class="btn btn-dark btn-lg"
                        data-id="{{ $item->id }}"
                        data-name="{{ $item->name }}"
                        data-price="{{ $item->price }}"
                        data-discount="{{ $item->discount }}"
                        data-image="{{ $item->image }}"
                    >

                        Add to Cart

                    </button>


                    <span
                        id="selectionMessage"
                        class="text-muted small"
                    >

                        @if($item->options->count() > 0)

                            Please select all options.

                        @else

                            Ready to add to cart.

                        @endif

                    </span>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ========================================================= -->
<!-- Related Items Section -->
<!-- ========================================================= -->

<section class="py-5 bg-light">

    <div class="container px-4 px-lg-5 mt-5">

        <h2 class="fw-bolder mb-4">
            Related products
        </h2>


        <div
            class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center"
        >

            @foreach ($related_items as $relatedItem)

                <div class="col mb-5">

                    <div class="card h-100">


                        <!-- Product Image -->

                        @if($relatedItem->image)

                            <img
                                class="card-img-top"
                                src="{{ asset($relatedItem->image) }}"
                                alt="{{ $relatedItem->name }}"
                            >

                        @else

                            <div class="related-image-placeholder">
                                No Image
                            </div>

                        @endif


                        <!-- Product Details -->

                        <div class="card-body p-4">

                            <div class="text-center">

                                <h5 class="fw-bolder">
                                    {{ $relatedItem->name }}
                                </h5>


                                @if($relatedItem->discount > 0)

                                    <span class="text-decoration-line-through text-muted">

                                        {{ number_format($relatedItem->price) }}

                                    </span>

                                    <br>

                                    <strong>

                                        {{ number_format(
                                            $relatedItem->price -
                                            ($relatedItem->price *
                                            ($relatedItem->discount / 100))
                                        ) }} MMK

                                    </strong>

                                @else

                                    <strong>

                                        {{ number_format($relatedItem->price) }} MMK

                                    </strong>

                                @endif

                            </div>

                        </div>


                        <!-- Product Actions -->

                        <div
                            class="card-footer p-4 pt-0 border-top-0 bg-transparent"
                        >

                            <div
                                class="d-flex justify-content-between align-items-center mt-2"
                            >

                                <!-- Detail -->

                                <a
                                    class="btn btn-sm btn-outline-dark"
                                    href="{{ route('shop-item', $relatedItem->id) }}"
                                >

                                    Detail

                                </a>


                                <!-- Quantity -->

                                <input
                                    type="hidden"
                                    class="qty"
                                    value="1"
                                >


                                <!-- Add To Cart -->

                                <button
                                    type="button"
                                    class="btn btn-sm btn-dark addToCart"
                                    data-id="{{ $relatedItem->id }}"
                                    data-name="{{ $relatedItem->name }}"
                                    data-price="{{ $relatedItem->price }}"
                                    data-discount="{{ $relatedItem->discount }}"
                                    data-image="{{ $relatedItem->image }}"
                                >

                                    Add to Cart

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>


<!-- ========================================================= -->
<!-- JavaScript -->
<!-- ========================================================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | Product Variants
    |--------------------------------------------------------------------------
    */

    const productVariants = @json($productVariants);


    /*
    |--------------------------------------------------------------------------
    | Product Option Count
    |--------------------------------------------------------------------------
    */

    const productOptionCount =
        document.querySelectorAll('.product-option').length;


    /*
    |--------------------------------------------------------------------------
    | Original Product
    |--------------------------------------------------------------------------
    */

    const originalItem = {

        id: {{ $item->id }},

        name: @json($item->name),

        price: Number(@json($item->price)),

        discount: Number(@json($item->discount)),

        image: @json($item->image)

    };


    /*
    |--------------------------------------------------------------------------
    | Selected Options
    |--------------------------------------------------------------------------
    */

    let selectedOptions = {};

    let selectedVariant = null;


    /*
    |--------------------------------------------------------------------------
    | DOM Elements
    |--------------------------------------------------------------------------
    */

    const optionButtons =
        document.querySelectorAll('.option-btn');

    const selectedOptionsContainer =
        document.getElementById('selectedOptions');

    const variantInformation =
        document.getElementById('variantInformation');

    const variantNotFound =
        document.getElementById('variantNotFound');

    const variantSku =
        document.getElementById('variantSku');

    const variantStock =
        document.getElementById('variantStock');

    const variantPrice =
        document.getElementById('variantPrice');

    const productPrice =
        document.getElementById('productPrice');

    const mainImage =
        document.getElementById('productMainImage');

    const imagePlaceholder =
        document.getElementById('productImagePlaceholder');

    const galleryThumbnails =
        document.getElementById('productGalleryThumbnails');

    const quantityInput =
        document.getElementById('inputQuantity');

    const addToCartButton =
        document.getElementById('addProductToCart');

    const selectionMessage =
        document.getElementById('selectionMessage');


    /*
    |--------------------------------------------------------------------------
    | Base Asset URL
    |--------------------------------------------------------------------------
    */

    const assetBase =
        "{{ asset('') }}";


    /*
    |--------------------------------------------------------------------------
    | Format Price
    |--------------------------------------------------------------------------
    */

    function formatPrice(price)
    {

        return Number(price).toLocaleString('en-US');

    }


    /*
    |--------------------------------------------------------------------------
    | Calculate Discount
    |--------------------------------------------------------------------------
    */

    function calculateDiscount(price, discount)
    {

        return price - (
            price * (discount / 100)
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Get Image URL
    |--------------------------------------------------------------------------
    */

    function getImageUrl(image)
    {

        if (!image) {
            return '';
        }


        if (
            image.startsWith('http://') ||
            image.startsWith('https://') ||
            image.startsWith('/')
        ) {

            return image;

        }


        return assetBase + image;

    }


    /*
    |--------------------------------------------------------------------------
    | Get Variant Image
    |--------------------------------------------------------------------------
    */

    function getVariantImage(variant)
    {

        if (!variant) {
            return '';
        }


        return getImageUrl(
            variant.image
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Add Image To Gallery
    |--------------------------------------------------------------------------
    */

    function addGalleryImage(
        image,
        altText = ''
    )
    {

        if (!image) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Images
        |--------------------------------------------------------------------------
        */

        const existing =
            galleryThumbnails.querySelector(
                `[data-gallery-image="${CSS.escape(image)}"]`
            );


        if (existing) {
            return;
        }


        const button =
            document.createElement('button');


        button.type =
            'button';


        button.className =
            'gallery-thumbnail';


        button.dataset.galleryImage =
            image;


        const img =
            document.createElement('img');


        img.src =
            image;


        img.alt =
            altText;


        button.appendChild(img);


        galleryThumbnails.appendChild(
            button
        );


        button.addEventListener(
            'click',
            function () {

                setMainGalleryImage(
                    image
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Set Main Gallery Image
    |--------------------------------------------------------------------------
    */

    function setMainGalleryImage(image)
    {

        if (!image) {
            return;
        }


        if (mainImage) {

            mainImage.src =
                image;

            mainImage.style.display =
                'block';

        }


        if (imagePlaceholder) {

            imagePlaceholder.style.display =
                'none';

        }


        galleryThumbnails
            .querySelectorAll(
                '.gallery-thumbnail'
            )
            .forEach(function (thumbnail) {

                thumbnail.classList.toggle(
                    'active',
                    thumbnail.dataset.galleryImage === image
                );

            });

    }


    /*
    |--------------------------------------------------------------------------
    | Clear Gallery
    |--------------------------------------------------------------------------
    */

    function clearGallery()
    {

        if (!galleryThumbnails) {
            return;
        }


        galleryThumbnails.innerHTML = '';

    }


    /*
    |--------------------------------------------------------------------------
    | Build Gallery
    |--------------------------------------------------------------------------
    */

    function buildGallery(
        variants = []
    )
    {

        if (!galleryThumbnails) {
            return;
        }


        clearGallery();


        /*
        |--------------------------------------------------------------------------
        | Main Item Image
        |--------------------------------------------------------------------------
        */

        const originalImage =
            getImageUrl(
                originalItem.image
            );


        if (originalImage) {

            addGalleryImage(
                originalImage,
                originalItem.name
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Variant Images
        |--------------------------------------------------------------------------
        */

        variants.forEach(function (variant) {

            const image =
                getVariantImage(
                    variant
                );


            if (image) {

                addGalleryImage(
                    image,
                    originalItem.name
                );

            }

        });


        /*
        |--------------------------------------------------------------------------
        | Select First Image
        |--------------------------------------------------------------------------
        */

        const firstThumbnail =
            galleryThumbnails.querySelector(
                '.gallery-thumbnail'
            );


        if (firstThumbnail) {

            setMainGalleryImage(
                firstThumbnail.dataset.galleryImage
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Restore Original Image
    |--------------------------------------------------------------------------
    */

    function restoreOriginalImage()
    {

        const image =
            getImageUrl(
                originalItem.image
            );


        if (image) {

            setMainGalleryImage(
                image
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Find Variants Related To Selected Options
    |--------------------------------------------------------------------------
    */

    function getMatchingGalleryVariants()
    {

        const selectedValueIds =
            Object.values(
                selectedOptions
            ).map(function (option) {

                return Number(
                    option.valueId
                );

            });


        /*
        |--------------------------------------------------------------------------
        | No Selection
        |--------------------------------------------------------------------------
        */

        if (
            selectedValueIds.length === 0
        ) {

            return productVariants;

        }


        /*
        |--------------------------------------------------------------------------
        | Return Variants Containing All Selected Values
        |--------------------------------------------------------------------------
        */

        return productVariants.filter(
            function (variant) {

                const variantValueIds =
                    variant.option_values.map(
                        function (optionValue) {

                            return Number(
                                optionValue.id
                            );

                        }
                    );


                return selectedValueIds.every(
                    function (valueId) {

                        return variantValueIds.includes(
                            valueId
                        );

                    }
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Update Gallery
    |--------------------------------------------------------------------------
    */

    function updateGallery()
    {

        const matchingVariants =
            getMatchingGalleryVariants();


        buildGallery(
            matchingVariants
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Check All Options Selected
    |--------------------------------------------------------------------------
    */

    function allOptionsSelected()
    {

        if (productOptionCount === 0) {

            return true;

        }


        const selectedCount =
            Object.keys(
                selectedOptions
            ).length;


        return (
            productOptionCount ===
            selectedCount
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Update Selected Options
    |--------------------------------------------------------------------------
    */

    function updateSelectedOptions()
    {

        if (!selectedOptionsContainer) {
            return;
        }


        const selectedKeys =
            Object.keys(
                selectedOptions
            );


        if (selectedKeys.length === 0) {

            selectedOptionsContainer.innerHTML = `

                <span class="text-muted">
                    Please select your options.
                </span>

            `;

            return;

        }


        let html = '';


        selectedKeys.forEach(
            function (optionId) {

                const data =
                    selectedOptions[
                        optionId
                    ];


                html += `

                    <div class="selected-option-row">

                        <span class="selected-option-name">
                            ${data.optionName}:
                        </span>

                        <strong>
                            ${data.value}
                        </strong>

                    </div>

                `;

            }
        );


        selectedOptionsContainer.innerHTML =
            html;

    }


    /*
    |--------------------------------------------------------------------------
    | Find Variant
    |--------------------------------------------------------------------------
    */

    function findVariant()
    {

        /*
        |--------------------------------------------------------------------------
        | No Options
        |--------------------------------------------------------------------------
        */

        if (productOptionCount === 0) {

            selectedVariant =
                null;

            showOriginalProduct();

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Not All Options Selected
        |--------------------------------------------------------------------------
        */

        if (!allOptionsSelected()) {

            selectedVariant =
                null;

            showWaitingState();

            return;

        }


        const selectedValueIds =
            Object.values(
                selectedOptions
            ).map(function (option) {

                return Number(
                    option.valueId
                );

            });


        /*
        |--------------------------------------------------------------------------
        | Find Exact Variant
        |--------------------------------------------------------------------------
        */

        selectedVariant =
            productVariants.find(
                function (variant) {

                    const variantValueIds =
                        variant.option_values.map(
                            function (optionValue) {

                                return Number(
                                    optionValue.id
                                );

                            }
                        );


                    if (
                        variantValueIds.length !==
                        selectedValueIds.length
                    ) {

                        return false;

                    }


                    return selectedValueIds.every(
                        function (valueId) {

                            return variantValueIds.includes(
                                valueId
                            );

                        }
                    );

                }
            ) || null;


        if (selectedVariant) {

            showVariant(
                selectedVariant
            );

        } else {

            showVariantNotFound();

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Show Original Product
    |--------------------------------------------------------------------------
    */

    function showOriginalProduct()
    {

        selectedVariant =
            null;


        if (variantInformation) {

            variantInformation.style.display =
                'none';

        }


        if (variantNotFound) {

            variantNotFound.style.display =
                'none';

        }


        if (productPrice) {

            if (
                originalItem.discount > 0
            ) {

                const discountedPrice =
                    calculateDiscount(
                        originalItem.price,
                        originalItem.discount
                    );


                productPrice.innerHTML = `

                    <span class="text-decoration-line-through text-muted me-2">

                        ${formatPrice(
                            originalItem.price
                        )} MMK

                    </span>

                    <strong>

                        ${formatPrice(
                            discountedPrice
                        )} MMK

                    </strong>

                `;

            } else {

                productPrice.innerHTML = `

                    <strong>

                        ${formatPrice(
                            originalItem.price
                        )} MMK

                    </strong>

                `;

            }

        }


        if (variantSku) {

            variantSku.innerText =
                '-';

        }


        if (variantStock) {

            variantStock.innerText =
                '-';

        }


        if (variantPrice) {

            variantPrice.innerText =
                '-';

        }


        restoreOriginalImage();


        updateGallery();


        quantityInput.max =
            999999;


        if (addToCartButton) {

            addToCartButton.disabled =
                false;

        }


        if (selectionMessage) {

            selectionMessage.innerText =
                'Ready to add to cart.';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Show Waiting State
    |--------------------------------------------------------------------------
    */

    function showWaitingState()
    {

        if (variantInformation) {

            variantInformation.style.display =
                'none';

        }


        if (variantNotFound) {

            variantNotFound.style.display =
                'none';

        }


        updateGallery();


        /*
        |--------------------------------------------------------------------------
        | Restore Original Main Image
        |--------------------------------------------------------------------------
        */

        restoreOriginalImage();


        if (addToCartButton) {

            addToCartButton.disabled =
                true;

        }


        if (selectionMessage) {

            selectionMessage.innerText =
                'Please select all options.';

        }


        quantityInput.max =
            1;


        quantityInput.value =
            1;

    }


    /*
    |--------------------------------------------------------------------------
    | Show Variant
    |--------------------------------------------------------------------------
    */

    function showVariant(variant)
    {

        if (variantNotFound) {

            variantNotFound.style.display =
                'none';

        }


        if (variantInformation) {

            variantInformation.style.display =
                'block';

        }


        /*
        |--------------------------------------------------------------------------
        | SKU
        |--------------------------------------------------------------------------
        */

        if (variantSku) {

            variantSku.innerText =
                variant.sku || '-';

        }


        /*
        |--------------------------------------------------------------------------
        | Stock
        |--------------------------------------------------------------------------
        */

        const stock =
            Number(
                variant.stock || 0
            );


        if (variantStock) {

            variantStock.innerText =
                stock;

        }


        /*
        |--------------------------------------------------------------------------
        | Variant Price
        |--------------------------------------------------------------------------
        */

        let price =
            Number(
                variant.price || 0
            );


        if (price <= 0) {

            price =
                originalItem.price;

        }


        if (variantPrice) {

            variantPrice.innerText =
                formatPrice(price) +
                ' MMK';

        }


        /*
        |--------------------------------------------------------------------------
        | Main Product Price
        |--------------------------------------------------------------------------
        */

        if (productPrice) {

            if (
                originalItem.discount > 0
            ) {

                const discountedPrice =
                    calculateDiscount(
                        price,
                        originalItem.discount
                    );


                productPrice.innerHTML = `

                    <span class="text-decoration-line-through text-muted me-2">

                        ${formatPrice(price)} MMK

                    </span>

                    <strong>

                        ${formatPrice(
                            discountedPrice
                        )} MMK

                    </strong>

                `;

            } else {

                productPrice.innerHTML = `

                    <strong>

                        ${formatPrice(price)} MMK

                    </strong>

                `;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Variant Gallery
        |--------------------------------------------------------------------------
        */

        const matchingVariants =
            getMatchingGalleryVariants();


        buildGallery(
            matchingVariants
        );


        /*
        |--------------------------------------------------------------------------
        | Make Variant Image Main
        |--------------------------------------------------------------------------
        */

        const variantImage =
            getVariantImage(
                variant
            );


        if (variantImage) {

            setMainGalleryImage(
                variantImage
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Quantity Limit
        |--------------------------------------------------------------------------
        */

        quantityInput.max =
            stock > 0
                ? stock
                : 1;


        if (stock <= 0) {

            quantityInput.value =
                1;


            if (addToCartButton) {

                addToCartButton.disabled =
                    true;

            }


            if (selectionMessage) {

                selectionMessage.innerText =
                    'This variant is out of stock.';

            }

        } else {

            if (
                Number(
                    quantityInput.value
                ) > stock
            ) {

                quantityInput.value =
                    stock;

            }


            if (
                Number(
                    quantityInput.value
                ) < 1
            ) {

                quantityInput.value =
                    1;

            }


            if (addToCartButton) {

                addToCartButton.disabled =
                    false;

            }


            if (selectionMessage) {

                selectionMessage.innerText =
                    'Variant selected.';

            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Variant Not Found
    |--------------------------------------------------------------------------
    */

    function showVariantNotFound()
    {

        selectedVariant =
            null;


        if (variantInformation) {

            variantInformation.style.display =
                'none';

        }


        if (variantNotFound) {

            variantNotFound.style.display =
                'block';

        }


        updateGallery();


        restoreOriginalImage();


        if (addToCartButton) {

            addToCartButton.disabled =
                true;

        }


        if (selectionMessage) {

            selectionMessage.innerText =
                'This combination is unavailable.';

        }


        quantityInput.max =
            1;


        quantityInput.value =
            1;

    }


    /*
    |--------------------------------------------------------------------------
    | Option Button Click
    |--------------------------------------------------------------------------
    */

    optionButtons.forEach(
        function (button) {

            button.addEventListener(
                'click',
                function () {

                    const optionId =
                        this.dataset.optionId;


                    const valueId =
                        this.dataset.valueId;


                    const value =
                        this.dataset.value;


                    const option =
                        this.closest(
                            '.product-option'
                        );


                    const optionName =
                        this.dataset.optionName ||
                        option.querySelector('h6')
                            .innerText
                            .trim();


                    /*
                    |--------------------------------------------------------------------------
                    | Remove Active From Same Option
                    |--------------------------------------------------------------------------
                    */

                    option
                        .querySelectorAll(
                            '.option-btn'
                        )
                        .forEach(
                            function (btn) {

                                btn.classList.remove(
                                    'active'
                                );

                            }
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Activate Current Button
                    |--------------------------------------------------------------------------
                    */

                    this.classList.add(
                        'active'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Save Selection
                    |--------------------------------------------------------------------------
                    */

                    selectedOptions[
                        optionId
                    ] = {

                        optionId:
                            optionId,

                        optionName:
                            optionName,

                        valueId:
                            valueId,

                        value:
                            value

                    };


                    /*
                    |--------------------------------------------------------------------------
                    | Update Selected Options
                    |--------------------------------------------------------------------------
                    */

                    updateSelectedOptions();


                    /*
                    |--------------------------------------------------------------------------
                    | Update Photo Album
                    |--------------------------------------------------------------------------
                    */

                    updateGallery();


                    /*
                    |--------------------------------------------------------------------------
                    | Find Variant
                    |--------------------------------------------------------------------------
                    */

                    findVariant();

                }
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Existing Gallery Thumbnail Click
    |--------------------------------------------------------------------------
    */

    if (galleryThumbnails) {

        galleryThumbnails
            .querySelectorAll(
                '.gallery-thumbnail'
            )
            .forEach(
                function (thumbnail) {

                    thumbnail.addEventListener(
                        'click',
                        function () {

                            setMainGalleryImage(
                                this.dataset.galleryImage
                            );

                        }
                    );

                }
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Quantity Decrease
    |--------------------------------------------------------------------------
    */

    const decreaseQty =
        document.getElementById(
            'decreaseQty'
        );


    if (decreaseQty) {

        decreaseQty.addEventListener(
            'click',
            function () {

                let quantity =
                    Number(
                        quantityInput.value
                    );


                if (
                    !quantity ||
                    quantity < 1
                ) {

                    quantity =
                        1;

                }


                if (quantity > 1) {

                    quantity--;

                }


                quantityInput.value =
                    quantity;

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Quantity Increase
    |--------------------------------------------------------------------------
    */

    const increaseQty =
        document.getElementById(
            'increaseQty'
        );


    if (increaseQty) {

        increaseQty.addEventListener(
            'click',
            function () {

                let quantity =
                    Number(
                        quantityInput.value
                    );


                if (
                    !quantity ||
                    quantity < 1
                ) {

                    quantity =
                        1;

                }


                const max =
                    Number(
                        quantityInput.max
                    );


                /*
                |--------------------------------------------------------------------------
                | Variant Product
                |--------------------------------------------------------------------------
                */

                if (
                    productOptionCount > 0 &&
                    selectedVariant
                ) {

                    if (
                        max > 0 &&
                        quantity < max
                    ) {

                        quantity++;

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | Product Without Options
                |--------------------------------------------------------------------------
                */

                else if (
                    productOptionCount === 0
                ) {

                    quantity++;

                }


                quantityInput.value =
                    quantity;

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Manual Quantity Input
    |--------------------------------------------------------------------------
    */

    quantityInput.addEventListener(
        'input',
        function () {

            let quantity =
                Number(
                    this.value
                );


            if (
                !quantity ||
                quantity < 1
            ) {

                quantity =
                    1;

            }


            /*
            |--------------------------------------------------------------------------
            | Variant Product
            |--------------------------------------------------------------------------
            */

            if (
                productOptionCount > 0 &&
                selectedVariant
            ) {

                const max =
                    Number(
                        this.max
                    );


                if (
                    max > 0 &&
                    quantity > max
                ) {

                    quantity =
                        max;

                }

            }


            this.value =
                quantity;

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Add To Cart - Product Detail
    |--------------------------------------------------------------------------
    */

    if (addToCartButton) {

        addToCartButton.addEventListener(
            'click',
            function () {


                /*
                |--------------------------------------------------------------------------
                | Product With Options
                |--------------------------------------------------------------------------
                */

                if (
                    productOptionCount > 0
                ) {

                    if (!selectedVariant) {

                        alert(
                            'Please select a variant.'
                        );

                        return;

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | Quantity
                |--------------------------------------------------------------------------
                */

                const quantity =
                    Number(
                        quantityInput.value
                    );


                if (quantity < 1) {

                    alert(
                        'Please select a valid quantity.'
                    );

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Product With Variant
                |--------------------------------------------------------------------------
                */

                if (
                    productOptionCount > 0
                ) {

                    const stock =
                        Number(
                            selectedVariant.stock ||
                            0
                        );


                    if (quantity > stock) {

                        alert(
                            'Quantity cannot exceed available stock.'
                        );

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Variant Price
                    |--------------------------------------------------------------------------
                    */

                    let price =
                        Number(
                            selectedVariant.price ||
                            0
                        );


                    if (price <= 0) {

                        price =
                            originalItem.price;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Selected Options
                    |--------------------------------------------------------------------------
                    */

                    const selectedOptionData =
                        Object.values(
                            selectedOptions
                        ).map(
                            function (option) {

                                return {

                                    option_id:
                                        option.optionId,

                                    option_name:
                                        option.optionName,

                                    value_id:
                                        option.valueId,

                                    value:
                                        option.value

                                };

                            }
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Cart Data - Variant Product
                    |--------------------------------------------------------------------------
                    */

                    const cartData = {

                        id:
                            originalItem.id,

                        name:
                            originalItem.name,

                        price:
                            price,

                        discount:
                            originalItem.discount,

                        image:
                            selectedVariant.image ||
                            originalItem.image,

                        qty:
                            quantity,

                        variant_id:
                            selectedVariant.id,

                        variant_sku:
                            selectedVariant.sku,

                        variant_stock:
                            selectedVariant.stock,

                        selected_options:
                            selectedOptionData

                    };


                    /*
                    |--------------------------------------------------------------------------
                    | Main Cart Function
                    |--------------------------------------------------------------------------
                    */

                    if (
                        typeof window.addToCart ===
                        'function'
                    ) {

                        window.addToCart(
                            cartData
                        );

                    } else {

                        /*
                        |--------------------------------------------------------------------------
                        | Fallback
                        |--------------------------------------------------------------------------
                        */

                        let cart =
                            JSON.parse(
                                localStorage.getItem(
                                    'shops'
                                )
                            ) || [];


                        const existingIndex =
                            cart.findIndex(
                                function (cartItem) {

                                    return (

                                        Number(
                                            cartItem.id
                                        ) ===
                                        Number(
                                            cartData.id
                                        )

                                        &&

                                        Number(
                                            cartItem.variant_id
                                        ) ===
                                        Number(
                                            cartData.variant_id
                                        )

                                    );

                                }
                            );


                        if (
                            existingIndex !== -1
                        ) {

                            cart[
                                existingIndex
                            ].qty =

                                Number(
                                    cart[
                                        existingIndex
                                    ].qty || 0
                                )

                                +

                                quantity;

                        } else {

                            cart.push(
                                cartData
                            );

                        }


                        localStorage.setItem(
                            'shops',
                            JSON.stringify(cart)
                        );


                        if (
                            typeof window.updateCartCount ===
                            'function'
                        ) {

                            window.updateCartCount();

                        }


                        alert(
                            'Product added to cart.'
                        );

                    }


                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Product Without Options
                |--------------------------------------------------------------------------
                */

                const cartData = {

                    id:
                        originalItem.id,

                    name:
                        originalItem.name,

                    price:
                        originalItem.price,

                    discount:
                        originalItem.discount,

                    image:
                        originalItem.image,

                    qty:
                        quantity,

                    variant_id:
                        null,

                    variant_sku:
                        null,

                    variant_stock:
                        null,

                    selected_options:
                        []

                };


                /*
                |--------------------------------------------------------------------------
                | Main Cart Function
                |--------------------------------------------------------------------------
                */

                if (
                    typeof window.addToCart ===
                    'function'
                ) {

                    window.addToCart(
                        cartData
                    );

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Fallback
                    |--------------------------------------------------------------------------
                    */

                    let cart =
                        JSON.parse(
                            localStorage.getItem(
                                'shops'
                            )
                        ) || [];


                    const existingIndex =
                        cart.findIndex(
                            function (cartItem) {

                                return (

                                    Number(
                                        cartItem.id
                                    ) ===
                                    Number(
                                        cartData.id
                                    )

                                    &&

                                    !cartItem.variant_id

                                );

                            }
                        );


                    if (
                        existingIndex !== -1
                    ) {

                        cart[
                            existingIndex
                        ].qty =

                            Number(
                                cart[
                                    existingIndex
                                ].qty || 0
                            )

                            +

                            quantity;

                    } else {

                        cart.push(
                            cartData
                        );

                    }


                    localStorage.setItem(
                        'shops',
                        JSON.stringify(cart)
                    );


                    if (
                        typeof window.updateCartCount ===
                        'function'
                    ) {

                        window.updateCartCount();

                    }


                    alert(
                        'Product added to cart.'
                    );

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Initial Gallery
    |--------------------------------------------------------------------------
    */

    buildGallery(
        productVariants
    );


    /*
    |--------------------------------------------------------------------------
    | Initialize Product
    |--------------------------------------------------------------------------
    */

    if (
        productOptionCount === 0
    ) {

        showOriginalProduct();

    } else {

        showWaitingState();

    }

});

</script>


<!-- ========================================================= -->
<!-- CSS -->
<!-- ========================================================= -->

<style>


    /* ========================================================= */
    /* Shop Item Logo */
    /* ========================================================= */

    .shop-item-logo {

        width: 75px;

        height: 75px;

        object-fit: cover;

        border-radius: 50%;

        border: 2px solid #ffffff;

    }


    /* ========================================================= */
    /* Product Gallery */
    /* ========================================================= */

    .product-gallery {

        width: 100%;

    }


    /* ========================================================= */
    /* Product Main Image Wrapper */
    /* ========================================================= */

    .product-image-wrapper {

        width: 100%;

        min-height: 450px;

        display: flex;

        justify-content: center;

        align-items: center;

        background: #f8f9fa;

        border-radius: 12px;

        overflow: hidden;

        border: 1px solid #eeeeee;

    }


    /* ========================================================= */
    /* Product Main Image */
    /* ========================================================= */

    .product-main-image {

        width: 100%;

        max-height: 550px;

        object-fit: contain;

        display: block;

        cursor: zoom-in;

        transition: transform .25s ease;

    }


    .product-main-image:hover {

        transform: scale(1.02);

    }


    /* ========================================================= */
    /* Product Image Placeholder */
    /* ========================================================= */

    .product-image-placeholder {

        width: 100%;

        min-height: 450px;

        display: flex;

        justify-content: center;

        align-items: center;

        color: #999;

        font-size: 20px;

    }


    /* ========================================================= */
    /* Photo Album Thumbnails */
    /* ========================================================= */

    .product-gallery-thumbnails {

        display: flex;

        flex-wrap: wrap;

        gap: 10px;

        margin-top: 15px;

        padding: 2px;

    }


    .gallery-thumbnail {

        width: 78px;

        height: 78px;

        padding: 3px;

        border: 2px solid #dee2e6;

        border-radius: 8px;

        background: #ffffff;

        overflow: hidden;

        cursor: pointer;

        transition: all .2s ease;

    }


    .gallery-thumbnail:hover {

        border-color: #212529;

        transform: translateY(-2px);

    }


    .gallery-thumbnail.active {

        border-color: #212529;

        box-shadow:
            0 0 0 2px rgba(
                33,
                37,
                41,
                .12
            );

    }


    .gallery-thumbnail img {

        width: 100%;

        height: 100%;

        object-fit: cover;

        display: block;

        border-radius: 5px;

    }


    /* ========================================================= */
    /* Product Price */
    /* ========================================================= */

    .product-price {

        font-size: 22px;

    }


    /* ========================================================= */
    /* Option Buttons */
    /* ========================================================= */

    .option-btn {

        min-width: 95px;

        min-height: 78px;

        padding: 5px 8px;

        border-radius: 8px;

        display: inline-flex;

        flex-direction: column;

        justify-content: center;

        align-items: center;

        gap: 4px;

        transition: all .2s ease;

        overflow: hidden;

    }


    .option-btn:hover {

        transform: translateY(-2px);

    }


    .option-btn.active {

        background-color: #212529;

        color: #ffffff;

        border-color: #212529;

    }


    /* ========================================================= */
    /* Option Button Image */
    /* ========================================================= */

    .option-btn-image-wrapper {

        width: 42px;

        height: 42px;

        display: block;

        overflow: hidden;

        border-radius: 6px;

        background: #f8f9fa;

        border: 1px solid #dee2e6;

    }


    .option-btn-image {

        width: 100%;

        height: 100%;

        object-fit: cover;

        display: block;

    }


    /* ========================================================= */
    /* Option Button Text */
    /* ========================================================= */

    .option-btn-text {

        font-size: 13px;

        line-height: 1.2;

        white-space: nowrap;

    }


    /* ========================================================= */
    /* Selected Options */
    /* ========================================================= */

    .selected-options-box {

        padding: 16px;

        background: #f8f9fa;

        border-radius: 8px;

        border: 1px solid #dee2e6;

    }


    .selected-option-row {

        display: flex;

        gap: 8px;

        margin-bottom: 6px;

    }


    .selected-option-row:last-child {

        margin-bottom: 0;

    }


    .selected-option-name {

        min-width: 70px;

    }


    /* ========================================================= */
    /* Variant Information */
    /* ========================================================= */

    .variant-information {

        padding: 16px;

        border: 1px solid #dee2e6;

        border-radius: 8px;

        background: #ffffff;

    }


    .variant-info-item {

        padding: 8px 0;

    }


    .variant-label {

        margin-right: 5px;

        color: #6c757d;

    }


    /* ========================================================= */
    /* Quantity */
    /* ========================================================= */

    .quantity-control {

        display: flex;

        align-items: center;

        width: fit-content;

        border: 1px solid #ced4da;

        border-radius: 6px;

        overflow: hidden;

    }


    .quantity-btn {

        width: 42px;

        height: 42px;

        border: none;

        background: #f8f9fa;

        font-size: 22px;

        cursor: pointer;

    }


    .quantity-btn:hover {

        background: #e9ecef;

    }


    .quantity-input {

        width: 55px;

        height: 42px;

        border: none;

        border-left: 1px solid #ced4da;

        border-right: 1px solid #ced4da;

        text-align: center;

        outline: none;

    }


    .quantity-input::-webkit-outer-spin-button,

    .quantity-input::-webkit-inner-spin-button {

        -webkit-appearance: none;

        margin: 0;

    }


    .quantity-input[type=number] {

        -moz-appearance: textfield;

    }


    /* ========================================================= */
    /* Related Product Image */
    /* ========================================================= */

    .related-image-placeholder {

        width: 100%;

        height: 220px;

        display: flex;

        justify-content: center;

        align-items: center;

        background: #f8f9fa;

        color: #999;

    }


    /* ========================================================= */
    /* Mobile */
    /* ========================================================= */

    @media (max-width: 576px) {


        .shop-item-logo {

            width: 60px;

            height: 60px;

        }


        .product-image-wrapper {

            min-height: 300px;

        }


        .product-main-image {

            max-height: 350px;

        }


        .product-gallery-thumbnails {

            gap: 7px;

        }


        .gallery-thumbnail {

            width: 64px;

            height: 64px;

        }


        .selected-option-row {

            flex-wrap: wrap;

        }


        .option-btn {

            min-width: 75px;

            min-height: 70px;

        }


        .option-btn-image-wrapper {

            width: 36px;

            height: 36px;

        }


        .option-btn-text {

            font-size: 12px;

        }

    }

</style>

@endsection
