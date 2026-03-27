<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('admin.roles-permissions.index', compact('roles', 'permissions'));
    }

    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        Role::create(['name' => $request->name]);
        return back()->with('success', 'Role berhasil ditambahkan!');
    }

    public function syncMatrix(Request $request)
    {
        $matrix = $request->matrix ?? [];
        $roles = Role::where('name', '!=', 'super-admin')->get();

        /** @var \Spatie\Permission\Models\Role $role */
        foreach ($roles as $role) {
            $permissions = isset($matrix[$role->id]) ? array_keys($matrix[$role->id]) : [];
            $role->syncPermissions($permissions);
        }

        return back()->with('success', 'Matriks hak akses berhasil disinkronisasi!');
    }
}
