<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;


Route::get('/', function () {
    return view('welcome');
});
Route::resource('products', ProductController::class);


Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::resource('orders', OrderController::class);
Route::resource('customers', CustomerController::class);
Route::resource('suppliers', SupplierController::class);
