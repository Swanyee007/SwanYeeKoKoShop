```blade
@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="card shadow mb-4">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                Edit Item
            </h4>

            <a href="{{ route('backend.items.index') }}"
               class="btn btn-danger">

                Cancel

            </a>

        </div>


        <div class="card-body">

            <form
                action="{{ route('backend.items.update', $item->id) }}"
                method="POST"
                enctype="multipart/form-data"
                id="editItemForm"
            >

                @csrf
                @method('PUT')


                {{-- ===================================================== --}}
                {{-- ERROR MESSAGES --}}
                {{-- ===================================================== --}}

                @if ($errors->any())

                    <div class="alert alert-danger">

                        <strong>
                            There was an error:
                        </strong>

                        <ul class="mb-0 mt-2">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif



                {{-- ===================================================== --}}
                {{-- BASIC ITEM INFORMATION --}}
                {{-- ===================================================== --}}

                <h5 class="mb-3">
                    Item Information
                </h5>


                {{-- Code No --}}
                <div class="mb-3">

                    <label class="form-label">
                        Code No
                    </label>

                    <input
                        type="text"
                        name="code_no"
                        value="{{ old('code_no', $item->code_no) }}"
                        class="form-control @error('code_no') is-invalid @enderror"
                        placeholder="eg. 1234"
                    >

                    @error('code_no')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- Item Name --}}
                <div class="mb-3">

                    <label class="form-label">
                        Item Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $item->name) }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Enter item name"
                    >

                    @error('name')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- ===================================================== --}}
                {{-- MAIN IMAGE --}}
                {{-- ===================================================== --}}

                <div class="mb-3">

                    <label class="form-label">
                        Product Image
                    </label>


                    <ul class="nav nav-tabs"
                        id="myTab"
                        role="tablist">

                        <li class="nav-item"
                            role="presentation">

                            <button
                                class="nav-link active"
                                id="image-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#image-tab-pane"
                                type="button"
                                role="tab"
                            >
                                Current Image
                            </button>

                        </li>


                        <li class="nav-item"
                            role="presentation">

                            <button
                                class="nav-link"
                                id="new_image-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#new_image-tab-pane"
                                type="button"
                                role="tab"
                            >
                                New Image
                            </button>

                        </li>

                    </ul>


                    <div
                        class="tab-content"
                        id="myTabContent"
                    >

                        {{-- Current Image --}}
                        <div
                            class="tab-pane fade show active"
                            id="image-tab-pane"
                            role="tabpanel"
                        >

                            @if($item->image)

                                <img
                                    src="{{ asset($item->image) }}"
                                    class="w-25 my-2"
                                    alt="{{ $item->name }}"
                                >

                            @else

                                <p class="text-muted mt-3">
                                    No image uploaded.
                                </p>

                            @endif


                            <input
                                type="hidden"
                                name="old_image"
                                value="{{ $item->image }}"
                            >

                        </div>


                        {{-- New Image --}}
                        <div
                            class="tab-pane fade"
                            id="new_image-tab-pane"
                            role="tabpanel"
                        >

                            <input
                                type="file"
                                accept="image/*"
                                class="form-control @error('image') is-invalid @enderror"
                                id="image"
                                name="image"
                            >

                            <small class="text-muted">
                                Optional
                            </small>

                            @error('image')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>



                {{-- Price --}}
                <div class="mb-3">

                    <label class="form-label">
                        Price
                    </label>

                    <input
                        type="number"
                        name="price"
                        value="{{ old('price', $item->price) }}"
                        class="form-control @error('price') is-invalid @enderror"
                        step="0.01"
                    >

                    @error('price')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- Discount --}}
                <div class="mb-3">

                    <label class="form-label">
                        Discount (%)
                    </label>

                    <input
                        type="number"
                        name="discount"
                        value="{{ old('discount', $item->discount) }}"
                        class="form-control @error('discount') is-invalid @enderror"
                        step="0.01"
                    >

                    @error('discount')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- In Stock --}}
                <div class="mb-3">

                    <label class="form-label">
                        In Stock
                    </label>

                    <select
                        name="in_stock"
                        class="form-select @error('in_stock') is-invalid @enderror"
                    >

                        <option value="">
                            InStock
                        </option>

                        <option
                            value="1"
                            {{ old('in_stock', $item->in_stock) == 1 ? 'selected' : '' }}
                        >
                            Yes
                        </option>

                        <option
                            value="0"
                            {{ old('in_stock', $item->in_stock) == 0 ? 'selected' : '' }}
                        >
                            No
                        </option>

                    </select>

                    @error('in_stock')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- Description --}}
                <div class="mb-3">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Enter item description"
                    >{{ old('description', $item->description) }}</textarea>

                    @error('description')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- Category --}}
                <div class="mb-3">

                    <label class="form-label">
                        Category
                    </label>

                    <select
                        name="category_id"
                        class="form-select @error('category_id') is-invalid @enderror"
                    >

                        <option value="">
                            Choose Category
                        </option>

                        @foreach ($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}
                            >

                                {{ $category->parent->name ?? 'No Parent' }}
                                →
                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                    @error('category_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- ===================================================== --}}
                {{-- PRODUCT OPTIONS --}}
                {{-- ===================================================== --}}

                <div class="card shadow-sm mb-4">

                    <div class="card-header d-flex justify-content-between align-items-center">

                        <h5 class="mb-0">
                            Product Options
                        </h5>

                        {{-- Same design as Create --}}
                        <button
                            type="button"
                            class="btn btn-primary btn-sm"
                            id="addOptionBtn"
                        >
                            + Add Option
                        </button>

                    </div>


                    <div class="card-body">

                        <div id="optionsContainer">

                            @foreach ($item->options as $optionIndex => $option)

                                <div
                                    class="option-box border rounded p-3 mb-3"
                                    data-option-index="{{ $optionIndex }}"
                                >

                                    <div class="d-flex justify-content-between align-items-center mb-3">

                                        <h6 class="mb-0">
                                            Option {{ $optionIndex + 1 }}
                                        </h6>

                                        {{-- Same design as Create --}}
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm remove-option"
                                        >
                                            Remove
                                        </button>

                                    </div>


                                    {{-- Existing Option ID --}}
                                    <input
                                        type="hidden"
                                        name="options[{{ $optionIndex }}][id]"
                                        value="{{ $option->id }}"
                                    >


                                    {{-- Option Name --}}
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Option Name
                                        </label>

                                        <input
                                            type="text"
                                            name="options[{{ $optionIndex }}][name]"
                                            value="{{ old(
                                                'options.' . $optionIndex . '.name',
                                                $option->name
                                            ) }}"
                                            class="form-control option-name"
                                            placeholder="eg. Size / Color / Type"
                                        >

                                    </div>



                                    {{-- Option Values --}}
                                    <div>

                                        <label class="form-label">
                                            Option Values
                                        </label>


                                        <div class="values-container">

                                            @foreach ($option->values as $valueIndex => $optionValue)

                                                <div
                                                    class="input-group mb-2 value-row"
                                                >

                                                    {{-- Existing Value ID --}}
                                                    <input
                                                        type="hidden"
                                                        name="options[{{ $optionIndex }}][values][{{ $valueIndex }}][id]"
                                                        value="{{ $optionValue->id }}"
                                                    >


                                                    {{-- Value --}}
                                                    <input
                                                        type="text"
                                                        name="options[{{ $optionIndex }}][values][{{ $valueIndex }}][value]"
                                                        value="{{ old(
                                                            'options.' . $optionIndex . '.values.' . $valueIndex . '.value',
                                                            $optionValue->value
                                                        ) }}"
                                                        class="form-control option-value"
                                                        placeholder="eg. S / Black / Whitening"
                                                    >


                                                    {{-- Same design as Create --}}
                                                    <button
                                                        type="button"
                                                        class="btn btn-outline-danger remove-value"
                                                    >
                                                        Remove
                                                    </button>

                                                </div>

                                            @endforeach

                                        </div>


                                        {{-- Same design as Create --}}
                                        <button
                                            type="button"
                                            class="btn btn-outline-primary btn-sm add-value"
                                        >
                                            + Add Value
                                        </button>

                                    </div>

                                </div>

                            @endforeach

                        </div>


                        <div class="text-muted mt-2">

                            <small>

                                Example:

                                <br>

                                Size → S, M, XL

                                <br>

                                Color → Black, White, Blue

                            </small>

                        </div>

                    </div>

                </div>



                {{-- ===================================================== --}}
                {{-- PRODUCT VARIANTS --}}
                {{-- ===================================================== --}}

                <div class="card shadow-sm mb-4">

                    <div class="card-header d-flex justify-content-between align-items-center">

                        <h5 class="mb-0">
                            Product Variants
                        </h5>


                        {{-- Same design as Create --}}
                        <button
                            type="button"
                            class="btn btn-success btn-sm"
                            id="generateVariantsBtn"
                        >
                            Generate Variants
                        </button>

                    </div>


                    <div class="card-body">

                        <div
                            class="alert alert-info mb-3"
                            id="variantHelp"
                        >

                            Add Product Options first,
                            then click
                            <strong>
                                Generate Variants
                            </strong>.

                        </div>


                        <div id="variantsContainer">

                            @foreach ($item->variants as $variantIndex => $variant)

                                <div
                                    class="border rounded p-3 mb-3 variant-box"
                                    data-variant-index="{{ $variantIndex }}"
                                >

                                    {{-- Existing Variant ID --}}
                                    <input
                                        type="hidden"
                                        name="variants[{{ $variantIndex }}][id]"
                                        value="{{ $variant->id }}"
                                    >


                                    {{-- Existing Variant Value References --}}
                                    @foreach ($variant->optionValues as $optionValue)

                                        @php

                                            $foundOptionIndex = null;
                                            $foundValueIndex = null;

                                            foreach ($item->options as $oi => $opt) {

                                                foreach ($opt->values as $vi => $val) {

                                                    if ($val->id == $optionValue->id) {

                                                        $foundOptionIndex = $oi;
                                                        $foundValueIndex = $vi;

                                                        break 2;

                                                    }

                                                }

                                            }

                                        @endphp


                                        @if(
                                            $foundOptionIndex !== null &&
                                            $foundValueIndex !== null
                                        )

                                            <input
                                                type="hidden"
                                                name="variants[{{ $variantIndex }}][values][]"
                                                value="{{ $foundOptionIndex }}:{{ $foundValueIndex }}"
                                            >

                                        @endif

                                    @endforeach



                                    {{-- Variant Name --}}
                                    <div class="mb-3">

                                        <h6 class="mb-0">

                                            @foreach ($variant->optionValues as $valueIndex => $optionValue)

                                                @if($valueIndex > 0)
                                                    /
                                                @endif

                                                {{ $optionValue->value }}

                                            @endforeach

                                        </h6>

                                    </div>



                                    <div class="row">

                                        {{-- SKU --}}
                                        <div class="col-md-3 mb-3">

                                            <label class="form-label">
                                                SKU
                                            </label>

                                            <input
                                                type="text"
                                                name="variants[{{ $variantIndex }}][sku]"
                                                value="{{ old(
                                                    'variants.' . $variantIndex . '.sku',
                                                    $variant->sku
                                                ) }}"
                                                class="form-control"
                                                placeholder="SKU"
                                            >

                                        </div>



                                        {{-- Price --}}
                                        <div class="col-md-3 mb-3">

                                            <label class="form-label">
                                                Price
                                            </label>

                                            <input
                                                type="number"
                                                name="variants[{{ $variantIndex }}][price]"
                                                value="{{ old(
                                                    'variants.' . $variantIndex . '.price',
                                                    $variant->price
                                                ) }}"
                                                class="form-control"
                                                step="0.01"
                                                placeholder="Price"
                                            >

                                        </div>



                                        {{-- Stock --}}
                                        <div class="col-md-2 mb-3">

                                            <label class="form-label">
                                                Stock
                                            </label>

                                            <input
                                                type="number"
                                                name="variants[{{ $variantIndex }}][stock]"
                                                value="{{ old(
                                                    'variants.' . $variantIndex . '.stock',
                                                    $variant->stock
                                                ) }}"
                                                class="form-control"
                                                min="0"
                                                placeholder="Stock"
                                            >

                                        </div>



                                        {{-- Image --}}
                                        <div class="col-md-4 mb-3">

                                            <label class="form-label">
                                                Variant Image
                                            </label>


                                            @if($variant->image)

                                                <div class="mb-2">

                                                    <img
                                                        src="{{ asset($variant->image) }}"
                                                        alt="Variant Image"
                                                        style="width:100px;height:100px;object-fit:cover;"
                                                        class="rounded border"
                                                    >

                                                </div>

                                            @endif


                                            <input
                                                type="file"
                                                name="variants[{{ $variantIndex }}][image]"
                                                class="form-control"
                                                accept="image/*"
                                            >


                                            <small class="text-muted">
                                                Optional
                                            </small>

                                        </div>

                                    </div>


                                    {{-- Remove Variant --}}
                                    <div class="text-end">

                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm remove-variant"
                                        >
                                            Remove
                                        </button>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>



                {{-- ===================================================== --}}
                {{-- BUTTONS --}}
                {{-- ===================================================== --}}

                <div class="mt-3">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Update Item
                    </button>


                    <a
                        href="{{ route('backend.items.index') }}"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>

                </div>


            </form>

        </div>

    </div>

</div>



{{-- ============================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | INDEXES
    |--------------------------------------------------------------------------
    */

    let optionIndex =
        {{ $item->options->count() }};

    let variantIndex =
        {{ $item->variants->count() }};



    const optionsContainer =
        document.getElementById(
            'optionsContainer'
        );


    const variantsContainer =
        document.getElementById(
            'variantsContainer'
        );


    const addOptionButton =
        document.getElementById(
            'addOptionBtn'
        );


    const generateVariantsButton =
        document.getElementById(
            'generateVariantsBtn'
        );


    /*
    |--------------------------------------------------------------------------
    | ADD OPTION
    |--------------------------------------------------------------------------
    */

    addOptionButton.addEventListener(
        'click',
        function () {

            const currentOptionIndex =
                optionIndex;


            const optionHtml = `

                <div
                    class="option-box border rounded p-3 mb-3"
                    data-option-index="${currentOptionIndex}"
                >

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h6 class="mb-0">
                            Option ${currentOptionIndex + 1}
                        </h6>


                        <button
                            type="button"
                            class="btn btn-danger btn-sm remove-option"
                        >
                            Remove
                        </button>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Option Name
                        </label>


                        <input
                            type="text"
                            name="options[${currentOptionIndex}][name]"
                            class="form-control option-name"
                            placeholder="eg. Size / Color / Type"
                        >

                    </div>


                    <div>

                        <label class="form-label">
                            Option Values
                        </label>


                        <div class="values-container">

                            <div class="input-group mb-2 value-row">

                                <input
                                    type="text"
                                    name="options[${currentOptionIndex}][values][0][value]"
                                    class="form-control option-value"
                                    placeholder="eg. S / Black / Whitening"
                                >


                                <button
                                    type="button"
                                    class="btn btn-outline-danger remove-value"
                                >
                                    Remove
                                </button>

                            </div>

                        </div>


                        <button
                            type="button"
                            class="btn btn-outline-primary btn-sm add-value"
                        >
                            + Add Value
                        </button>

                    </div>

                </div>

            `;


            optionsContainer.insertAdjacentHTML(
                'beforeend',
                optionHtml
            );


            optionIndex++;

        }
    );



    /*
    |--------------------------------------------------------------------------
    | OPTION BUTTON EVENTS
    |--------------------------------------------------------------------------
    */

    optionsContainer.addEventListener(
        'click',
        function (event) {


            /*
            |--------------------------------------------------------------
            | Remove Option
            |--------------------------------------------------------------
            */

            if (
                event.target.classList.contains(
                    'remove-option'
                )
            ) {

                const optionBox =
                    event.target.closest(
                        '.option-box'
                    );


                if (optionBox) {

                    optionBox.remove();

                }

            }



            /*
            |--------------------------------------------------------------
            | Add Value
            |--------------------------------------------------------------
            */

            if (
                event.target.classList.contains(
                    'add-value'
                )
            ) {

                const optionBox =
                    event.target.closest(
                        '.option-box'
                    );


                const valuesContainer =
                    optionBox.querySelector(
                        '.values-container'
                    );


                const currentOptionIndex =
                    optionBox.dataset.optionIndex;


                const valueRows =
                    valuesContainer.querySelectorAll(
                        '.value-row'
                    );


                const currentValueIndex =
                    valueRows.length;


                const valueHtml = `

                    <div class="input-group mb-2 value-row">

                        <input
                            type="text"
                            name="options[${currentOptionIndex}][values][${currentValueIndex}][value]"
                            class="form-control option-value"
                            placeholder="Enter option value"
                        >


                        <button
                            type="button"
                            class="btn btn-outline-danger remove-value"
                        >
                            Remove
                        </button>

                    </div>

                `;


                valuesContainer.insertAdjacentHTML(
                    'beforeend',
                    valueHtml
                );

            }



            /*
            |--------------------------------------------------------------
            | Remove Value
            |--------------------------------------------------------------
            */

            if (
                event.target.classList.contains(
                    'remove-value'
                )
            ) {

                const valueRow =
                    event.target.closest(
                        '.value-row'
                    );


                if (valueRow) {

                    valueRow.remove();

                }

            }

        }
    );



    /*
    |--------------------------------------------------------------------------
    | GET OPTIONS
    |--------------------------------------------------------------------------
    */

    function getOptions() {

        const optionBoxes =
            document.querySelectorAll(
                '#optionsContainer .option-box'
            );


        const options = [];


        optionBoxes.forEach(
            function (optionBox) {

                const currentOptionIndex =
                    optionBox.dataset.optionIndex;


                const nameInput =
                    optionBox.querySelector(
                        '.option-name'
                    );


                const valueInputs =
                    optionBox.querySelectorAll(
                        '.option-value'
                    );


                const optionName =
                    nameInput
                        ? nameInput.value.trim()
                        : '';


                const values = [];


                valueInputs.forEach(
                    function (
                        input,
                        valueIndex
                    ) {

                        const value =
                            input.value.trim();


                        if (value !== '') {

                            /*
                            |--------------------------------------------------------------------------
                            | IMPORTANT
                            |
                            | Use the CURRENT DOM value position.
                            |
                            | This matches the submitted PHP array
                            | after values are removed/re-generated.
                            |--------------------------------------------------------------------------
                            */

                            values.push({

                                value:
                                    value,

                                index:
                                    valueIndex

                            });

                        }

                    }
                );


                if (
                    optionName !== '' &&
                    values.length > 0
                ) {

                    options.push({

                        index:
                            currentOptionIndex,

                        name:
                            optionName,

                        values:
                            values

                    });

                }

            }
        );


        return options;

    }



    /*
    |--------------------------------------------------------------------------
    | GENERATE COMBINATIONS
    |--------------------------------------------------------------------------
    */

    function generateCombinations(
        options
    ) {

        if (options.length === 0) {

            return [];

        }


        let combinations = [
            []
        ];


        options.forEach(
            function (option) {

                const newCombinations = [];


                option.values.forEach(
                    function (value) {

                        combinations.forEach(
                            function (combination) {

                                newCombinations.push(

                                    combination.concat([
                                        {
                                            optionIndex:
                                                option.index,

                                            valueIndex:
                                                value.index,

                                            value:
                                                value.value
                                        }
                                    ])

                                );

                            }
                        );

                    }
                );


                combinations =
                    newCombinations;

            }
        );


        return combinations;

    }



    /*
    |--------------------------------------------------------------------------
    | SAVE EXISTING VARIANT DATA
    |--------------------------------------------------------------------------
    */

    function getExistingVariants() {

        const oldVariants = [];


        variantsContainer
            .querySelectorAll(
                '.variant-box'
            )
            .forEach(
                function (card) {

                    const idInput =
                        card.querySelector(
                            'input[name*="[id]"]'
                        );


                    const skuInput =
                        card.querySelector(
                            'input[name*="[sku]"]'
                        );


                    const priceInput =
                        card.querySelector(
                            'input[name*="[price]"]'
                        );


                    const stockInput =
                        card.querySelector(
                            'input[name*="[stock]"]'
                        );


                    const imageInput =
                        card.querySelector(
                            'input[type="file"]'
                        );


                    let key = '';


                    card.querySelectorAll(
                        'input[name*="[values]"]'
                    ).forEach(
                        function (input) {

                            key +=
                                input.value +
                                '|';

                        }
                    );


                    oldVariants.push({

                        id:
                            idInput
                                ? idInput.value
                                : '',

                        sku:
                            skuInput
                                ? skuInput.value
                                : '',

                        price:
                            priceInput
                                ? priceInput.value
                                : '',

                        stock:
                            stockInput
                                ? stockInput.value
                                : '',

                        imageInput:
                            imageInput,

                        key:
                            key

                    });

                }
            );


        return oldVariants;

    }



    /*
    |--------------------------------------------------------------------------
    | GENERATE VARIANTS
    |--------------------------------------------------------------------------
    */

    generateVariantsButton.addEventListener(
        'click',
        function () {

            const options =
                getOptions();


            /*
            |--------------------------------------------------------------
            | No options
            |--------------------------------------------------------------
            */

            if (options.length === 0) {

                variantsContainer.innerHTML = `

                    <div class="alert alert-warning">

                        Please add at least one
                        Product Option and one
                        Option Value.

                    </div>

                `;

                return;

            }



            /*
            |--------------------------------------------------------------
            | Generate combinations
            |--------------------------------------------------------------
            */

            const combinations =
                generateCombinations(
                    options
                );


            /*
            |--------------------------------------------------------------
            | Keep existing variant information
            |--------------------------------------------------------------
            */

            const oldVariants =
                getExistingVariants();


            /*
            |--------------------------------------------------------------
            | Clear old variant cards
            |--------------------------------------------------------------
            */

            variantsContainer.innerHTML = '';


            variantIndex = 0;



            /*
            |--------------------------------------------------------------
            | Create variant cards
            |--------------------------------------------------------------
            */

            combinations.forEach(
                function (
                    combination,
                    currentVariantIndex
                ) {

                    let combinationText = '';

                    let hiddenInputs = '';

                    let key = '';


                    /*
                    | Build combination
                    */

                    combination.forEach(
                        function (valueData) {

                            if (
                                combinationText !== ''
                            ) {

                                combinationText +=
                                    ' / ';

                            }


                            combinationText +=
                                valueData.value;


                            hiddenInputs += `

                                <input
                                    type="hidden"
                                    name="variants[${currentVariantIndex}][values][]"
                                    value="${valueData.optionIndex}:${valueData.valueIndex}"
                                >

                            `;


                            key +=
                                valueData.optionIndex +
                                ':' +
                                valueData.valueIndex +
                                '|';

                        }
                    );



                    /*
                    | Find matching old variant
                    */

                    const oldVariant =
                        oldVariants.find(
                            function (variant) {

                                return (
                                    variant.key ===
                                    key
                                );

                            }
                        );



                    const oldId =
                        oldVariant
                            ? oldVariant.id
                            : '';


                    const oldSku =
                        oldVariant
                            ? oldVariant.sku
                            : '';


                    const oldPrice =
                        oldVariant
                            ? oldVariant.price
                            : '';


                    const oldStock =
                        oldVariant
                            ? oldVariant.stock
                            : '';



                    let idInput = '';


                    if (oldId !== '') {

                        idInput = `

                            <input
                                type="hidden"
                                name="variants[${currentVariantIndex}][id]"
                                value="${oldId}"
                            >

                        `;

                    }



                    const labels =
                        combination.map(
                            function (valueData) {

                                return `

                                    <span class="badge bg-dark me-1">
                                        ${valueData.value}
                                    </span>

                                `;

                            }
                        ).join('');



                    const variantHtml = `

                        <div
                            class="border rounded p-3 mb-3 variant-box"
                            data-variant-index="${currentVariantIndex}"
                        >

                            ${idInput}

                            ${hiddenInputs}


                            <div class="mb-3">

                                <h6 class="mb-0">

                                    ${labels}

                                </h6>

                            </div>


                            <div class="row">

                                {{-- SKU --}}
                                <div class="col-md-3 mb-3">

                                    <label class="form-label">
                                        SKU
                                    </label>

                                    <input
                                        type="text"
                                        name="variants[${currentVariantIndex}][sku]"
                                        value="${oldSku}"
                                        class="form-control"
                                        placeholder="SKU"
                                    >

                                </div>


                                {{-- Price --}}
                                <div class="col-md-3 mb-3">

                                    <label class="form-label">
                                        Price
                                    </label>

                                    <input
                                        type="number"
                                        name="variants[${currentVariantIndex}][price]"
                                        value="${oldPrice}"
                                        class="form-control"
                                        step="0.01"
                                        placeholder="Price"
                                    >

                                </div>


                                {{-- Stock --}}
                                <div class="col-md-2 mb-3">

                                    <label class="form-label">
                                        Stock
                                    </label>

                                    <input
                                        type="number"
                                        name="variants[${currentVariantIndex}][stock]"
                                        value="${oldStock}"
                                        class="form-control"
                                        min="0"
                                        placeholder="Stock"
                                    >

                                </div>


                                {{-- Variant Image --}}
                                <div class="col-md-4 mb-3">

                                    <label class="form-label">
                                        Variant Image
                                    </label>

                                    <input
                                        type="file"
                                        name="variants[${currentVariantIndex}][image]"
                                        class="form-control"
                                        accept="image/*"
                                    >

                                    <small class="text-muted">
                                        Optional
                                    </small>

                                </div>

                            </div>


                            <div class="text-end">

                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm remove-variant"
                                >
                                    Remove
                                </button>

                            </div>

                        </div>

                    `;


                    variantsContainer.insertAdjacentHTML(
                        'beforeend',
                        variantHtml
                    );


                    variantIndex++;

                }
            );



            /*
            |--------------------------------------------------------------
            | No combinations
            |--------------------------------------------------------------
            */

            if (combinations.length === 0) {

                variantsContainer.innerHTML = `

                    <div class="alert alert-warning">

                        No variants could be generated.

                    </div>

                `;

            } else {

                document.getElementById(
                    'variantHelp'
                ).innerHTML = `

                    <strong>
                        ${combinations.length}
                    </strong>

                    variant(s) generated successfully.

                `;

            }

        }
    );



    /*
    |--------------------------------------------------------------------------
    | REMOVE VARIANT
    |--------------------------------------------------------------------------
    */

    variantsContainer.addEventListener(
        'click',
        function (event) {

            if (
                !event.target.classList.contains(
                    'remove-variant'
                )
            ) {

                return;

            }


            const variantBox =
                event.target.closest(
                    '.variant-box'
                );


            if (variantBox) {

                variantBox.remove();

            }

        }
    );

});

</script>

@endsection
```
