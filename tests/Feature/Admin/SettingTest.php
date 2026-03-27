<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RolePermissionSeeder;

class SettingTest extends TestCase
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

    public function test_admin_can_view_settings(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get(route('admin.settings'));
        $response->assertStatus(200);
    }

    public function test_admin_can_update_settings(): void
    {
        $admin = $this->getAdmin();
        
        $settingsData = [
            'app_name' => 'Kos Platform Pro',
            'contact_email' => 'pro@kosapp.id',
            'premium_price' => 75000,
            'maintenance_mode' => '1'
        ];

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), $settingsData);

        $response->assertRedirect();
        $this->assertDatabaseHas('settings', ['key' => 'app_name', 'value' => 'Kos Platform Pro']);
        $this->assertDatabaseHas('settings', ['key' => 'maintenance_mode', 'value' => '1']);
    }
}
