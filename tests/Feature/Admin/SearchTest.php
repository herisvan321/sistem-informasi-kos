<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        Role::create(['name' => 'super-admin']);
        
        $this->admin = User::factory()->create(['status' => 'active']);
        $this->admin->assignRole('super-admin');

        // Create some listings for searching
        Listing::factory()->create([
            'name' => 'Kos Melati',
            'address' => 'Jl. Melati No. 1',
            'owner_id' => $this->admin->id
        ]);

        Listing::factory()->create([
            'name' => 'Kos Mawar',
            'address' => 'Jl. Mawar No. 2',
            'owner_id' => $this->admin->id
        ]);
    }

    public function test_admin_can_search_listings_by_name()
    {
        $response = $this->actingAs($this->admin)
                         ->get(route('admin.listings.index', ['search' => 'Melati']));

        $response->assertStatus(200);
        $response->assertSee('Kos Melati');
        $response->assertDontSee('Kos Mawar');
    }

    public function test_admin_can_search_listings_by_address()
    {
        $response = $this->actingAs($this->admin)
                         ->get(route('admin.listings.index', ['search' => 'Mawar']));

        $response->assertStatus(200);
        $response->assertSee('Kos Mawar');
        $response->assertDontSee('Kos Melati');
    }
}
