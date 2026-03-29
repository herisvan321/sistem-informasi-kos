<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Listing;
use App\Models\Favorite;
use App\Models\Transaction;
use App\Models\Room;
use Illuminate\Support\Facades\Hash;

class PencariKosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or Create a Pencari Kos user
        $pencari = User::where('email', 'pencari@kosapp.id')->first();
        if (!$pencari) {
            $pencari = User::create([
                'name' => 'Rizky Pratama',
                'email' => 'pencari@kosapp.id',
                'password' => Hash::make('password'),
                'type_user' => 'pencari-kos',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
            $pencari->assignRole('pencari-kos');
        }

        // Get some approved listings
        $listings = Listing::where('status', 'Approved')->take(3)->get();

        if ($listings->isNotEmpty()) {
            $listings->first()->update(['is_premium' => true]);
        }

        foreach ($listings as $listing) {
            // Add to favorites
            Favorite::firstOrCreate([
                'user_id' => $pencari->id,
                'listing_id' => $listing->id,
            ]);

            // Create a mock transaction/booking
            $room = $listing->rooms()->first();
            if ($room) {
                Transaction::updateOrCreate(
                    [
                        'user_id' => $pencari->id,
                        'listing_id' => $listing->id,
                        'room_id' => $room->id,
                    ],
                    [
                        'amount' => $listing->price,
                        'status' => 'Pending',
                        'payment_method' => 'Transfer Bank',
                        'check_in_date' => now()->addDays(7)->format('Y-m-d'),
                        'duration_months' => 1,
                        'notes' => 'Tolong konfirmasi segera ya bos.',
                    ]
                );
            }
        }
    }
}
