<?php

namespace Tests\Feature\PemilikKos;

use App\Models\User;
use App\Models\Listing;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    protected $owner;
    protected $listing;

    protected function setUp(): void
    {
        parent::setUp();
        
        Role::create(['name' => 'pemilik-kos']);
        
        $this->owner = User::factory()->create([
            'type_user' => 'Pemilik Kos',
            'status' => 'Active'
        ]);
        $this->owner->assignRole('pemilik-kos');

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

    public function test_owner_can_see_room_index()
    {
        $response = $this->actingAs($this->owner)
                         ->get(route('pemilik-kos.listings.rooms.index', $this->listing->id));

        $response->assertStatus(200);
        $response->assertSee('Manajemen Okupansi Unit');
    }

    public function test_owner_can_add_room()
    {
        $data = [
            'room_number' => 'B1',
            'price' => 600000,
            'status' => 'Available',
            'description' => 'Kamar Baru'
        ];

        $response = $this->actingAs($this->owner)
                         ->from(route('pemilik-kos.listings.rooms.index', $this->listing->id))
                         ->post(route('pemilik-kos.listings.rooms.store', $this->listing->id), $data);

        $response->assertRedirect(route('pemilik-kos.listings.rooms.index', $this->listing->id));
        $this->assertDatabaseHas('rooms', [
            'room_number' => 'B1',
            'listing_id' => $this->listing->id
        ]);
    }

    public function test_owner_can_toggle_room_status()
    {
        $room = Room::create([
            'listing_id' => $this->listing->id,
            'room_number' => 'C1',
            'status' => 'Available'
        ]);

        $response = $this->actingAs($this->owner)
                         ->post(route('pemilik-kos.rooms.toggle-status', $room->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('rooms', [
            'id' => $room->id,
            'status' => 'Full'
        ]);
    }

    public function test_owner_can_update_room()
    {
        $room = Room::create([
            'listing_id' => $this->listing->id,
            'room_number' => 'D1',
            'status' => 'Available',
            'price' => 500000
        ]);

        $data = [
            'room_number' => 'D1-Updated',
            'price' => 550000,
            'status' => 'Full',
            'description' => 'Updated Description'
        ];

        $response = $this->actingAs($this->owner)
                         ->patch(route('pemilik-kos.rooms.update', $room->id), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('rooms', [
            'id' => $room->id,
            'room_number' => 'D1-Updated',
            'price' => 550000,
            'status' => 'Full'
        ]);
    }

    public function test_owner_can_delete_room()
    {
        $room = Room::create([
            'listing_id' => $this->listing->id,
            'room_number' => 'E1',
            'status' => 'Available'
        ]);

        $response = $this->actingAs($this->owner)
                         ->delete(route('pemilik-kos.rooms.destroy', $room->id));

        $response->assertRedirect();
        $this->assertSoftDeleted('rooms', ['id' => $room->id]);
    }
}
