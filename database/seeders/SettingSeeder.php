<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'site_name' => 'KosAdmin',
            'app_name' => 'Kos',
            'app_name_suffix' => 'Admin',
            'site_logo' => null,
            'site_favicon' => null,
            'maintenance_mode' => '0',
            'premium_listing_price' => '150000',
        ];

        foreach ($settings as $key => $value) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
