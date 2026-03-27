<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function create(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        
        $role = $data['role'] ?? null;
        unset($data['role']); // Not a column in users table

        /** @var User $user */
        $user = parent::create($data);

        if ($role) {
            $user->assignRole($role);
        }

        return $user;
    }

    public function toggleStatus(string $id): bool
    {
        $user = $this->find($id);
        $newStatus = $user->status === 'active' ? 'blocked' : 'active';
        return $user->update(['status' => $newStatus]);
    }

    public function verifyOwner(string $id): bool
    {
        $user = $this->find($id);
        return $user->update(['status' => 'active']);
    }
}
