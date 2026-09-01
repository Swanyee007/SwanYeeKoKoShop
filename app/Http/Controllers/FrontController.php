<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Payment;
class FrontController extends Controller
{
    public function shop()
    {
        $items=Item::orderBy('id','DESC')->paginate(8);
        //var_dump($items);
        return view('front.shop',compact('items'));
    }
    public function shopItem($id)
    {
        $item=Item::findOrFail($id);
        return view ('front.shop-item',compact('item'));
    }
    public function carts()
    {
        $payments=Payment::all();
        return view('front.carts',compact('payments'));
    }
    public function orderNow(Request $request)
    {
        echo"$request->data";
    }
}
