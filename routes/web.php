<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\CategoryController;

Route::namespace('Web')->group(function() {
    Route::get('/products', [ProductController::class, 'getProducts'])
        ->name('web.products');
    
    Route::get('/get-product', [ProductController::class, 'getProductById'])
        ->name('web.get-product');
    
    Route::post('/create-product', [ProductController::class, 'createProduct'])
        ->name('web.create-product');
    
    Route::put('/update-product', [ProductController::class, 'updateProduct'])
        ->name('web.update-product');
    
    Route::delete('/delete-product', [ProductController::class, 'deleteProduct'])
        ->name('web.delete-product');
});