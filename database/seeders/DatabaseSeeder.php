<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RolePermissionSeeder::class,
            SettingSeeder::class,
        ]);

        // Seed Users
        $seekers = User::factory(20)->create()->each(function ($u) {
            $u->assignRole('pencari-kos');
        });
        
        $owners = User::factory(10)->create()->each(function ($u) {
            $u->assignRole('pemilik-kos');
        });

        // Seed Listings for owners
        foreach ($owners as $owner) {
            \App\Models\Listing::factory(rand(1, 3))->create(['owner_id' => $owner->id]);
        }

        // Seed Reports
        \App\Models\Report::factory(15)->create();

        // Seed Categories
        \App\Models\Category::factory(5)->create();
    }
}
