<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::post('login', [UserController::class, 'login'])
    ->name('api.login');
Route::post('logout', [UserController::class, 'logout'])
    ->name('api.logout');

Route::middleware('auth:sanctum')->get('user', function () {
    return Auth::user();
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('users')->group(function() {
        Route::put('/update/{userId}', [UserController::class, 'updateUser'])
            ->name('api.update_user');
        
        Route::middleware('role:1,2,3')->group(function () {
            Route::get('/get-user-task/{userId}', [UserController::class, 'getUserById'])
                ->name('api.get_user_task');
        });

        Route::middleware('role:2')->group(function () {
            Route::get('/get-users-planning', [UserController::class, 'getUsersToPlanning'])
                ->name('api.get_users_planning');

            Route::post('/assign-task/{userId}', [UserController::class, 'assignTaskToUser'])
                ->name('api.assign_task');

        });

        Route::middleware('role:4')->group(function () {
            Route::get('/get-users', [UserController::class, 'getUsers'])
                ->name('api.get_users');

            Route::post('/register', [UserController::class, 'register'])
                ->name('api.register');

            Route::put('/update-password/{userId}', [UserController::class, 'updatePassword'])
                ->name('api.update_password');

            Route::put('/update-role/{userId}', [UserController::class, 'updateRole'])
                ->name('api.update_role');

            Route::put('/delete-user/{userId}', [UserController::class, 'deleteUser'])
                ->name('api.delete_user');
        });
    });

    Route::prefix('projects')->group(function() {
        Route::middleware('role:1,2,3')->group(function () {
            Route::get('/', [ProjectController::class, 'getProjects'])
                ->name('api.get_projects');

        });

        Route::middleware('role:2')->group(function () {
            Route::post('/create', [ProjectController::class, 'createProject'])
                ->name('api.create_project');

            Route::put('/update/{projectId}', [ProjectController::class, 'updateProject'])
                ->name('api.update_project');

            Route::post('/assign-users/{projectId}', [ProjectController::class, 'assignUserToProject'])
                ->name('api.assign_users_project');

            Route::delete('/delete/{projectId}', [ProjectController::class, 'deleteProject'])
                ->name('api.delete_project');
        });
    });

    Route::prefix('tasks')->group(function() {
        Route::middleware('role:1,2,3')->group(function () {
            Route::get('/', [TaskController::class, 'getTasks'])
                ->name('api.get_tasks');

            Route::put('/update-status/{taskId}', [TaskController::class, 'updateStatus'])
                ->name('api.update_status');
        });

        Route::middleware('role:2')->group(function () {
            Route::post('/create', [TaskController::class, 'createTask'])
                ->name('api.create_task');

            Route::put('/update/{taskId}', [TaskController::class, 'updateTask'])
                ->name('api.update_task');

            Route::put('/assign-users/{taskId}', [TaskController::class, 'assignUsersToTask'])
                ->name('api.assign_users_task');

            Route::delete('/delete/{taskId}', [TaskController::class, 'deleteTask'])
                ->name('api.delete_task');
        });
    });
});
