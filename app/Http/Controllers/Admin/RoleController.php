<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);
        $role = Role::create(['name' => $request->name]);
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }
        return back()->with('success', 'Role dan permisi berhasil ditambahkan!');
    }

    public function update(Request $request, Role $role)
    {
        if ($role->name === 'super-admin') {
            return back()->with('error', 'Role super-admin tidak dapat diubah.');
        }
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array'
        ]);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);
        return back()->with('success', 'Role berhasil diperbarui!');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'super-admin') {
            return back()->with('error', 'Role super-admin tidak dapat dihapus.');
        }
        $role->delete();
        return back()->with('success', 'Role berhasil dihapus!');
    }
}
