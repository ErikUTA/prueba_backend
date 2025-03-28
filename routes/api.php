<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProjectController;
use \App\Http\Controllers\TaskController;
use \App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;



Route::post('login', [UserController::class, 'login'])
    ->name('web.login');

Route::post('logout', [UserController::class, 'logout'])
    ->name('web.logout');

Route::middleware('auth:sanctum')->get('user', function () {
    return Auth::user();
});

Route::namespace('Web')->middleware('auth:sanctum')->group(function () {
    
    Route::put('/update-user/{userId}', [UserController::class, 'updateUser'])
        ->name('web.update_user');
    
    Route::middleware('role:1,2,3')->group(function() {
        Route::controller(UserController::class)->group(function () {
            Route::get('/get-user-task/{userId}', [UserController::class, 'getUserById'])
                ->name('web.get_user_task');
        });

        Route::controller(ProjectController::class)->group(function() {
            Route::get('/get-projects', [ProjectController::class, 'getProjects'])
                ->name('web.get_projects');
        });

        Route::controller(TaskController::class)->group(function() {
            Route::get('/get-tasks', [TaskController::class, 'getTasks'])
                ->name('web.get_tasks');

            Route::put('/update-status/{taskId}', [TaskController::class, 'updateStatus'])
                ->name('web.update_status');
        });
    }); 

    Route::middleware('role:2')->group(function() {
        Route::controller(UserController::class)->group(function () {
            Route::get('/get-users-planning', [UserController::class, 'getUsersToPlanning'])
                ->name('web.get_users_planning');

            Route::post('/assign-task/{userId}', [UserController::class, 'assignTaskToUser'])
                ->name('web.assign_task');
        });

        Route::controller(TaskController::class)->group(function () {
            Route::post('/create-task', [TaskController::class, 'createTask'])
                ->name('web.create_task');

            Route::put('/update-task/{taskId}', [TaskController::class, 'updateTask'])
                ->name('web.update_task');

            Route::put('/assign-users-task/{taskId}', [TaskController::class, 'assignUsersToTask'])
                ->name('web.assign_users_task');

            Route::delete('/delete-task/{taskId}', [TaskController::class, 'deleteTask'])
                ->name('web.delete_task');
        });

        Route::controller(ProjectController::class)->group(function () {
            Route::post('/create-project', [ProjectController::class, 'createProject'])
                ->name('web.create_project');
                
            Route::put('/update-project/{projectId}', [ProjectController::class, 'updateProject'])
                ->name('web.update_project');

            Route::post('/assign-users-project/{projectId}', [ProjectController::class, 'assignUserToProject'])
                ->name('web.assign_users_project');

            Route::delete('/delete-project/{projectId}', [ProjectController::class, 'deleteProject'])
                ->name('web.delete_project');
        });
    });

    Route::middleware('role:4')->group(function() {
        Route::controller(UserController::class)->group(function () {
            Route::get('/get-users', [UserController::class, 'getUsers'])
                ->name('web.get_users');

            Route::post('/register', [UserController::class, 'register'])
                ->name('web.register');

            Route::put('/update-password/{userId}', [UserController::class, 'updatePassword'])
                ->name('web.update_password');

            Route::put('/update-role/{userId}', [UserController::class, 'updateRole'])
                ->name('web.update_role');

            Route::delete('/delete-user/{userId}', [UserController::class, 'deleteUser'])
                ->name('web.delete_user');
        });
    });
});
