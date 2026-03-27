<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::with('roles')
            ->when($search, function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return redirect()->route('admin.users.index');
    }

    public function store(StoreUserRequest $request)
    {
        $this->userService->create($request->validated());
        return back()->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return redirect()->route('admin.users.index');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->update($user->id, $request->validated());
        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $this->userService->delete($user->id);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }

    public function toggleStatus(User $user)
    {
        $this->userService->toggleStatus($user->id);
        return back()->with('success', 'Status user berhasil diperbarui!');
    }

    public function verify(User $user)
    {
        $user->update(['status' => 'active']);
        return back()->with('success', "Pemilik kos {$user->name} telah diverifikasi!");
    }
}
