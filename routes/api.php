<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskControllerForEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
// middleware cho employee
Route::middleware(['auth:sanctum', 'role:employee'])->prefix('employee')->group(function () {
    Route::get('/', [EmployeeController::class, 'index']);
    Route::get('/manager', [EmployeeController::class, 'getManager']);
    Route::get('/tasks', [TaskControllerForEmployee::class, 'getTasks']);
    Route::put('/tasks/{id}', [TaskControllerForEmployee::class, 'update']);
});

// middleware cho manager
Route::middleware(['auth:sanctum', 'role:manager'])->prefix('manager')->group(function () {
    Route::get('/', [ManagerController::class, 'index']);
    Route::get('/employees', [ManagerController::class, 'getEmployees']);
    Route::get('/projects', [ManagerController::class, 'getProjects']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    Route::put('/projects/{id}', [ProjectController::class, 'update']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
});
