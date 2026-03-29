<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RolePermissionSeeder;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $response = $this->actingAs($admin)
                         ->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Pusat Kendali Ekosistem');
        $response->assertViewHas('total_users');
        $response->assertViewHas('total_listings');
        $response->assertViewHas('activities');
    }

    public function test_non_admin_cannot_access_dashboard(): void
    {
        $user = User::factory()->create();
        $user->assignRole('pencari-kos');

        $response = $this->actingAs($user)
                         ->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    public function test_admin_can_access_analytics(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $response = $this->actingAs($admin)
                         ->get(route('admin.analytics'));

        $response->assertStatus(200);
        $response->assertSee('Laporan');
        $response->assertSee('Analitik');
        $response->assertViewHas('total_users');
    }
}
