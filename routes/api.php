<?php

use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::apiResource('purchases', PurchaseController::class);
    Route::apiResource('suppliers', SupplierController::class);
    Route::apiResource('stocks', StockController::class);
    Route::apiResource('products', ProductController::class);
});