<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
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
    Route::middleware('auth:sanctum')->apiResource('purchases', PurchaseController::class);
    
    Route::middleware('auth:sanctum')->apiResource('suppliers', SupplierController::class)->only(['store', 'update']);
    Route::apiResource('suppliers', SupplierController::class)->except(['store', 'update']);
    
    Route::middleware('auth:sanctum')->apiResource('addresses', AddressController::class)->only('update');
    Route::apiResource('addresses', AddressController::class)->except('update');

    Route::middleware('auth:sanctum')->apiResource('users', UserController::class)->only('update');
    Route::apiResource('users', UserController::class)->except('update');

    Route::middleware('auth:sanctum')->apiResource('stocks', StockController::class)->only(['store', 'update']);
    Route::apiResource('stocks', StockController::class)->except(['store', 'update']);

    Route::middleware('auth:sanctum')->apiResource('products', ProductController::class)->only(['store', 'update']);
    Route::apiResource('products', ProductController::class)->except(['store', 'update']);

    Route::middleware('auth:sanctum')->apiResource('images', ImageController::class)->only(['store', 'update']);
    Route::apiResource('images', ImageController::class)->except(['store', 'update']);

    Route::middleware('auth:sanctum')->apiResource('categories', CategoryController::class)->only(['store', 'update']);
    Route::apiResource('categories', CategoryController::class)->except(['store', 'update']);

    Route::middleware('auth:sanctum')->apiResource('carts', ShoppingCartController::class)->only(['store', 'update']);
    Route::apiResource('carts', ShoppingCartController::class)->except(['store', 'update']);

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout')->middleware('auth:sanctum');
});
