<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('user', function () {
    return Auth::user();
});

Route::middleware('auth:sanctum', 'role:user')->group(function () {
    Route::prefix('products')->name('products.')->group(function() {
        Route::get('/', [ProductController::class, 'getProducts'])
            ->name('products');
        
        Route::get('/{productId}', [ProductController::class, 'getProductById'])
            ->name('get_product');
        
        Route::post('/create-product', [ProductController::class, 'createProduct'])
            ->name('create_product');
        
        Route::put('/update-product/{productId}', [ProductController::class, 'updateProduct'])
            ->name('update_product');
        
        Route::delete('/delete-product/{productId}', [ProductController::class, 'deleteProduct'])
            ->name('delete_product');
    });
});