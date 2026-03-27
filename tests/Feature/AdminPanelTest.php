<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        
        $this->admin = User::factory()->create([
            'status' => 'active',
        ]);
        $this->admin->assignRole('super-admin');
    }

    public function test_dashboard_page_is_displayed(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertOk();
        $response->assertSee('Dashboard');
    }

    public function test_users_management_page_is_displayed(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));
        $response->assertOk();
        $response->assertSee('Kelola Pengguna');
    }

    public function test_listings_management_page_is_displayed(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.listings.index'));
        $response->assertOk();
        $response->assertSee('Kelola Listing');
    }

    public function test_analytics_page_is_displayed(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.analytics'));
        $response->assertOk();
        $response->assertSee('Laporan & Analitik', false);
    }

    public function test_moderation_page_is_displayed(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.moderation'));
        $response->assertOk();
        $response->assertSee('Moderasi Konten');
    }

    public function test_settings_page_is_displayed(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.settings'));
        $response->assertOk();
        $response->assertSee('Pengaturan Sistem');
    }

    public function test_role_permission_page_is_displayed(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.roles-permissions'));
        $response->assertOk();
    }
}
