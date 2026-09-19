@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="card shadow mb-4">

        <div class="card-header">
            <h4>Create Item</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('backend.items.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>There was an error:</strong>

                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                {{-- Code No --}}
                <div class="mb-3">

                    <label class="form-label">
                        Code No
                    </label>

                    <input type="text"
                           name="code_no"
                           value="{{ old('code_no') }}"
                           class="form-control @error('code_no') is-invalid @enderror"
                           placeholder="eg. 1234">

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

                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Enter item name">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Image --}}
                <div class="mb-3">

                    <label class="form-label">
                        Image
                    </label>

                    <input type="file"
                           accept="image/*"
                           name="image"
                           class="form-control @error('image') is-invalid @enderror">

                    <small class="text-muted">
                        Optional
                    </small>

                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Price --}}
                <div class="mb-3">

                    <label class="form-label">
                        Price
                    </label>

                    <input type="number"
                           name="price"
                           value="{{ old('price') }}"
                           class="form-control @error('price') is-invalid @enderror"
                           step="0.01">

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

                    <input type="number"
                           name="discount"
                           value="{{ old('discount', 0) }}"
                           class="form-control @error('discount') is-invalid @enderror"
                           step="0.01">

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

                    <select name="in_stock"
                            class="form-select @error('in_stock') is-invalid @enderror">

                        <option value="">
                            InStock
                        </option>

                        <option value="1"
                            {{ old('in_stock') == '1' ? 'selected' : '' }}>
                            Yes
                        </option>

                        <option value="0"
                            {{ old('in_stock') === '0' ? 'selected' : '' }}>
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

                    <textarea name="description"
                              rows="4"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Enter item description">{{ old('description') }}</textarea>

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

                    <select name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror">

                        <option value="">
                            Choose Category
                        </option>

                        @foreach ($categories as $category)

                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>

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

                        <button type="button"
                                class="btn btn-primary btn-sm"
                                id="add-option">

                            + Add Option

                        </button>

                    </div>


                    <div class="card-body">

                        <div id="options-container"></div>

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

                        <button type="button"
                                class="btn btn-success btn-sm"
                                id="generate-variants">

                            Generate Variants

                        </button>

                    </div>


                    <div class="card-body">

                        <div id="variants-container">

                            <div class="alert alert-info mb-0">

                                Add Product Options first,
                                then click
                                <strong>
                                    Generate Variants
                                </strong>.

                            </div>

                        </div>

                    </div>

                </div>



                {{-- Buttons --}}
                <div class="mt-3">

                    <button type="submit"
                            class="btn btn-primary">

                        Save Item

                    </button>


                    <a href="{{ route('backend.items.index') }}"
                       class="btn btn-secondary">

                        Cancel

                    </a>

                </div>


            </form>

        </div>

    </div>

</div>



<script>

