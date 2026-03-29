<?php

namespace Tests\Feature\PencariKos;

use App\Models\User;
use App\Models\Listing;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'pencari-kos']);
    }

    public function test_pencari_kos_can_add_to_favorite()
    {
        $user = User::factory()->create(['type_user' => 'pencari-kos']);
        $user->assignRole('pencari-kos');

        $listing = Listing::factory()->create(['status' => 'Approved']);

        $response = $this->actingAs($user)->post(route('pencari-kos.favorites.toggle', $listing->id));

        $response->assertStatus(302);
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'listing_id' => $listing->id,
        ]);
    }

    public function test_pencari_kos_can_remove_from_favorite()
    {
        $user = User::factory()->create(['type_user' => 'pencari-kos']);
        $user->assignRole('pencari-kos');

        $listing = Listing::factory()->create(['status' => 'Approved']);
        Favorite::create(['user_id' => $user->id, 'listing_id' => $listing->id]);

        $response = $this->actingAs($user)->post(route('pencari-kos.favorites.toggle', $listing->id));

        $response->assertStatus(302);
        $this->assertSoftDeleted('favorites', [
            'user_id' => $user->id,
            'listing_id' => $listing->id,
        ]);
    }
}
