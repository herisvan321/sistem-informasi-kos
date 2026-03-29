<?php

namespace Tests\Feature\PencariKos;

use App\Models\User;
use App\Models\Listing;
use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class InquiryConversationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'pencari-kos']);
        Role::firstOrCreate(['name' => 'pemilik-kos']);
    }

    public function test_tenant_can_start_and_continue_conversation()
    {
        $tenant = User::factory()->create(['type_user' => 'pencari-kos']);
        $tenant->assignRole('pencari-kos');

        $owner = User::factory()->create(['type_user' => 'pemilik-kos']);
        $owner->assignRole('pemilik-kos');

        $listing = Listing::factory()->create(['status' => 'Approved', 'owner_id' => $owner->id]);

        // 1. Initial Inquiry (Booking consultation)
        $response = $this->actingAs($tenant)->post(route('pencari-kos.inquiries.store', $listing->id), [
            'message' => 'Halo, apakah kos ini masih tersedia?',
        ]);

        $response->assertRedirect(route('pencari-kos.inquiries.index', ['thread' => $listing->id]));
        $this->assertDatabaseHas('inquiries', [
            'listing_id' => $listing->id,
            'sender_id' => $tenant->id,
            'message' => 'Halo, apakah kos ini masih tersedia?',
        ]);

        // 2. Owner Replies (Manual creation for simulation)
        Inquiry::create([
            'listing_id' => $listing->id,
            'sender_id' => $owner->id,
            'receiver_id' => $tenant->id,
            'message' => 'Iya masih ada, silakan booking.',
            'status' => 'Unread'
        ]);

        // 3. Tenant views conversation (Thread should exist and messages should be marked as read)
        $response = $this->actingAs($tenant)->get(route('pencari-kos.inquiries.index', ['thread' => $listing->id]));
        $response->assertStatus(200);
        $response->assertSee('Iya masih ada, silakan booking.');
        
        // Assert status changed to Read
        $this->assertDatabaseHas('inquiries', [
            'message' => 'Iya masih ada, silakan booking?',
            'status' => 'Read'
        ]);

        // 4. Tenant Responds back within the thread
        $response = $this->actingAs($tenant)->post(route('pencari-kos.inquiries.respond', $listing->id), [
            'message' => 'Terima kasih, saya akan segera booking.',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('inquiries', [
            'listing_id' => $listing->id,
            'sender_id' => $tenant->id,
            'message' => 'Terima kasih, saya akan segera booking.',
        ]);
    }
}
