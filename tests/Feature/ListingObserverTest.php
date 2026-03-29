<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ListingObserverTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
    }

    public function test_listing_generates_uuid_on_creation()
    {
        $listing = Listing::create([
            'owner_id' => $this->user->id,
            'category_id' => $this->category->id,
            'name' => 'Premium Boarding House',
            'description' => 'A wonderful place to stay.',
            'price' => 1500000,
            'address' => 'Jl. Merdeka No. 123',
            'status' => 'Pending',
        ]);

        $this->assertNotNull($listing->id);
        $this->assertTrue(Str::isUuid($listing->id));
    }

    public function test_listing_generates_slug_on_creation()
    {
        $listing = Listing::create([
            'owner_id' => $this->user->id,
            'category_id' => $this->category->id,
            'name' => 'Griya Asri Mentari',
            'description' => 'Comfortable stay.',
            'price' => 2000000,
            'address' => 'Jakarta Selatan',
            'status' => 'Pending',
        ]);

        $this->assertStringContainsString('griya-asri-mentari', $listing->slug);
    }

    public function test_listing_updates_slug_when_name_changes()
    {
        $listing = Listing::create([
            'owner_id' => $this->user->id,
            'category_id' => $this->category->id,
            'name' => 'Old House Name',
            'description' => 'Test house.',
            'price' => 1000000,
            'address' => 'Address Test',
            'status' => 'Pending',
        ]);

        $this->assertStringContainsString('old-house-name', $listing->slug);

        $listing->update(['name' => 'Modern Luxury Suite']);
        
        $this->assertStringContainsString('modern-luxury-suite', $listing->fresh()->slug);
    }
}
