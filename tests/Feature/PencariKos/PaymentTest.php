<?php

namespace Tests\Feature\PencariKos;

use App\Models\User;
use App\Models\Listing;
use App\Models\Room;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'pencari-kos']);
    }

    public function test_pencari_kos_can_upload_payment_proof()
    {
        Storage::fake('public');

        $user = User::factory()->create(['type_user' => 'pencari-kos']);
        $user->assignRole('pencari-kos');

        $listing = Listing::factory()->create(['status' => 'Approved']);
        $room = Room::factory()->create(['listing_id' => $listing->id, 'status' => 'Available']);
        
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'listing_id' => $listing->id,
            'room_id' => $room->id,
            'amount' => $listing->price,
            'status' => 'Pending',
            'check_in_date' => now()->addDay(),
            'duration_months' => 1,
        ]);

        $file = UploadedFile::fake()->image('payment.jpg');

        $response = $this->actingAs($user)->post(route('pencari-kos.payments.upload', $transaction->id), [
            'payment_proof' => $file,
        ]);

        $response->assertStatus(302);
        
        $transaction->refresh();
        $this->assertNotNull($transaction->payment_proof);
        $this->assertStringEndsWith('.webp', $transaction->payment_proof);
        
        Storage::disk('public')->assertExists($transaction->payment_proof);
    }
}
