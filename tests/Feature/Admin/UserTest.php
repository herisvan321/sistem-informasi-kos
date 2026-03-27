<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RolePermissionSeeder;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    protected function getAdmin()
    {
        $admin = User::factory()->create();
        $admin->assignRole('super-admin');
        return $admin;
    }

    public function test_admin_can_list_users(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get(route('admin.users.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_store_user(): void
    {
        $admin = $this->getAdmin();
        $userData = [
            'name' => 'New Test User',
            'email' => 'newtest@example.com',
            'password' => 'password123',
            'role' => 'pencari-kos'
        ];

        $response = $this->actingAs($admin)->post(route('admin.users.store'), $userData);
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', ['email' => 'newtest@example.com']);
    }

    public function test_admin_can_update_user(): void
    {
        $admin = $this->getAdmin();
        $user = User::factory()->create(['status' => 'active']);

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'status' => 'blocked'
        ];

        $response = $this->actingAs($admin)->patch(route('admin.users.update', $user), $updateData);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated Name', 'status' => 'blocked']);
    }

    public function test_admin_can_toggle_user_status(): void
    {
        $admin = $this->getAdmin();
        $user = User::factory()->create(['status' => 'active']);

        $response = $this->actingAs($admin)->post(route('admin.users.toggle-status', $user));

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $user->id, 'status' => 'blocked']);
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = $this->getAdmin();
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $user));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }
}
