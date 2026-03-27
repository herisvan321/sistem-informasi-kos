<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RolePermissionSeeder;

class ListingTest extends TestCase
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

    public function test_admin_can_list_listings(): void
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get(route('admin.listings.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_approve_listing(): void
    {
        $admin = $this->getAdmin();
        $listing = Listing::factory()->create(['status' => 'Pending']);

        $response = $this->actingAs($admin)->post(route('admin.listings.approve', $listing->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('listings', ['id' => $listing->id, 'status' => 'Approved']);
    }

    public function test_admin_can_reject_listing(): void
    {
        $admin = $this->getAdmin();
        $listing = Listing::factory()->create(['status' => 'Pending']);

        $rejectData = [
            'reason' => 'Foto tidak jelas',
            'notes' => 'Tolong upload foto yang lebih terang.'
        ];

        $response = $this->actingAs($admin)->post(route('admin.listings.reject', $listing->id), $rejectData);

        $response->assertRedirect();
        $this->assertDatabaseHas('listings', [
            'id' => $listing->id, 
            'status' => 'Rejected',
            'rejection_reason' => 'Foto tidak jelas'
        ]);
    }

    public function test_admin_can_toggle_listing_premium(): void
    {
        $admin = $this->getAdmin();
        $listing = Listing::factory()->create(['is_premium' => false]);

        $response = $this->actingAs($admin)->post(route('admin.listings.toggle-premium', $listing->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('listings', ['id' => $listing->id, 'is_premium' => true]);
    }

    public function test_admin_can_update_listing(): void
    {
        $admin = $this->getAdmin();
        $listing = Listing::factory()->create();

        $updateData = [
            'name' => 'Lux Kos Updated',
            'address' => 'Jl. Baru No. 123',
            'price' => 2500000,
            'status' => 'Approved'
        ];

        $response = $this->actingAs($admin)->patch(route('admin.listings.update', $listing->id), $updateData);

        $response->assertRedirect(route('admin.listings.index'));
        $this->assertDatabaseHas('listings', ['id' => $listing->id, 'name' => 'Lux Kos Updated']);
    }
}
