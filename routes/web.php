<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;

// Kiểm tra url rỗng => login || dashboard
Route::get('/', function () {
    if (session('is_admin')) {
        return redirect('/admin');
    }
    return redirect('/admin-login');
});
Route::get('/admin-login', [AdminAuthController::class, 'showLoginForm']);
Route::post('/admin-login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin-logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

//Bật middleware xem đăng nhập chưa trước khi điều hướng trang .
Route::prefix('admin')->middleware('admin.auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class,'index'])->name('admin.index');

    Route::get('/hr',[\App\Http\Controllers\UserController::class,'index'])->name('admin.hr.index');
    Route::get('/hr/create', [UserController::class, 'create'])->name('admin.hr.create');
    Route::post('/hr', [UserController::class, 'store'])->name('admin.hr.store');

    Route::get('/projects',[\App\Http\Controllers\ProjectController::class,'index'])->name('admin.projects.index');
    Route::get('/projects/create', [\App\Http\Controllers\ProjectController::class, 'create'])->name('admin.projects.create');
    Route::post('/projects', [\App\Http\Controllers\ProjectController::class, 'store'])->name('admin.projects.store');
    Route::put('/projects/{id}', [\App\Http\Controllers\ProjectController::class, 'updateFromAdmin'])->name('admin.projects.update');
    Route::delete('/projects/{id}', [\App\Http\Controllers\ProjectController::class, 'destroy'])->name('admin.projects.destroy');

    Route::get('/meetings/create', [\App\Http\Controllers\MeetingController::class, 'create'])->name('admin.meetings.create');
    Route::post('/meetings', [\App\Http\Controllers\MeetingController::class, 'store'])->name('admin.meetings.store');
});
require __DIR__.'/auth.php';
