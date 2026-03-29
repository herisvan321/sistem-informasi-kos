<?php

namespace Tests\Feature\PencariKos;

use App\Models\User;
use App\Models\Listing;
use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class InquiryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'pencari-kos']);
        Role::firstOrCreate(['name' => 'pemilik-kos']);
    }

    public function test_pencari_kos_can_send_inquiry()
    {
        $user = User::factory()->create(['type_user' => 'pencari-kos']);
        $user->assignRole('pencari-kos');

        $owner = User::factory()->create(['type_user' => 'pemilik-kos']);
        $owner->assignRole('pemilik-kos');

        $listing = Listing::factory()->create(['status' => 'Approved', 'owner_id' => $owner->id]);

        $response = $this->actingAs($user)->post(route('pencari-kos.inquiries.store', $listing->id), [
            'message' => 'Halo bos, kos ini masih ada?',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('inquiries', [
            'listing_id' => $listing->id,
            'sender_id' => $user->id,
            'message' => 'Halo bos, kos ini masih ada?',
        ]);
    }

    public function test_pencari_kos_can_view_inquiry_list()
    {
        $user = User::factory()->create(['type_user' => 'pencari-kos']);
        $user->assignRole('pencari-kos');

        $response = $this->actingAs($user)->get(route('pencari-kos.inquiries.index'));

        $response->assertStatus(200);
        $response->assertSee('Pusat Komunikasi Strategis');
    }
}
