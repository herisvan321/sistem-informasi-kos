<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Listing;
use App\Models\Report;
use App\Models\Transaction;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // CRUD Permissions
        $permissions = [
            'create',
            'read',
            'update',
            'delete',
        ];

        // Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $pemilikKosRole = Role::firstOrCreate(['name' => 'pemilik-kos']);
        $pencariKosRole = Role::firstOrCreate(['name' => 'pencari-kos']);

        foreach ($permissions as $permission) {
            $p = Permission::firstOrCreate(['name' => $permission]);
            $superAdminRole->givePermissionTo($p);
        }

        // Create Super Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@kosapp.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123'),
                'type_user' => 'super-admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('super-admin');

        // 1. Budi Wijaya (Pencari Kos) - Aktif
        $budi = User::updateOrCreate(
            ['email' => 'budi@kosapp.id'],
            [
                'name' => 'Budi Wijaya',
                'password' => Hash::make('password'),
                'type_user' => 'pencari-kos',
                'status' => 'active',
            ]
        );
        $budi->assignRole('pencari-kos');

        // 2. Siti Rahayu (Pemilik Kos) - Pending Verifikasi
        $siti = User::updateOrCreate(
            ['email' => 'siti@kosapp.id'],
            [
                'name' => 'Siti Rahayu',
                'password' => Hash::make('password'),
                'type_user' => 'pemilik-kos',
                'status' => 'pending',
            ]
        );
        $siti->assignRole('pemilik-kos');

        // 3. Dian Pratama (Pencari Kos) - Diblokir
        $dian = User::updateOrCreate(
            ['email' => 'dian@kosapp.id'],
            [
                'name' => 'Dian Pratama',
                'password' => Hash::make('password'),
                'type_user' => 'pencari-kos',
                'status' => 'blocked',
            ]
        );
        $dian->assignRole('pencari-kos');

        // 4. Ahmad Kurniawan (Pemilik Kos) - Aktif (Terverifikasi)
        $ahmad = User::updateOrCreate(
            ['email' => 'ahmad@kosapp.id'],
            [
                'name' => 'Ahmad Kurniawan',
                'password' => Hash::make('password'),
                'type_user' => 'pemilik-kos',
                'status' => 'active',
            ]
        );
        $ahmad->assignRole('pemilik-kos');

        // Mock Listings
        Listing::updateOrCreate(
            ['name' => 'Kos Putri Bu Ani'],
            [
                'address' => 'Jl. Sudirman, Padang',
                'price' => 600000,
                'status' => 'Pending',
                'is_premium' => false,
                'owner_id' => $ahmad->id,
            ]
        );
        Listing::updateOrCreate(
            ['name' => 'Kos Exclusive Permata'],
            [
                'address' => 'Jl. Ahmad Yani, Padang',
                'price' => 1200000,
                'status' => 'Pending',
                'is_premium' => false,
                'owner_id' => $ahmad->id,
            ]
        );
        Listing::updateOrCreate(
            ['name' => 'Kos Mahasiswa Barokah'],
            [
                'address' => 'Jl. Gajah Mada, Padang',
                'price' => 450000,
                'status' => 'Pending',
                'is_premium' => false,
                'owner_id' => $ahmad->id,
            ]
        );
        Listing::updateOrCreate(
            ['name' => 'Kos Indah Makmur'],
            [
                'address' => 'Jl. Khatib Sulaiman, Padang',
                'price' => 800000,
                'status' => 'Approved',
                'is_premium' => false,
                'owner_id' => $ahmad->id,
            ]
        );
        Listing::updateOrCreate(
            ['name' => 'Kos Nyaman Sentosa'],
            [
                'address' => 'Jl. Gajah Mada, Padang',
                'price' => 750000,
                'status' => 'Approved',
                'is_premium' => true,
                'owner_id' => $ahmad->id,
            ]
        );

        // Mock Reports
        Report::updateOrCreate(
            ['title' => 'Ulasan Spam — Kos Nyaman Sentosa'],
            [
                'reporter_id' => $budi->id,
                'status' => 'Pending',
                'type' => 'Spam',
                'description' => 'User ini terus memberikan komentar spam di ulasan.',
            ]
        );

        // Mock Transactions (Revenue)
        Transaction::updateOrCreate(
            ['amount' => 1200000, 'user_id' => $budi->id],
            ['status' => 'Success', 'payment_method' => 'Transfer Bank', 'listing_id' => $ahmad->listings()->first()->id ?? null]
        );
        Transaction::updateOrCreate(
            ['amount' => 800000, 'user_id' => $dian->id],
            ['status' => 'Success', 'payment_method' => 'E-Wallet', 'listing_id' => $ahmad->listings()->skip(1)->first()->id ?? null]
        );
        Transaction::updateOrCreate(
            ['amount' => 450000, 'user_id' => $budi->id],
            ['status' => 'Success', 'payment_method' => 'Transfer Bank', 'listing_id' => $ahmad->listings()->skip(2)->first()->id ?? null]
        );
    }
}
