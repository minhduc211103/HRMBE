<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    // Hiển thị form login
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // Xử lý login
    public function login(Request $request)
    {
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username.required' => 'Username is required.',
                'password.required' => 'Password is required.',
            ]
        );

        $adminUsername = config('app.admin_username');
        $adminPassword = config('app.admin_password');

        if (
            $request->username === $adminUsername &&
            $request->password === $adminPassword
        ) {
            session(['is_admin' => true]);

            return redirect('/admin')->with('success', 'Admin login successful.');
        }

        return back()
            ->withErrors([
                'username' => 'Invalid username or password.',

            ])
            ->withInput();
    }

    // Logout admin
    public function logout()
    {
        session()->forget('is_admin');
        return redirect('/admin-login')->with('success', 'Đã đăng xuất admin');
    }
}
