<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Manager;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        $managers = Manager::all();
        return view('admin.users.create', compact('managers'));
    }

    public function store(StoreUserRequest $request)
    {
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
