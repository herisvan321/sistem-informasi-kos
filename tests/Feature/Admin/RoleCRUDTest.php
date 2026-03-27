<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class RoleCRUDTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $this->admin = User::whereEmail('admin@kosapp.id')->first();
    }

    public function test_admin_can_list_roles()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.roles.index'));
        $response->assertStatus(200);
        $response->assertSee('SUPER-ADMIN');
    }

    public function test_admin_can_create_role_with_permissions()
    {
        $perm = Permission::create(['name' => 'extra-perm']);
        $response = $this->actingAs($this->admin)->post(route('admin.roles.store'), [
            'name' => 'manager',
            'permissions' => ['extra-perm']
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('roles', ['name' => 'manager']);
        $role = Role::whereName('manager')->first();
        $this->assertTrue($role->hasPermissionTo('extra-perm'));
    }

    public function test_admin_can_update_role_with_permissions()
    {
        $role = Role::create(['name' => 'editor']);
        $perm = Permission::create(['name' => 'edit-logic']);
        $response = $this->actingAs($this->admin)->patch(route('admin.roles.update', $role->id), [
            'name' => 'senior-editor',
            'permissions' => ['edit-logic']
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('roles', ['name' => 'senior-editor']);
        $role->refresh();
        $this->assertTrue($role->hasPermissionTo('edit-logic'));
    }

    public function test_admin_cannot_delete_super_admin_role()
    {
        $role = Role::whereName('super-admin')->first();
        $response = $this->actingAs($this->admin)->delete(route('admin.roles.destroy', $role->id));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('roles', ['name' => 'super-admin']);
    }

    public function test_admin_can_delete_other_role()
    {
        $role = Role::create(['name' => 'temporary']);
        $response = $this->actingAs($this->admin)->delete(route('admin.roles.destroy', $role->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('roles', ['name' => 'temporary']);
    }
}
