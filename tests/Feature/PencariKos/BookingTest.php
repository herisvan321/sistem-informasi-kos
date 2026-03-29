<?php

namespace Tests\Feature\PencariKos;

use App\Models\User;
use App\Models\Listing;
use App\Models\Room;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'pencari-kos']);
    }

    public function test_pencari_kos_can_create_a_booking()
    {
        $user = User::factory()->create(['type_user' => 'pencari-kos']);
        $user->assignRole('pencari-kos');

        $listing = Listing::factory()->create(['status' => 'Approved']);
        $room = Room::factory()->create(['listing_id' => $listing->id, 'status' => 'Available']);

        $response = $this->actingAs($user)->post(route('pencari-kos.bookings.store', $listing->id), [
            'room_id' => $room->id,
            'check_in_date' => now()->addDays(7)->format('Y-m-d'),
            'duration_months' => 6,
            'notes' => 'Testing booking',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'listing_id' => $listing->id,
            'room_id' => $room->id,
            'status' => 'Pending',
        ]);
    }

    public function test_pencari_kos_can_upload_payment_proof()
    {
        $user = User::factory()->create(['type_user' => 'pencari-kos']);
        $user->assignRole('pencari-kos');

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'status' => 'Pending'
        ]);

        $file = \Illuminate\Http\UploadedFile::fake()->image('proof.jpg');

        $response = $this->actingAs($user)->post(route('pencari-kos.payments.upload', $transaction->id), [
            'payment_proof' => $file,
        ]);

        $response->assertStatus(302);

        $transaction = $transaction->fresh();
        $this->assertNotNull($transaction->payment_proof);
    }
}
