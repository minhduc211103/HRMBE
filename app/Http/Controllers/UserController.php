<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        $managers = Manager::all();
        return view('admin.create', compact('managers'));
    }

    public function store(Request $request)
    {
        // ✅ VALIDATE TOÀN BỘ FORM
        $request->validate(
            [
                'email'      => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                'password'   => 'required|min:8',
                'role'       => 'required|in:employee,manager',
                'name'       => 'required|string|max:255',
                'phone'      => 'required|string|max:20',

                // validate theo role
                'manager_id' => 'required_if:role,employee|nullable|exists:managers,id',
                'position'   => 'required_if:role,manager|nullable|string|max:255',
            ],
            [
                'email.required'    => 'Email is required.',
                'email.email'       => 'Invalid email format.',
                'email.unique'      => 'This email already exists.',

                'password.required' => 'Password is required.',
                'password.min'      => 'Password must be at least 8 characters.',

                'role.required'     => 'Role is required.',
                'role.in'           => 'Invalid role.',

                'name.required'     => 'Full name is required.',
                'phone.required'    => 'Phone number is required.',

                'manager_id.required_if' => 'Manager is required for employee.',
                'manager_id.exists'      => 'Selected manager does not exist.',

                'position.required_if'   => 'Position is required for manager.',
            ]
        );

        DB::beginTransaction();

        try {
            // ✅ 1. TẠO USER
            $user = User::create([
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => $request->role,
            ]);
            event(new Registered($user));

            // ✅ 2. TẠO EMPLOYEE HOẶC MANAGER
            if ($request->role === 'employee') {
                Employee::create([
                    'user_id'    => $user->id,
                    'manager_id'=> $request->manager_id,
                    'name'       => $request->name,
                    'phone'      => $request->phone,
                ]);
            }

            if ($request->role === 'manager') {
                Manager::create([
                    'user_id'  => $user->id,
                    'name'     => $request->name,
                    'phone'    => $request->phone,
                    'position' => $request->position,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.users.create')
                ->with('success', 'User created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withErrors(['email' => ($e->getMessage())])
                ->withInput();
        }
    }
}
