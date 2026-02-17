<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:create permission', only: ['create', 'store']),
            new Middleware('permission:update permission', only: ['edit', 'update']),
            new Middleware('permission:view permission', only: ['index', 'show']),
            new Middleware('permission:delete permission', only: ['destroy']),
        ];
    }
    
    public function index()
    {
        $permissions = Permission::orderBy('id', 'desc')->paginate(10);
        return view('role-permission.permission.index', [
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        return view('role-permission.permission.create');
    }

    public function store(StorePermissionRequest $request)
    {
        Permission::create([
            'name' => $request->name
        ]);

        return redirect('permission')->with('status', 'Permission Created Successfully');
    }

    public function edit(string $id)
    {
        $permission = Permission::findOrFail($id);
        return view('role-permission.permission.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, string $id)
    {
        Permission::findOrFail($id)->update([
            'name' => $request->name
        ]);

        return redirect('permission')->with('status', 'Permission Updated Successfully');
    }

    public function destroy(string $id)
    {
        Permission::findOrFail($id)->delete();
        return redirect('permission')->with('status', 'Permission Deleted Successfully');
    }
}