document.addEventListener('DOMContentLoaded', function () {

    let optionIndex = 0;


    const optionsContainer =
        document.getElementById('options-container');

    const variantsContainer =
        document.getElementById('variants-container');

    const addOptionButton =
        document.getElementById('add-option');

    const generateVariantsButton =
        document.getElementById('generate-variants');



    /*
    |--------------------------------------------------------------------------
    | ADD OPTION
    |--------------------------------------------------------------------------
    */

    addOptionButton.addEventListener('click', function () {

        addOption();

    });



    function addOption() {

        const currentOptionIndex = optionIndex;


        const optionHtml = `

            <div class="option-box border rounded p-3 mb-3"
                 data-option-index="${currentOptionIndex}">


                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h6 class="mb-0">
                        Option ${currentOptionIndex + 1}
                    </h6>


                    <button type="button"
                            class="btn btn-danger btn-sm remove-option">

                        Remove

                    </button>

                </div>



                <div class="mb-3">

                    <label class="form-label">
                        Option Name
                    </label>


                    <input type="text"
                           name="options[${currentOptionIndex}][name]"
                           class="form-control option-name"
                           placeholder="eg. Size / Color / Type">

                </div>



                <div>

                    <label class="form-label">
                        Option Values
                    </label>


                    <div class="values-container">


                        <div class="input-group mb-2 value-row">


                            <input type="text"
                                   name="options[${currentOptionIndex}][values][]"
                                   class="form-control option-value"
                                   placeholder="eg. S / Black / Whitening">


                            <button type="button"
                                    class="btn btn-outline-danger remove-value">

                                Remove

                            </button>


                        </div>


                    </div>


                    <button type="button"
                            class="btn btn-outline-primary btn-sm add-value">

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



    /*
    |--------------------------------------------------------------------------
    | OPTION BUTTONS
    |--------------------------------------------------------------------------
    */

    optionsContainer.addEventListener(
        'click',
        function (event) {


            /*
            | Remove Option
            */

            if (
                event.target.classList.contains(
                    'remove-option'
                )
            ) {

                const optionBox =
                    event.target.closest('.option-box');


                if (optionBox) {

                    optionBox.remove();

                }

            }



            /*
            | Add Value
            */

            if (
                event.target.classList.contains(
                    'add-value'
                )
            ) {

                const optionBox =
                    event.target.closest('.option-box');


                const valuesContainer =
                    optionBox.querySelector(
                        '.values-container'
                    );


                const currentOptionIndex =
                    optionBox.dataset.optionIndex;


                const valueHtml = `

                    <div class="input-group mb-2 value-row">

                        <input type="text"
                               name="options[${currentOptionIndex}][values][]"
                               class="form-control option-value"
                               placeholder="Enter option value">


                        <button type="button"
                                class="btn btn-outline-danger remove-value">

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
            | Remove Value
            */

            if (
                event.target.classList.contains(
                    'remove-value'
                )
            ) {

                const valueRow =
                    event.target.closest('.value-row');


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
            document.querySelectorAll('.option-box');


        const options = [];


        optionBoxes.forEach(function (optionBox) {


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
                nameInput.value.trim();


            const values = [];


            valueInputs.forEach(
                function (input, valueIndex) {

                    const value =
                        input.value.trim();


                    if (value !== '') {

                        values.push({

                            value: value,

                            index: valueIndex

                        });

                    }

                }
            );


            if (
                optionName !== '' &&
                values.length > 0
            ) {

                options.push({

                    index: currentOptionIndex,

                    name: optionName,

                    values: values

                });

            }

        });


        return options;

    }



    /*
    |--------------------------------------------------------------------------
    | GENERATE COMBINATIONS
    |--------------------------------------------------------------------------
    */

    function generateCombinations(options) {

        if (options.length === 0) {

            return [];

        }


        let combinations = [

            []

        ];


        options.forEach(function (option) {

            const newCombinations = [];


            option.values.forEach(function (value) {


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

            });


            combinations =
                newCombinations;

        });


        return combinations;

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
            | No options
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
            | Prepare options
            */

            const combinations =
                generateCombinations(options);



            /*
            | Clear old variants
            */

            variantsContainer.innerHTML = '';



            /*
            | Create Variant Cards
            */

            combinations.forEach(
                function (combination, variantIndex) {


                    let combinationText = '';

                    let hiddenInputs = '';



                    /*
                    | Build combination text
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



                            /*
                            |--------------------------------------------------------------------------
                            | IMPORTANT
                            |
                            | This hidden input is what sends:
                            |
                            | optionIndex:valueIndex
                            |
                            | Example:
                            |
                            | 0:0
                            | 1:0
                            |
                            |--------------------------------------------------------------------------
                            */

                            hiddenInputs += `

                                <input type="hidden"
                                       name="variants[${variantIndex}][values][]"
                                       value="${valueData.optionIndex}:${valueData.valueIndex}">

                            `;

                        }
                    );



                    /*
                    | Variant HTML
                    */

                    const variantHtml = `

                        <div class="border rounded p-3 mb-3 variant-box">


                            ${hiddenInputs}



                            <div class="mb-3">

                                <h6 class="mb-0">

                                    ${combinationText}

                                </h6>

                            </div>



                            <div class="row">


                                {{-- SKU --}}
                                <div class="col-md-3 mb-3">

                                    <label class="form-label">
                                        SKU
                                    </label>


                                    <input type="text"
                                           name="variants[${variantIndex}][sku]"
                                           class="form-control"
                                           placeholder="SKU">

                                </div>



                                {{-- Price --}}
                                <div class="col-md-3 mb-3">

                                    <label class="form-label">
                                        Price
                                    </label>


                                    <input type="number"
                                           name="variants[${variantIndex}][price]"
                                           class="form-control"
                                           step="0.01"
                                           placeholder="Price">

                                </div>



                                {{-- Stock --}}
                                <div class="col-md-2 mb-3">

                                    <label class="form-label">
                                        Stock
                                    </label>


                                    <input type="number"
                                           name="variants[${variantIndex}][stock]"
                                           class="form-control"
                                           value="0"
                                           min="0">

                                </div>



                                {{-- Variant Image --}}
                                <div class="col-md-4 mb-3">

                                    <label class="form-label">
                                        Variant Image
                                    </label>


                                    <input type="file"
                                           name="variants[${variantIndex}][image]"
                                           class="form-control"
                                           accept="image/*">


                                    <small class="text-muted">

                                        Optional

                                    </small>

                                </div>


                            </div>


                        </div>

                    `;


                    variantsContainer.insertAdjacentHTML(
                        'beforeend',
                        variantHtml
                    );


                }
            );



            /*
            | No combinations
            */

            if (combinations.length === 0) {

                variantsContainer.innerHTML = `

                    <div class="alert alert-warning">

                        No variants could be generated.

                    </div>

                `;

            }

        }
    );

});

</script>

@endsection
