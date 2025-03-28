<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProjectController;
use \App\Http\Controllers\TaskController;
use \App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::prefix('auth')->group(function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::middleware('auth:sanctum')->get('user', function () {
        return Auth::user();
    });
});

Route::prefix('api')->middleware('auth:sanctum')->group(function () {
    Route::put('/update-user/{userId}', [UserController::class, 'updateUser']);
    
    Route::middleware('role:1,2,3')->group(function() {
        Route::controller(UserController::class)->group(function () {
            Route::get('/get-user-task/{userId}', [UserController::class, 'getUserById']);
        });

        Route::controller(ProjectController::class)->group(function() {
            Route::get('/get-projects', [ProjectController::class, 'getProjects']);
        });

        Route::controller(TaskController::class)->group(function() {
            Route::get('/get-tasks', [TaskController::class, 'getTasks']);
            Route::put('/update-status/{taskId}', [TaskController::class, 'updateStatus']);
        });
    }); 

    Route::middleware('role:2')->group(function() {
        Route::controller(UserController::class)->group(function () {
            Route::get('/get-users-planning', [UserController::class, 'getUsersToPlanning']);
            Route::post('/assign-task/{userId}', [UserController::class, 'assignTaskToUser']);
        });

        Route::controller(TaskController::class)->group(function () {
            Route::post('/create-task', [TaskController::class, 'createTask']);
            Route::put('/update-task/{taskId}', [TaskController::class, 'updateTask']);
            Route::put('/assign-users-task/{taskId}', [TaskController::class, 'assignUsersToTask']);
            Route::delete('/delete-task/{taskId}', [TaskController::class, 'deleteTask']);
        });

        Route::controller(ProjectController::class)->group(function () {
            Route::post('/create-project', [ProjectController::class, 'createProject']);
            Route::put('/update-project/{projectId}', [ProjectController::class, 'updateProject']);
            Route::post('/assign-users-project/{projectId}', [ProjectController::class, 'assignUserToProject']);
            Route::delete('/delete-project/{projectId}', [ProjectController::class, 'deleteProject']);
        });
    });

    Route::middleware('role:4')->group(function() {
        Route::controller(UserController::class)->group(function () {
            Route::get('/get-users', [UserController::class, 'getUsers']);
            Route::post('/register', [UserController::class, 'register']);
            Route::put('/update-password/{userId}', [UserController::class, 'updatePassword']);
            Route::put('/update-role/{userId}', [UserController::class, 'updateRole']);
            Route::delete('/delete-user/{userId}', [UserController::class, 'deleteUser']);
        });
    });
});
