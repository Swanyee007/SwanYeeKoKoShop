<?php

use Illuminate\Support\Facades\Route;

Route::get('/',[App\Http\Controllers\FrontController::class,'shop'])->name('shop');
Route::get('/shop-item/{id}',[App\Http\Controllers\FrontController::class,'shopItem'])->name('shop-item');
Route::get('item-carts',[App\Http\Controllers\FrontController::class,'carts'])->name('item-carts.carts');
Route::group(['middleware'=>['auth','role:admin'],'prefix'=>'backend','as'=>'backend.'],function(){
    Route::get('/',[App\Http\Controllers\Admin\DashboardController::class,'index'])->name('dashboard');
    Route::resource('items',App\Http\Controllers\Admin\ItemController::class);
    Route::resource('payments',App\Http\Controllers\Admin\PaymentController::class);
    Route::resource('categories',App\Http\Controllers\Admin\CategoryController::class);

});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
