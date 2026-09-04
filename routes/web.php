<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/',[App\Http\Controllers\FrontController::class,'shop'])->name('shop');
Route::get('/shop-item/{id}',[App\Http\Controllers\FrontController::class,'shopItem'])->name('shop-item');
Route::get('item-carts',[App\Http\Controllers\FrontController::class,'carts'])->name('item-carts.carts');

Route::post('order-now',[App\Http\Controllers\FrontController::class,'orderNow'])->name('orderNow');

Route::group(['middleware'=>['auth','role:admin'],'prefix'=>'backend','as'=>'backend.'],function(){
    Route::get('/',[App\Http\Controllers\Admin\DashboardController::class,'index'])->name('dashboard');
    Route::resource('items',App\Http\Controllers\Admin\ItemController::class);
    Route::resource('payments',App\Http\Controllers\Admin\PaymentController::class);
    Route::resource('categories',App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('users',App\Http\Controllers\Admin\UserController::class);
    Route::get('orders',[App\Http\Controllers\Admin\OrderController::class,'orders'])->name('orders');
    Route::get('orderAccept',[App\Http\Controllers\Admin\OrderController::class,'orderAccept'])->name('orderAccept');
    Route::get('ordercomplete',[App\Http\Controllers\Admin\OrderController::class,'ordercomplete'])->name('ordercomplete');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
