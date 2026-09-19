<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Item;
use App\Models\Payment;
use App\Models\Order;

class FrontController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Shop
    |--------------------------------------------------------------------------
    */

    public function shop()
    {
        $items = Item::orderBy('id', 'DESC')
            ->paginate(8);

        return view(
            'front.shop',
            compact('items')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Shop Item Detail
    |--------------------------------------------------------------------------
    */

    public function shopItem($id)
    {
        /*
        |--------------------------------------------------------------------------
        | Get Item + Options + Values + Variants
        |--------------------------------------------------------------------------
        */

        $item = Item::with([
            'options.values',
            'variants.optionValues',
        ])->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Related Items
        |--------------------------------------------------------------------------
        */

        $category_id = $item->category_id;

        $related_items = Item::where(
                'category_id',
                $category_id
            )
            ->where(
                'id',
                '!=',
                $id
            )
            ->orderBy(
                'id',
                'DESC'
            )
            ->limit(4)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Prepare Variant Data For JavaScript
        |--------------------------------------------------------------------------
        |
        | Blade ထဲမှာ nested @json() / closure မသုံးဘဲ
        | Controller မှာ data ကို ကြိုတင်ပြင်ထားပါတယ်။
        |
        */

        $productVariants = $item->variants
            ->map(function ($variant) {

                return [

                    /*
                    |--------------------------------------------------------------------------
                    | Variant Information
                    |--------------------------------------------------------------------------
                    */

                    'id' => $variant->id,

                    'sku' => $variant->sku,

                    'price' => $variant->price,

                    'stock' => $variant->stock,

                    'image' => $variant->image,


                    /*
                    |--------------------------------------------------------------------------
                    | Variant Option Values
                    |--------------------------------------------------------------------------
                    |
                    | Example:
                    |
                    | Size = M
                    | Color = Black
                    |
                    */

                    'option_values' => $variant->optionValues
                        ->map(function ($optionValue) {

                            return [

                                'id' => $optionValue->id,

                                'option_id' =>
                                    $optionValue->item_option_id,

                                'value' =>
                                    $optionValue->value,

                            ];

                        })
                        ->values()
                        ->toArray(),

                ];

            })
            ->values()
            ->toArray();


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'front.shop-item',
            compact(
                'item',
                'related_items',
                'productVariants'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Cart
    |--------------------------------------------------------------------------
    */

    public function carts()
    {
        $payments = Payment::all();

        return view(
            'front.carts',
            compact('payments')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Order Now
    |--------------------------------------------------------------------------
    */

    public function orderNow(Request $request)
    {
        $dataArray = json_decode(
            $request->orderItems,
            true
        );

        $voucher_no = time();

        $file_name = time();

        $upload = $request->payment_slip->move(
            public_path(
                'images/payment-slip/'
            ),
            $file_name
        );


        foreach ($dataArray as $data) {

            $order = new Order();

            $order->voucher_no =
                $voucher_no;

            $order->total =
                intval($data['qty'])
                *
                (
                    $data['price']
                    -
                    (
                        $data['price']
                        *
                        (
                            $data['discount']
                            /
                            100
                        )
                    )
                );

            $order->qty =
                $data['qty'];

            $order->payment_slip =
                '/images/payment-slip/'
                . $file_name;

            $order->status =
                "Pending";

            $order->note =
                $request->note;

            $order->item_id =
                $data['id'];

            $order->payment_id =
                $request->payment_method;

            $order->user_id =
                Auth::id();

            $order->save();
        }


        return response()->json([
            'success' => true,
            'message' => 'Order Successfully'
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Item Category
    |--------------------------------------------------------------------------
    */

    public function itemcategory($category_id)
    {
        $category = \App\Models\Category::with(
            'children'
        )->findOrFail(
            $category_id
        );


        /*
        |--------------------------------------------------------------------------
        | Parent Category
        |--------------------------------------------------------------------------
        |
        | Example:
        |
        | Men Fashion
        |   ├── Shoes
        |   ├── Shirt
        |   └── Watch
        |
        | Parent category ကိုနှိပ်ရင်
        | child category တွေရဲ့ item တွေကို ပြမယ်။
        |
        */

        if (is_null($category->parent_id)) {

            $childCategoryIds =
                $category->children->pluck('id');


            $items = Item::whereIn(
                    'category_id',
                    $childCategoryIds
                )
                ->orderBy(
                    'id',
                    'DESC'
                )
                ->paginate(8);

        } else {

            /*
            |--------------------------------------------------------------------------
            | Child Category
            |--------------------------------------------------------------------------
            */

            $items = Item::where(
                    'category_id',
                    $category->id
                )
                ->orderBy(
                    'id',
                    'DESC'
                )
                ->paginate(8);
        }


        return view(
            'front.item-category',
            compact('items')
        );
    }
}
