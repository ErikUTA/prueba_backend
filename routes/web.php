<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\RH\RHController;
use Illuminate\Support\Facades\Auth;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('user', function () {
    return Auth::user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('developer')->name('developer.')->middleware('role:developer')->group(function() {

    });

    Route::prefix('planning')->name('planning.')->middleware('role:planning')->group(function() {
       
    });
 
    Route::prefix('tester')->name('tester.')->middleware('role:tester')->group(function() {
       
    });

    Route::prefix('rh')->name('RH.')->middleware('role:RH')->group(function() {
        Route::get('/', [RHController::class, 'getUsers']);
        Route::post('/update-user/{userId}', [RHController::class, 'updateUser']);
        Route::post('/update-password/{userId}', [RHController::class, 'updatePassword']);
        Route::post('/update-role', [RHController::class, 'updateRole']);
        Route::delete('/delete-user/{userId}', [RHController::class, 'deleteUser']);
    });
});