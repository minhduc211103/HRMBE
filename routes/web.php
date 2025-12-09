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
    Route::get('/', function () {
        return view('admin.dashboard');
    });
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');

    Route::get('/projects/create', [\App\Http\Controllers\ProjectController::class, 'create'])->name('admin.projects.create');
    Route::post('/projects', [\App\Http\Controllers\ProjectController::class, 'store'])->name('admin.projects.store');

    Route::get('/meetings/create', [\App\Http\Controllers\MeetingController::class, 'create'])->name('admin.meetings.create');
    Route::post('/meetings', [\App\Http\Controllers\MeetingController::class, 'store'])->name('admin.meetings.store');
});
require __DIR__.'/auth.php';
