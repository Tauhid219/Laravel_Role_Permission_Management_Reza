<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
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
        $roles = Role::orderBy('id', 'desc')->paginate(10);
        return view('role-permission.role.index', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        return view('role-permission.role.create');
    }

    public function store(StoreRoleRequest $request)
    {
        Role::create([
            'name' => $request->name
        ]);

        return redirect('role')->with('status', 'Role Created Successfully');
    }

    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        return view('role-permission.role.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, string $id)
    {
        Role::findOrFail($id)->update([
            'name' => $request->name
        ]);

        return redirect('role')->with('status', 'Role Updated Successfully');
    }

    public function show(string $id)
    {
        $role = Role::findOrFail($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('role-permission.role.show', compact('role', 'rolePermissions'));
    }

    public function destroy(string $id)
    {
        Role::findOrFail($id)->delete();
        return redirect('role')->with('status', 'Role Deleted Successfully');
    }

    public function addPermissionToRole(string $id)
    {
        $permissions = Permission::get();
        $role = Role::findOrFail($id);
        $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $role->id)->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();

        return view('role-permission.role.add-permission', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function givePermissionToRole(Request $request, string $id)
    {
        $request->validate([
            'permission' => ['required']
        ]);

        $role = Role::findOrFail($id);
        $role->syncPermissions($request->permission);

        return redirect()->back()->with('status', 'Permission added to Role');
    }
}
