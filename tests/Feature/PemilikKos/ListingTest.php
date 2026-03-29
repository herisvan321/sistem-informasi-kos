<?php

namespace Tests\Feature\PemilikKos;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ListingTest extends TestCase
{
    use RefreshDatabase;

    protected $owner;

    protected function setUp(): void
    {
        parent::setUp();
        
        Role::create(['name' => 'pemilik-kos']);
        
        $this->owner = User::factory()->create([
            'type_user' => 'Pemilik Kos',
            'status' => 'Active'
        ]);
        $this->owner->assignRole('pemilik-kos');
    }

    public function test_owner_can_see_listing_index()
    {
        $response = $this->actingAs($this->owner)
                         ->get(route('pemilik-kos.listings.index'));

        $response->assertStatus(200);
        $response->assertSee('Portofolio Aset Properti');
    }

    public function test_owner_can_create_listing()
    {
        Storage::fake('public');

        $data = [
            'name' => 'Kos Baru',
            'address' => 'Jl. Baru No. 1',
            'city' => 'Padang',
            'district' => 'Padang Barat',
            'price' => 1000000,
            'description' => 'Deskripsi kos',
            'facilities' => ['WiFi', 'AC'],
            'main_photo' => UploadedFile::fake()->image('kos.jpg')
        ];

        $response = $this->actingAs($this->owner)
                         ->post(route('pemilik-kos.listings.store'), $data);

        $response->assertRedirect(route('pemilik-kos.listings.index'));
        $this->assertDatabaseHas('listings', [
            'name' => 'Kos Baru',
            'owner_id' => $this->owner->id
        ]);
    }

    public function test_owner_can_edit_own_listing()
    {
        $listing = Listing::create([
            'owner_id' => $this->owner->id,
            'name' => 'Kos Lama',
            'address' => 'Jl. Lama',
            'city' => 'Padang',
            'district' => 'Padang Timur',
            'price' => 500000,
            'description' => 'Deskripsi lama'
        ]);

        $response = $this->actingAs($this->owner)
                         ->get(route('pemilik-kos.listings.edit', $listing->id));

        $response->assertStatus(200);
        $response->assertSee('Kos Lama');
    }

    public function test_owner_cannot_access_other_owner_listing()
    {
        $otherOwner = User::factory()->create();
        $otherOwner->assignRole('pemilik-kos');

        $listing = Listing::create([
            'owner_id' => $otherOwner->id,
            'name' => 'Kos Orang Lain',
            'address' => 'Jl. Lain',
            'city' => 'Padang',
            'district' => 'Padang Timur',
            'price' => 500000,
            'description' => 'Deskripsi'
        ]);

        $response = $this->actingAs($this->owner)
                         ->get(route('pemilik-kos.listings.edit', $listing->id));

        $response->assertStatus(403);
    }

    public function test_owner_can_see_premium_payment_page()
    {
        $listing = Listing::create([
            'owner_id' => $this->owner->id,
            'name' => 'Kos Test',
            'address' => 'Jl. Test',
            'city' => 'Padang',
            'district' => 'Padang Timur',
            'price' => 500000,
            'description' => 'Deskripsi lama'
        ]);

        $response = $this->actingAs($this->owner)
                         ->get(route('pemilik-kos.listings.premium-payment', $listing->id));

        $response->assertStatus(200);
        $response->assertSee('Pembayaran Premium');
    }

    public function test_owner_can_submit_premium_proof()
    {
        Storage::fake('public');

        $listing = Listing::create([
            'owner_id' => $this->owner->id,
            'name' => 'Kos Test',
            'address' => 'Jl. Test',
            'city' => 'Padang',
            'district' => 'Padang Timur',
            'price' => 500000,
            'description' => 'Deskripsi lama',
            'premium_status' => 'none'
        ]);

        $data = [
            'payment_proof' => UploadedFile::fake()->image('proof.jpg')
        ];

        $response = $this->actingAs($this->owner)
                         ->post(route('pemilik-kos.listings.submit-premium', $listing->id), $data);

        $response->assertRedirect(route('pemilik-kos.listings.index'));
        $this->assertDatabaseHas('listings', [
            'id' => $listing->id,
            'premium_status' => 'pending'
        ]);
        
        $listing = $listing->fresh();
        $this->assertNotNull($listing->premium_payment_proof);
        Storage::disk('public')->assertExists($listing->premium_payment_proof);
    }
}
