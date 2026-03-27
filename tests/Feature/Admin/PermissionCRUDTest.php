<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PermissionCRUDTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $this->admin = User::whereEmail('admin@kosapp.id')->first();
    }

    public function test_admin_can_list_permissions()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.permissions.index'));
        $response->assertStatus(200);
        $response->assertSee('read');
    }

    public function test_admin_can_create_permission()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.permissions.store'), [
            'name' => 'audit-logs'
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('permissions', ['name' => 'audit-logs']);
    }

    public function test_admin_can_update_permission()
    {
        $permission = Permission::create(['name' => 'old-perm']);
        $response = $this->actingAs($this->admin)->patch(route('admin.permissions.update', $permission->id), [
            'name' => 'new-perm'
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('permissions', ['name' => 'new-perm']);
    }

    public function test_admin_can_delete_permission()
    {
        $permission = Permission::create(['name' => 'to-delete']);
        $response = $this->actingAs($this->admin)->delete(route('admin.permissions.destroy', $permission->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('permissions', ['name' => 'to-delete']);
    }
}
