<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Listing;
use App\Models\Room;
use App\Models\Inquiry;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OwnerDataSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data to avoid confusion
        // Transaction::truncate();
        // Inquiry::truncate();
        // Room::truncate();
        // Listing::truncate();

        // 1. Create the Premium Owner Account
        $owner = User::updateOrCreate(
            ['email' => 'owner@premium.com'],
            [
                'id' => Str::uuid(),
                'name' => 'Hendri Properti',
                'password' => Hash::make('password'),
                'type_user' => 'Pemilik Kos',
                'status' => 'Active',
            ]
        );
        $owner->assignRole('pemilik-kos');

        // 2. Create some Tenant Users
        $tenants = [];
        $names = ['Budi', 'Siti', 'Agus', 'Dewi', 'Rian'];
        foreach ($names as $name) {
            $tenant = User::updateOrCreate(
                ['email' => strtolower($name) . '@example.com'],
                [
                    'id' => Str::uuid(),
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'type_user' => 'Pencari Kos',
                    'status' => 'Active',
                ]
            );
            $tenant->assignRole('pencari-kos');
            $tenants[] = $tenant;
        }

        // 3. Create Multiple Listings for Owner
        $properties = [
            [
                'name' => 'Kos Exclusive Mentari',
                'city' => 'Padang',
                'district' => 'Padang Timur',
                'address' => 'Jl. Mentari No. 45, Padang Timur',
                'price' => 1500000,
                'description' => 'Kos eksklusif dengan fasilitas lengkap, keamanan 24 jam, dan parkir luas.',
                'facilities' => ['WiFi', 'AC', 'Kamar Mandi Dalam', 'CCTV', 'Parkir Motor'],
            ],
            [
                'name' => 'Wisma Cempaka Biru',
                'city' => 'Padang',
                'district' => 'Padang Barat',
                'address' => 'Jl. Cempaka No. 12, Padang Barat',
                'price' => 1200000,
                'description' => 'Wisma nyaman untuk mahasiswa dan karyawan, dekat dengan pusat kota.',
                'facilities' => ['WiFi', 'Kamar Mandi Dalam', 'Lemari', 'Kasur'],
            ],
            [
                'name' => 'Kos Putri Anggrek',
                'city' => 'Padang',
                'district' => 'Kuranji',
                'address' => 'Jl. Anggrek Raya No. 8, Kuranji',
                'price' => 800000,
                'description' => 'Kos khusus putri dengan lingkungan yang tenang dan asri.',
                'facilities' => ['WiFi', 'Dapur Umum', 'Parkir Motor', 'Laundry'],
            ],
        ];

        foreach ($properties as $prop) {
            $listing = Listing::create([
                'id' => Str::uuid(),
                'owner_id' => $owner->id, // Correct column
                'name' => $prop['name'],
                'city' => $prop['city'],
                'district' => $prop['district'],
                'address' => $prop['address'],
                'price' => $prop['price'],
                'description' => $prop['description'],
                'facilities' => $prop['facilities'],
                'status' => 'Approved',
            ]);

            // 4. Create Rooms
            for ($i = 1; $i <= 5; $i++) {
                Room::create([
                    'id' => Str::uuid(),
                    'listing_id' => $listing->id,
                    'room_number' => substr($listing->name, 0, 1) . $i,
                    'price' => null,
                    'status' => $i % 3 == 0 ? 'Full' : 'Available',
                    'description' => 'Kamar standar nomor ' . $i,
                ]);
            }

            // 5. Create Inquiries
            foreach ($tenants as $index => $tenant) {
                if ($index % 2 == 0) {
                    Inquiry::create([
                        'id' => Str::uuid(),
                        'listing_id' => $listing->id,
                        'sender_id' => $tenant->id, // Correct column
                        'receiver_id' => $owner->id, // Correct column
                        'message' => 'Halo Pak ' . $owner->name . ', saya tertarik dengan ' . $listing->name . '. Apakah kamar masih ada?',
                        'status' => $index == 0 ? 'Unread' : 'Read',
                    ]);
                }
            }

            // 6. Create Transactions
            foreach ($tenants as $index => $tenant) {
                if ($index % 3 == 0) {
                    Transaction::create([
                        'id' => Str::uuid(),
                        'listing_id' => $listing->id,
                        'user_id' => $tenant->id,
                        'amount' => $listing->price,
                        'payment_method' => 'Bank Transfer',
                        'status' => 'Success',
                        'created_at' => now()->subDays(rand(1, 30)),
                    ]);
                }
            }
        }
    }
}
