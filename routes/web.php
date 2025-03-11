<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\RH\RHController;
use Illuminate\Support\Facades\Auth;


Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('user', function () {
    return Auth::user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/update-user/{userId}', [UserController::class, 'updateUser']);
    Route::get('/get-projects', [ProjectController::class, 'getProjects']);
    Route::get('/get-tasks', [TaskController::class, 'getTasks']);

    Route::prefix('developer')->name('developer.')->middleware('role:developer')->group(function() {

    });

    Route::prefix('planning')->name('planning.')->middleware('role:planning')->group(function() {
        Route::get('/create-task', [TaskController::class, 'createTask']);
        Route::get('/update-task/{projectId}', [TaskController::class, 'updateTask']);
        Route::get('/delete-task/{projectId}', [TaskController::class, 'deleteTask']);
        Route::get('/create-project', [ProjectController::class, 'createProject']);
        Route::get('/update-project/{projectId}', [ProjectController::class, 'updateProject']);
        Route::get('/assign-users-project/{projectId}', [ProjectController::class, 'assignUserToProject']);
        Route::get('/delete-project/{projectId}', [ProjectController::class, 'deleteProject']);
    });
 
    Route::prefix('tester')->name('tester.')->middleware('role:tester')->group(function() {
       
    });

    Route::prefix('rh')->name('RH.')->middleware('role:RH')->group(function() {
        Route::get('/get-users', [ProjectController::class, 'getUsers']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/update-password/{userId}', [UserController::class, 'updatePassword']);
        Route::post('/update-role/{userId}', [UserController::class, 'updateRole']);
        Route::delete('/delete-user/{userId}', [RHController::class, 'deleteUser']);
    });
});
