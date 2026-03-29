<?php

namespace Tests\Feature\PencariKos;

use App\Models\User;
use App\Models\Listing;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class DiscoveryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'pencari-kos']);
    }

    public function test_pencari_kos_can_view_discovery_page()
    {
        $user = User::factory()->create(['type_user' => 'pencari-kos']);
        $user->assignRole('pencari-kos');

        $response = $this->actingAs($user)->get(route('pencari-kos.discovery.index'));

        $response->assertStatus(200);
        $response->assertSee('Discovery');
    }

    public function test_pencari_kos_can_view_listing_detail()
    {
        $user = User::factory()->create(['type_user' => 'pencari-kos']);
        $user->assignRole('pencari-kos');

        $listing = Listing::factory()->create([
            'status' => 'Approved',
            'facilities' => ['WiFi', 'AC']
        ]);

        $response = $this->actingAs($user)->get(route('pencari-kos.discovery.show', $listing->id));

        $response->assertStatus(200);
        $response->assertSee($listing->name);
    }

    public function test_pencari_kos_cannot_view_unapproved_listing()
    {
        $user = User::factory()->create(['type_user' => 'pencari-kos']);
        $user->assignRole('pencari-kos');

        $listing = Listing::factory()->create(['status' => 'Pending']);

        $response = $this->actingAs($user)->get(route('pencari-kos.discovery.show', $listing->id));

        $response->assertStatus(404);
    }
}
