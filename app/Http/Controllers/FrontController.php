<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Payment;
use App\Models\Order;
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
        //echo"$request->data";
        $dataArray=json_decode($request->orderItems,true);
        $voucher_no=time();
        $file_name=time();
        $upload=$request->payment_slip->move(public_path('images/payment-slip/'),$file_name);
        foreach($dataArray as $data)
            {
                $order =new Order();
                $order->voucher_no=$voucher_no;
                $order->total=intval($data['qty'])*($data['price']-($data['price']*($data['dicount']/100)));
                $order->qty=$data['qty'];
                $order->payment_slip='/images/payment-slips/'.$file_name;
                $order->status="Pending";
                $order->note=$request->note;
                $order->item_id=$data['id'];
                $order->payment_id=$request->payment_method;
                $order->user_id=Auth::id();
                $order->save();

            }
            return response()->json(['succrss'=>true, 'message'=>'Order Successfully']);
    }
}
