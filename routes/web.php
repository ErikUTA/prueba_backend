<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'getProducts']);
Route::get('/get-product', [ProductController::class, 'getProductById']);
Route::post('/create-product', [ProductController::class, 'createProduct']);
Route::put('/edit-product', [ProductController::class, 'updateProduct']);
Route::delete('/delete-product', [ProductController::class, 'deleteProduct']);