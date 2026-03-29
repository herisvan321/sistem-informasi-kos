<?php

namespace Tests\Feature\PemilikKos;

use App\Models\User;
use App\Models\Listing;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    protected $owner;
    protected $tenant;
    protected $listing;

    protected function setUp(): void
    {
        parent::setUp();
        
        Role::create(['name' => 'pemilik-kos']);
        Role::create(['name' => 'pencari-kos']);
        
        $this->owner = User::factory()->create(['type_user' => 'Pemilik Kos', 'status' => 'Active']);
        $this->owner->assignRole('pemilik-kos');

        $this->tenant = User::factory()->create(['type_user' => 'Pencari Kos', 'status' => 'Active']);
        $this->tenant->assignRole('pencari-kos');

        $this->listing = Listing::create([
            'owner_id' => $this->owner->id,
            'name' => 'Kos Test',
            'address' => 'Jl. Test',
            'city' => 'Padang',
            'district' => 'Padang Timur',
            'price' => 500000,
            'description' => 'Deskripsi test'
        ]);
    }

    public function test_owner_can_see_transaction_index()
    {
        $response = $this->actingAs($this->owner)
                         ->get(route('pemilik-kos.transactions.index'));

        $response->assertStatus(200);
        $response->assertSee('Laporan Finansial & Arus Kas', false);
    }

    public function test_owner_can_see_transaction_detail()
    {
        $transaction = Transaction::create([
            'listing_id' => $this->listing->id,
            'user_id' => $this->tenant->id,
            'amount' => 500000,
            'status' => 'Success',
            'payment_method' => 'Transfer Bank'
        ]);

        $response = $this->actingAs($this->owner)
                         ->get(route('pemilik-kos.transactions.show', $transaction->id));

        $response->assertStatus(200);
        $response->assertSee('#' . strtoupper(substr($transaction->id, 0, 8)));
    }
}
