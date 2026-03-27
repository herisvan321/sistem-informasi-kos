<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RolePermissionSeeder;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_super_admin_can_access_all_admin_routes(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $routes = [
            'admin.dashboard',
            'admin.users.index',
            'admin.listings.index',
            'admin.moderation',
            'admin.settings',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($admin)->get(route($route));
            $response->assertStatus(200);
        }
    }

    public function test_pemilik_kos_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create();
        $user->assignRole('pemilik-kos');

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_routes(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }
}
