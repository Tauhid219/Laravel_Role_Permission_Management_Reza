<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:create user', only: ['create', 'store']),
            new Middleware('permission:update user', only: ['edit', 'update']),
            new Middleware('permission:view user', only: ['index']),
            new Middleware('permission:delete user', only: ['destroy']),
            new Middleware('auth', only: ['edit', 'update']),
        ];
    }

    public function index()
    {
        $users = User::paginate(10);
        return view('role-permission.user.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $roles = Role::get();
        return view('role-permission.user.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->role);

        return redirect('/user')->with('status', 'User Created Successfully with Roles');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('role-permission.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if (!empty($request->password)) {
            $data += [
                'password' => Hash::make($request->password)
            ];
        }

        $user = User::findOrFail($id);
        $user->update($data);

        $user->syncRoles($request->role);

        return redirect('user')->with('status', 'User Updated Successfully with Roles');
    }

    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
        return redirect('user')->with('status', 'User Deleted Successfully');
    }
}
