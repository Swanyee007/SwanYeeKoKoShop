<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

use App\Models\Item;
use App\Models\Category;
use App\Models\ItemOption;
use App\Models\ItemOptionValue;
use App\Models\ItemVariant;
use App\Models\ItemVariantValue;

use App\Http\Requests\ItemRequest;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::orderBy('id', 'DESC')
            ->paginate(5);

        return view(
            'admin.items.index',
            compact('items')
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNotNull('parent_id')
            ->with('parent')
            ->orderBy('name')
            ->get();

        return view(
            'admin.items.create',
            compact('categories')
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {
        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | 1. Create Item
            |--------------------------------------------------------------------------
            */

            $item = Item::create([
                'code_no'     => $request->code_no,
                'name'        => $request->name,
                'price'       => $request->price,
                'discount'    => $request->discount,
                'in_stock'    => $request->in_stock,
                'description' => $request->description,
                'category_id' => $request->category_id,
            ]);


            /*
            |--------------------------------------------------------------------------
            | 2. Upload Item Image
            |--------------------------------------------------------------------------
            |
            | Item image is optional.
            |
            */

            if ($request->hasFile('image')) {

                $file_name =
                    time() . '.' .
                    $request->image->extension();

                $upload = $request->image->move(
                    public_path('images/items/'),
                    $file_name
                );

                if ($upload) {

                    $item->image =
                        'images/items/' . $file_name;

                    $item->save();
                }
            }


            /*
            |--------------------------------------------------------------------------
            | 3. Create Options and Option Values
            |--------------------------------------------------------------------------
            */

            $optionValueIds = [];


            if ($request->has('options')) {

                foreach (
                    $request->options
                    as $optionIndex => $optionData
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Skip empty option
                    |--------------------------------------------------------------------------
                    */

                    if (
                        empty($optionData['name']) ||
                        empty($optionData['values'])
                    ) {
                        continue;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Create Option
                    |--------------------------------------------------------------------------
                    */

                    $option = ItemOption::create([

                        'item_id' =>
                            $item->id,

                        'name' =>
                            $optionData['name'],

                    ]);


                    $optionValueIds[$optionIndex] = [];


                    /*
                    |--------------------------------------------------------------------------
                    | Create Option Values
                    |--------------------------------------------------------------------------
                    */

                    foreach (
                        $optionData['values']
                        as $valueIndex => $value
                    ) {

                        $value = trim($value);


                        if ($value === '') {
                            continue;
                        }


                        $optionValue =
                            ItemOptionValue::create([

                                'item_option_id' =>
                                    $option->id,

                                'value' =>
                                    $value,

                            ]);


                        /*
                        |--------------------------------------------------------------------------
                        | Save Real Database ID
                        |--------------------------------------------------------------------------
                        */

                        $optionValueIds[
                            $optionIndex
                        ][
                            $valueIndex
                        ] =
                            $optionValue->id;
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | 4. Create Variants
            |--------------------------------------------------------------------------
            */

            if ($request->has('variants')) {

                foreach (
                    $request->variants
                    as $variantIndex => $variantData
                ) {


                    /*
                    |--------------------------------------------------------------------------
                    | Create Variant
                    |--------------------------------------------------------------------------
                    */

                    $variant =
                        ItemVariant::create([

                            'item_id' =>
                                $item->id,

                            'sku' =>
                                !empty(
                                    $variantData['sku']
                                )
                                    ? $variantData['sku']
                                    : null,

                            'price' =>
                                isset(
                                    $variantData['price']
                                ) &&
                                $variantData['price'] !== ''
                                    ? $variantData['price']
                                    : null,

                            'stock' =>
                                isset(
                                    $variantData['stock']
                                ) &&
                                $variantData['stock'] !== ''
                                    ? $variantData['stock']
                                    : 0,

                        ]);


                    /*
                    |--------------------------------------------------------------------------
                    | Variant Image
                    |--------------------------------------------------------------------------
                    */

                    if (
                        isset($variantData['image']) &&
                        $variantData['image']
                            instanceof UploadedFile
                    ) {

                        $file_name =
                            time() .
                            '_' .
                            $variantIndex .
                            '.' .
                            $variantData['image']
                                ->extension();


                        $variantData['image']->move(
                            public_path(
                                'images/items/'
                            ),
                            $file_name
                        );


                        $variant->image =
                            'images/items/' .
                            $file_name;


                        $variant->save();
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Create Variant Values
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !empty(
                            $variantData['values']
                        ) &&
                        is_array(
                            $variantData['values']
                        )
                    ) {

                        foreach (
                            $variantData['values']
                            as $valueReference
                        ) {


                            /*
                            |--------------------------------------------------------------------------
                            | Check reference
                            |--------------------------------------------------------------------------
                            */

                            if (
                                !is_string(
                                    $valueReference
                                ) ||
                                !str_contains(
                                    $valueReference,
                                    ':'
                                )
                            ) {
                                continue;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Example: 0:1
                            |--------------------------------------------------------------------------
                            */

                            $parts =
                                explode(
                                    ':',
                                    $valueReference,
                                    2
                                );


                            if (
                                count($parts) !== 2
                            ) {
                                continue;
                            }


                            $optionIndex =
                                $parts[0];

                            $valueIndex =
                                $parts[1];


                            /*
                            |--------------------------------------------------------------------------
                            | Get Real Option Value ID
                            |--------------------------------------------------------------------------
                            */

                            if (
                                !isset(
                                    $optionValueIds[
                                        $optionIndex
                                    ][
                                        $valueIndex
                                    ]
                                )
                            ) {
                                continue;
                            }


                            $optionValueId =
                                $optionValueIds[
                                    $optionIndex
                                ][
                                    $valueIndex
                                ];


                            /*
                            |--------------------------------------------------------------------------
                            | Create Pivot
                            |--------------------------------------------------------------------------
                            */

                            ItemVariantValue::create([

                                'item_variant_id' =>
                                    $variant->id,

                                'item_option_value_id' =>
                                    $optionValueId,

                            ]);
                        }
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Commit
            |--------------------------------------------------------------------------
            */

            DB::commit();


            return redirect()
                ->route(
                    'backend.items.index'
                )
                ->with(
                    'success',
                    'Item, options and variants created successfully'
                );


        } catch (\Throwable $e) {

            DB::rollBack();


            return back()
                ->withInput()
                ->withErrors([

                    'error' =>
                        $e->getMessage(),

                ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        /*
        |--------------------------------------------------------------------------
        | Load Item + Options + Values + Variants
        |--------------------------------------------------------------------------
        */

        $item = Item::with([

            'options.values',

            'variants.optionValues',

        ])->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Load Child Categories
        |--------------------------------------------------------------------------
        */

        $categories = Category::whereNotNull('parent_id')
            ->with('parent')
            ->orderBy('name')
            ->get();


        return view(
            'admin.items.edit',
            compact(
                'item',
                'categories'
            )
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        string $id
    ) {

        DB::beginTransaction();


        try {

            /*
            |--------------------------------------------------------------------------
            | Find Item
            |--------------------------------------------------------------------------
            */

            $item = Item::findOrFail($id);


            /*
            |--------------------------------------------------------------------------
            | Validation
            |--------------------------------------------------------------------------
            */

            $request->validate([

                'code_no' =>
                    'required',

                'name' =>
                    'required',

                'image' =>
                    'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

                'price' =>
                    'required',

                'discount' =>
                    'nullable|numeric|min:0|max:100',

                'in_stock' =>
                    'required|boolean',

                'description' =>
                    'required',

                'category_id' =>
                    'required',

            ]);


            /*
            |--------------------------------------------------------------------------
            | 1. Update Basic Item Information
            |--------------------------------------------------------------------------
            */

            $item->code_no =
                $request->code_no;

            $item->name =
                $request->name;

            $item->price =
                $request->price;

            $item->discount =
                $request->discount;

            $item->in_stock =
                $request->in_stock;

            $item->description =
                $request->description;

            $item->category_id =
                $request->category_id;


            /*
            |--------------------------------------------------------------------------
            | 2. Update Main Image
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('image')) {

                /*
                |--------------------------------------------------------------------------
                | Delete old physical image
                |--------------------------------------------------------------------------
                */

                if (
                    !empty($item->image) &&
                    file_exists(
                        public_path($item->image)
                    )
                ) {

                    unlink(
                        public_path($item->image)
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Upload new image
                |--------------------------------------------------------------------------
                */

                $file_name =
                    time() .
                    '.' .
                    $request->image->extension();


                $request->image->move(
                    public_path('images/items'),
                    $file_name
                );


                $item->image =
                    'images/items/' .
                    $file_name;
            }


            $item->save();


            /*
            |--------------------------------------------------------------------------
            | 3. Existing Options
            |--------------------------------------------------------------------------
            */

            $existingOptionIds =
                $item->options()
                    ->pluck('id')
                    ->toArray();


            /*
            |--------------------------------------------------------------------------
            | Submitted Options
            |--------------------------------------------------------------------------
            */

            $submittedOptionIds = [];


            /*
            |--------------------------------------------------------------------------
            | 4. Update / Create Options
            |--------------------------------------------------------------------------
            */

            if ($request->has('options')) {

                foreach (
                    $request->options
                    as $optionIndex => $optionData
                ) {


                    /*
                    |--------------------------------------------------------------------------
                    | Skip empty option
                    |--------------------------------------------------------------------------
                    */

                    if (
                        empty(
                            $optionData['name']
                        )
                    ) {

                        continue;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Existing Option
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !empty(
                            $optionData['id']
                        )
                    ) {

                        $option =
                            ItemOption::where(
                                'id',
                                $optionData['id']
                            )
                            ->where(
                                'item_id',
                                $item->id
                            )
                            ->first();


                        if (!$option) {
                            continue;
                        }


                        $option->name =
                            $optionData['name'];


                        $option->save();

                    }

                    /*
                    |--------------------------------------------------------------------------
                    | New Option
                    |--------------------------------------------------------------------------
                    */

                    else {

                        $option =
                            ItemOption::create([

                                'item_id' =>
                                    $item->id,

                                'name' =>
                                    $optionData['name'],

                            ]);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Remember submitted option
                    |--------------------------------------------------------------------------
                    */

                    $submittedOptionIds[] =
                        $option->id;


                    /*
                    |--------------------------------------------------------------------------
                    | Existing Values
                    |--------------------------------------------------------------------------
                    */

                    $existingValueIds =
                        $option->values()
                            ->pluck('id')
                            ->toArray();


                    $submittedValueIds = [];


                    /*
                    |--------------------------------------------------------------------------
                    | Values
                    |--------------------------------------------------------------------------
                    */

                    if (
                        isset(
                            $optionData['values']
                        ) &&
                        is_array(
                            $optionData['values']
                        )
                    ) {

                        foreach (
                            $optionData['values']
                            as $valueIndex => $valueData
                        ) {


                            /*
                            |--------------------------------------------------------------------------
                            | Value can be string
                            |--------------------------------------------------------------------------
                            */

                            if (
                                is_string(
                                    $valueData
                                )
                            ) {

                                $valueText =
                                    trim(
                                        $valueData
                                    );

                                $valueId =
                                    null;

                            }

                            /*
                            |--------------------------------------------------------------------------
                            | Value can be array
                            |--------------------------------------------------------------------------
                            */

                            else {

                                $valueText =
                                    trim(
                                        $valueData['value']
                                        ?? ''
                                    );

                                $valueId =
                                    $valueData['id']
                                    ?? null;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Skip empty value
                            |--------------------------------------------------------------------------
                            */

                            if (
                                $valueText === ''
                            ) {
                                continue;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Update Existing Value
                            |--------------------------------------------------------------------------
                            */

                            if ($valueId) {

                                $optionValue =
                                    ItemOptionValue::where(
                                        'id',
                                        $valueId
                                    )
                                    ->where(
                                        'item_option_id',
                                        $option->id
                                    )
                                    ->first();


                                if (!$optionValue) {
                                    continue;
                                }


                                $optionValue->value =
                                    $valueText;


                                $optionValue->save();

                            }

                            /*
                            |--------------------------------------------------------------------------
                            | Create New Value
                            |--------------------------------------------------------------------------
                            */

                            else {

                                $optionValue =
                                    ItemOptionValue::create([

                                        'item_option_id' =>
                                            $option->id,

                                        'value' =>
                                            $valueText,

                                    ]);
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Remember submitted value
                            |--------------------------------------------------------------------------
                            */

                            $submittedValueIds[] =
                                $optionValue->id;
                        }
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Soft Delete Removed Values
                    |--------------------------------------------------------------------------
                    */

                    $valuesToDelete =
                        array_diff(
                            $existingValueIds,
                            $submittedValueIds
                        );


                    if (
                        !empty(
                            $valuesToDelete
                        )
                    ) {

                        ItemOptionValue::whereIn(
                            'id',
                            $valuesToDelete
                        )->delete();
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | 5. Soft Delete Removed Options
            |--------------------------------------------------------------------------
            */

            $optionsToDelete =
                array_diff(
                    $existingOptionIds,
                    $submittedOptionIds
                );


            if (
                !empty(
                    $optionsToDelete
                )
            ) {

                foreach (
                    $optionsToDelete
                    as $optionId
                ) {

                    $option =
                        ItemOption::find(
                            $optionId
                        );


                    if ($option) {

                        /*
                        |--------------------------------------------------------------------------
                        | Soft delete values
                        |--------------------------------------------------------------------------
                        */

                        $option->values()->delete();


                        /*
                        |--------------------------------------------------------------------------
                        | Soft delete option
                        |--------------------------------------------------------------------------
                        */

                        $option->delete();
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | 6. Existing Variants
            |--------------------------------------------------------------------------
            */

            $existingVariantIds =
                $item->variants()
                    ->pluck('id')
                    ->toArray();


            /*
            |--------------------------------------------------------------------------
            | Submitted Variants
            |--------------------------------------------------------------------------
            */

            $submittedVariantIds = [];


            /*
            |--------------------------------------------------------------------------
            | 7. Update / Create Variants
            |--------------------------------------------------------------------------
            */

            if (
                $request->has('variants')
            ) {

                foreach (
                    $request->variants
                    as $variantIndex => $variantData
                ) {


                    /*
                    |--------------------------------------------------------------------------
                    | Existing Variant
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !empty(
                            $variantData['id']
                        )
                    ) {

                        $variant =
                            ItemVariant::where(
                                'id',
                                $variantData['id']
                            )
                            ->where(
                                'item_id',
                                $item->id
                            )
                            ->first();


                        if (!$variant) {
                            continue;
                        }


                        $variant->sku =
                            $variantData['sku']
                            ?? null;

                        $variant->price =
                            $variantData['price']
                            ?? null;

                        $variant->stock =
                            $variantData['stock']
                            ?? 0;


                        $variant->save();

                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Create New Variant
                    |--------------------------------------------------------------------------
                    */

                    else {

                        $variant =
                            ItemVariant::create([

                                'item_id' =>
                                    $item->id,

                                'sku' =>
                                    $variantData['sku']
                                    ?? null,

                                'price' =>
                                    $variantData['price']
                                    ?? null,

                                'stock' =>
                                    $variantData['stock']
                                    ?? 0,

                            ]);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Remember Variant
                    |--------------------------------------------------------------------------
                    */

                    $submittedVariantIds[] =
                        $variant->id;


                    /*
                    |--------------------------------------------------------------------------
                    | Variant Image
                    |--------------------------------------------------------------------------
                    */

                    if (
                        isset(
                            $variantData['image']
                        ) &&
                        $variantData['image']
                            instanceof UploadedFile
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | Delete old variant image
                        |--------------------------------------------------------------------------
                        */

                        if (
                            !empty(
                                $variant->image
                            ) &&
                            file_exists(
                                public_path(
                                    $variant->image
                                )
                            )
                        ) {

                            unlink(
                                public_path(
                                    $variant->image
                                )
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Upload new variant image
                        |--------------------------------------------------------------------------
                        */

                        $file_name =
                            time() .
                            '_' .
                            $variantIndex .
                            '.' .
                            $variantData['image']
                                ->extension();


                        $variantData['image']->move(
                            public_path(
                                'images/items/'
                            ),
                            $file_name
                        );


                        $variant->image =
                            'images/items/' .
                            $file_name;


                        $variant->save();
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | 8. Update Variant Values
                    |--------------------------------------------------------------------------
                    */

                    ItemVariantValue::where(
                        'item_variant_id',
                        $variant->id
                    )->delete();


                    /*
                    |--------------------------------------------------------------------------
                    | Re-create Variant Values
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !empty(
                            $variantData['values']
                        ) &&
                        is_array(
                            $variantData['values']
                        )
                    ) {

                        foreach (
                            $variantData['values']
                            as $valueReference
                        ) {


                            /*
                            |--------------------------------------------------------------------------
                            | Check reference
                            |--------------------------------------------------------------------------
                            */

                            if (
                                !is_string(
                                    $valueReference
                                ) ||
                                !str_contains(
                                    $valueReference,
                                    ':'
                                )
                            ) {
                                continue;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Split reference
                            |--------------------------------------------------------------------------
                            */

                            $parts =
                                explode(
                                    ':',
                                    $valueReference,
                                    2
                                );


                            if (
                                count($parts) !== 2
                            ) {
                                continue;
                            }


                            $optionIndex =
                                $parts[0];

                            $valueIndex =
                                $parts[1];


                            /*
                            |--------------------------------------------------------------------------
                            | Check Option
                            |--------------------------------------------------------------------------
                            */

                            if (
                                !isset(
                                    $request->options[
                                        $optionIndex
                                    ]
                                )
                            ) {
                                continue;
                            }


                            $optionData =
                                $request->options[
                                    $optionIndex
                                ];


                            /*
                            |--------------------------------------------------------------------------
                            | Check Value
                            |--------------------------------------------------------------------------
                            */

                            if (
                                !isset(
                                    $optionData['values']
                                    [$valueIndex]
                                )
                            ) {
                                continue;
                            }


                            $valueData =
                                $optionData['values']
                                [$valueIndex];


                            /*
                            |--------------------------------------------------------------------------
                            | Get Option Value ID
                            |--------------------------------------------------------------------------
                            */

                            if (
                                is_array(
                                    $valueData
                                )
                            ) {

                                $optionValueId =
                                    $valueData['id']
                                    ?? null;

                            } else {

                                $optionValueId =
                                    null;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Skip if no ID
                            |--------------------------------------------------------------------------
                            */

                            if (
                                !$optionValueId
                            ) {
                                continue;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Create Pivot
                            |--------------------------------------------------------------------------
                            */

                            ItemVariantValue::create([

                                'item_variant_id' =>
                                    $variant->id,

                                'item_option_value_id' =>
                                    $optionValueId,

                            ]);
                        }
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | 9. Soft Delete Removed Variants
            |--------------------------------------------------------------------------
            */

            $variantsToDelete =
                array_diff(
                    $existingVariantIds,
                    $submittedVariantIds
                );


            if (
                !empty(
                    $variantsToDelete
                )
            ) {

                foreach (
                    $variantsToDelete
                    as $variantId
                ) {

                    $variant =
                        ItemVariant::find(
                            $variantId
                        );


                    if ($variant) {

                        /*
                        |--------------------------------------------------------------------------
                        | Delete pivot records
                        |--------------------------------------------------------------------------
                        */

                        ItemVariantValue::where(
                            'item_variant_id',
                            $variant->id
                        )->delete();


                        /*
                        |--------------------------------------------------------------------------
                        | Soft delete variant
                        |--------------------------------------------------------------------------
                        */

                        $variant->delete();
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Commit Transaction
            |--------------------------------------------------------------------------
            */

            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | Redirect
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route(
                    'backend.items.index'
                )
                ->with(
                    'success',
                    'Item, options and variants updated successfully'
                );


        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Rollback
            |--------------------------------------------------------------------------
            */

            DB::rollBack();


            return back()
                ->withInput()
                ->withErrors([

                    'error' =>
                        $e->getMessage(),

                ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::find($id);


        if ($item) {

            /*
            |--------------------------------------------------------------------------
            | Soft Delete Item
            |--------------------------------------------------------------------------
            */

            $item->delete();
        }


        return redirect()
            ->route(
                'backend.items.index'
            );
    }
}
