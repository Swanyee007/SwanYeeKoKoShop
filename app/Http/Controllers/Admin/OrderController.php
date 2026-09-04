<?php

namespace App\Http\Controllers\Admin;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orders()
    {
        $orders=Order::all();
        $voucher_group=$orders->groupBy('voucher_no')->toArray();
        $order_data=[];
        foreach($voucher_group as $voucher)
            {
                $order_id=array_column($voucher,'id');
                $order_data[]=Order::whereIn('id',$order_id)->where('status','Pending')->first();
            }
        return view('admin.orders.index',compact('order_data'));
    }
    public function orderAccept()
    {
        $orders=Order::all();
        $voucher_group=$orders->groupBy('voucher_no')->toArray();
        $order_data=[];
        foreach($voucher_group as $voucher)
            {
                $order_id=array_column($voucher,'id');
                $order_data[]=Order::whereIn('id',$order_id)->where('status','Accept')->first();
            }
        return view('admin.orders.index',compact('order_data'));

    }
    public function orderComplete()
    {
        $orders=Order::all();
        $voucher_group=$orders->groupBy('voucher_no')->toArray();
        $order_data=[];
        foreach($voucher_group as $voucher)
            {
                $order_id=array_column($voucher,'id');
                $order_data[]=Order::whereIn('id',$order_id)->where('status','Complete')->first();
            }
        return view('admin.orders.index',compact('order_data'));
}
}
