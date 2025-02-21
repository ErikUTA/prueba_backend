<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\CategoryController;

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