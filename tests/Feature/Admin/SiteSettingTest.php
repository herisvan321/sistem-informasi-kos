<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RolePermissionSeeder;

class SiteSettingTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('super-admin');
    }

    public function test_admin_can_update_site_settings()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), [
            'app_name' => 'Premium Kos',
            'app_name_suffix' => 'Elite',
            'contact_email' => 'admin@elite.com'
        ]);

        $response->assertRedirect();
        $this->assertEquals('Premium Kos', get_setting('app_name'));
        $this->assertEquals('Elite', get_setting('app_name_suffix'));
    }

    public function test_settings_are_displayed_in_layout()
    {
        Setting::updateOrCreate(['key' => 'app_name'], ['value' => 'DynamicKos']);
        Setting::updateOrCreate(['key' => 'app_name_suffix'], ['value' => 'Pro']);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('DynamicKos');
        $response->assertSee('Pro');
    }
}
