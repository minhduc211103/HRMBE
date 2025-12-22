<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectControllerForManager;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskControllerForEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
// middleware cho employee
Route::middleware(['auth:sanctum', 'role:employee'])->prefix('employee')->group(function () {
    Route::get('/', [EmployeeController::class, 'getEmployee']);
    Route::get('/manager', [EmployeeController::class, 'getManager']);
    Route::get('/tasks', [TaskControllerForEmployee::class, 'getTasks']);
    Route::put('/tasks/{id}', [TaskControllerForEmployee::class, 'update']);
});

// middleware cho manager
Route::middleware(['auth:sanctum', 'role:manager'])->prefix('manager')->group(function () {
    Route::get('/', [ManagerController::class, 'getManager']);
    Route::get('/employees', [ManagerController::class, 'getEmployees']);
    Route::get('/projects', [ManagerController::class, 'getProjects']);
    Route::post('/projects', [ProjectControllerForManager::class, 'store']);
    Route::delete('/projects/{id}', [ProjectControllerForManager::class, 'destroy']);
    Route::get('/projects/{id}', [\App\Http\Controllers\ProjectControllerForManager::class, 'show']);
    Route::put('/projects/{id}', [\App\Http\Controllers\ProjectControllerForManager::class, 'updateFromManager']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
});
// Route dùng chung
Route::middleware(['auth:sanctum', 'role:manager,employee'])->group(function () {
    Route::post('documents', [DocumentController::class, 'upload']);
    Route::get('documents/{id}/download', [DocumentController::class, 'download']);
    Route::delete('documents/{id}', [DocumentController::class, 'deleteDocument']);
});
