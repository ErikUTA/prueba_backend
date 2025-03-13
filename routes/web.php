<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProjectController;
use \App\Http\Controllers\TaskController;
use \App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;


Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);

Route::middleware('auth:sanctum')->get('user', function () {
    return Auth::user();
});

Route::middleware('auth:sanctum')->group(function () {
    
    Route::put('/update-user/{userId}', [UserController::class, 'updateUser']);
    
    Route::middleware('role:developer,tester,planning')->group(function() {
        Route::get('/get-user-task', [UserController::class, 'getUserById']);
        Route::get('/get-projects', [ProjectController::class, 'getProjects']);
        Route::get('/get-tasks', [TaskController::class, 'getTasks']);
        Route::put('/update-status/{taskId}', [TaskController::class, 'updateStatus']);
    }); 

    Route::middleware('role:planning')->group(function() {
        Route::get('/get-users-planning', [UserController::class, 'getUsersToPlanning']);
        Route::post('/create-task', [TaskController::class, 'createTask']);
        Route::put('/update-task/{projectId}', [TaskController::class, 'updateTask']);
        Route::delete('/delete-task/{projectId}', [TaskController::class, 'deleteTask']);
        Route::post('/create-project', [ProjectController::class, 'createProject']);
        Route::put('/update-project/{projectId}', [ProjectController::class, 'updateProject']);
        Route::post('/assign-users-project/{projectId}', [ProjectController::class, 'assignUserToProject']);
        Route::delete('/delete-project/{projectId}', [ProjectController::class, 'deleteProject']);
    });

    Route::middleware('role:RH')->group(function() {
        Route::get('/get-users', [UserController::class, 'getUsers']);
        Route::post('/register', [UserController::class, 'register']);
        Route::post('/update-password/{userId}', [UserController::class, 'updatePassword']);
        Route::post('/update-role/{userId}', [UserController::class, 'updateRole']);
        Route::delete('/delete-user/{userId}', [UserController::class, 'deleteUser']);
    });
});
