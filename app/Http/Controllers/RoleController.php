<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:create role', only: ['create', 'store']),
            new Middleware('permission:update role', only: ['edit', 'update', 'addPermissionToRole', 'givePermissionToRole']),
            new Middleware('permission:view role', only: ['index', 'show']),
            new Middleware('permission:delete role', only: ['destroy']),
        ];
    }

    public function index()
    {
        $role = Role::get();
        return view('role-permission.role.index', [
            'role' => $role
        ]);
    }

    public function create()
    {
        return view('role-permission.role.create');
    }

    public function edit(string $id)
    {
        $role = Role::find($id);
        return view('role-permission.role.edit', compact('role'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:roles,name']
        ]);

        Role::find($id)->update([
            'name' => $request->name
        ]);

        return redirect('role')->with('status', 'Role Updated Successfully');
    }

    public function show(string $id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('role-permission.role.show', compact('role', 'rolePermissions'));
    }

    public function destroy(string $id)
    {
        Role::find($id)->delete();
        return redirect('role')->with('status', 'Role Deleted Successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:roles,name']
        ]);

        Role::create([
            'name' => $request->name
        ]);

        return redirect('role')->with('status', 'Role Created Successfully');
    }

    public function addPermissionToRole(string $id)
    {
        $permission = Permission::get();
        $role = Role::find($id);
        $rolepermission = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $role->id)->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();

        return view('role-permission.role.add-permission', compact('role', 'permission', 'rolepermission'));
    }

    public function givePermissionToRole(Request $request, string $id)
    {
        $request->validate([
            'permission' => ['required']
        ]);

        $role = Role::find($id);
        $role->syncPermissions($request->permission);

        return redirect()->back()->with('status', 'Permission added to Role');
    }
}
