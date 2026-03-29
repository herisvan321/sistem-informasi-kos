<?php

namespace Tests\Feature\PencariKos;

use App\Models\User;
use App\Models\Listing;
use App\Models\Room;
use App\Models\Transaction;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'pencari-kos']);
    }

    public function test_pencari_kos_can_submit_review()
    {
        $user = User::factory()->create(['type_user' => 'pencari-kos']);
        $user->assignRole('pencari-kos');

        $listing = Listing::factory()->create(['status' => 'Approved']);
        $room = Room::factory()->create(['listing_id' => $listing->id, 'status' => 'Occupied']);
        
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'listing_id' => $listing->id,
            'room_id' => $room->id,
            'amount' => $listing->price,
            'status' => 'Paid',
            'check_in_date' => now()->subDay(),
            'duration_months' => 1,
        ]);

        $response = $this->actingAs($user)->post(route('pencari-kos.reviews.store', $transaction->id), [
            'rating' => 5,
            'comment' => 'Kos mantap jiwa bosku!',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'listing_id' => $listing->id,
            'rating' => 5,
            'comment' => 'Kos mantap jiwa bosku!',
        ]);
    }
}
