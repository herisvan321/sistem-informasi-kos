<?php

namespace Tests\Feature\PemilikKos;

use App\Models\User;
use App\Models\Listing;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class TenantManagementTest extends TestCase
{
    use RefreshDatabase;

    private $owner;
    private $otherOwner;
    private $tenant;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'pemilik-kos']);
        
        $this->owner = User::factory()->create();
        $this->owner->assignRole('pemilik-kos');

        $this->otherOwner = User::factory()->create();
        $this->otherOwner->assignRole('pemilik-kos');

        $this->tenant = User::factory()->create();
    }

    public function test_owner_can_see_active_tenants_in_portfolio()
    {
        $listing = Listing::factory()->create(['owner_id' => $this->owner->id]);
        
        Transaction::create([
            'listing_id' => $listing->id,
            'user_id' => $this->tenant->id,
            'amount' => 1000000,
            'status' => 'Success',
            'payment_method' => 'Transfer Bank'
        ]);

        $response = $this->actingAs($this->owner)
                         ->get(route('pemilik-kos.tenants.index'));

        $response->assertStatus(200);
        $response->assertSee($this->tenant->name);
        $response->assertSee('Portofolio Penghuni');
    }

    public function test_owner_cannot_see_other_owners_tenants()
    {
        $otherListing = Listing::factory()->create(['owner_id' => $this->otherOwner->id]);
        $otherTenant = User::factory()->create(['name' => 'Secret Tenant']);

        Transaction::create([
            'listing_id' => $otherListing->id,
            'user_id' => $otherTenant->id,
            'amount' => 1000000,
            'status' => 'Success',
            'payment_method' => 'Transfer Bank'
        ]);

        $response = $this->actingAs($this->owner)
                         ->get(route('pemilik-kos.tenants.index'));

        $response->assertStatus(200);
        $response->assertDontSee('Secret Tenant');
    }
}
