<?php

namespace Tests\Feature\PemilikKos;

use App\Models\User;
use App\Models\Listing;
use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class InquiryTest extends TestCase
{
    use RefreshDatabase;

    protected $owner;
    protected $tenant;
    protected $listing;

    protected function setUp(): void
    {
        parent::setUp();
        
        Role::create(['name' => 'pemilik-kos']);
        Role::create(['name' => 'pencari-kos']);
        
        $this->owner = User::factory()->create(['type_user' => 'Pemilik Kos', 'status' => 'Active']);
        $this->owner->assignRole('pemilik-kos');

        $this->tenant = User::factory()->create(['type_user' => 'Pencari Kos', 'status' => 'Active']);
        $this->tenant->assignRole('pencari-kos');

        $this->listing = Listing::create([
            'owner_id' => $this->owner->id,
            'name' => 'Kos Test',
            'address' => 'Jl. Test',
            'city' => 'Padang',
            'district' => 'Padang Timur',
            'price' => 500000,
            'description' => 'Deskripsi test'
        ]);
    }

    public function test_owner_can_see_inquiry_index()
    {
        $response = $this->actingAs($this->owner)
                         ->get(route('pemilik-kos.inquiries.index'));

        $response->assertStatus(200);
        $response->assertSee('Pusat Komunikasi & Inquiry', false);
    }

    public function test_owner_can_read_inquiry()
    {
        $inquiry = Inquiry::create([
            'listing_id' => $this->listing->id,
            'sender_id' => $this->tenant->id,
            'receiver_id' => $this->owner->id,
            'message' => 'Halo boss',
            'status' => 'Unread'
        ]);

        $response = $this->actingAs($this->owner)
                         ->get(route('pemilik-kos.inquiries.show', $inquiry->id));

        $response->assertStatus(200);
        $response->assertSee('Halo boss');
        
        $this->assertDatabaseHas('inquiries', [
            'id' => $inquiry->id,
            'status' => 'Read'
        ]);
    }

    public function test_owner_can_respond_to_inquiry()
    {
        $inquiry = Inquiry::create([
            'listing_id' => $this->listing->id,
            'sender_id' => $this->tenant->id,
            'receiver_id' => $this->owner->id,
            'message' => 'Halo boss',
            'status' => 'Unread'
        ]);

        $data = [
            'message' => 'Halo juga'
        ];

        $response = $this->actingAs($this->owner)
                         ->post(route('pemilik-kos.inquiries.respond', $inquiry->id), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('inquiries', [
            'listing_id' => $this->listing->id,
            'sender_id' => $this->owner->id,
            'receiver_id' => $this->tenant->id,
            'message' => 'Halo juga'
        ]);
    }
}
