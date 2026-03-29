<?php

namespace Tests\Feature\PemilikKos;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $owner;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Ensure roles exist
        Role::create(['name' => 'pemilik-kos']);
        
        $this->owner = User::factory()->create([
            'type_user' => 'Pemilik Kos',
            'status' => 'Active'
        ]);
        $this->owner->assignRole('pemilik-kos');
    }

    public function test_owner_can_access_dashboard()
    {
        $response = $this->actingAs($this->owner)
                         ->get(route('pemilik-kos.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Command Center');
        $response->assertSee($this->owner->name);
    }

    public function test_dashboard_displays_correct_stats()
    {
        // Add some listings
        Listing::factory()->count(3)->create([
            'owner_id' => $this->owner->id,
            'status' => 'Approved'
        ]);

        $response = $this->actingAs($this->owner)
                         ->get(route('pemilik-kos.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('3'); // Total Listing
    }
}
