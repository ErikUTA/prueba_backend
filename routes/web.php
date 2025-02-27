<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\AuthController;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
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