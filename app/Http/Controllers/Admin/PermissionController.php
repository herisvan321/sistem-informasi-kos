<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions,name']);
        Permission::create(['name' => $request->name]);
        return back()->with('success', 'Permission berhasil ditambahkan!');
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate(['name' => 'required|unique:permissions,name,' . $permission->id]);
        $permission->update(['name' => $request->name]);
        return back()->with('success', 'Nama permission berhasil diperbarui!');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back()->with('success', 'Permission berhasil dihapus!');
    }
}
