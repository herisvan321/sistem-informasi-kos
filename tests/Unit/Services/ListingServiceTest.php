<?php

namespace Tests\Unit\Services;

use App\Models\Category;
use App\Models\User;
use App\Services\ListingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ListingServiceTest extends TestCase
{
    use RefreshDatabase;

    private $service;
    private $owner;
    private $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ListingService();
        $this->owner = User::factory()->create();
        $this->category = Category::factory()->create();
    }

    public function test_it_creates_listing_with_photo()
    {
        Storage::fake('public');
        $photo = UploadedFile::fake()->image('kos.png');

        $data = [
            'name' => 'Test Listing Service',
            'category_id' => $this->category->id,
            'address' => 'Jl. Service No. 1',
            'city' => 'Service City',
            'district' => 'Service Dist',
            'price' => 1200000,
            'description' => 'Testing service logic.',
            'main_photo' => $photo
        ];

        $listing = $this->service->createListing($data, $this->owner);

        $this->assertDatabaseHas('listings', [
            'id' => $listing->id,
            'name' => 'Test Listing Service',
            'owner_id' => $this->owner->id
        ]);

        Storage::disk('public')->assertExists($listing->main_photo);
    }

    public function test_it_requests_premium_status()
    {
        Storage::fake('public');
        $proof = UploadedFile::fake()->image('proof.jpg');

        $listing = \App\Models\Listing::factory()->create([
            'owner_id' => $this->owner->id,
            'status' => 'Approved'
        ]);

        $this->service->requestPremium($listing, $proof);

        $this->assertEquals('pending', $listing->fresh()->premium_status);
        $this->assertNotNull($listing->fresh()->premium_payment_proof);
        Storage::disk('public')->assertExists($listing->fresh()->premium_payment_proof);
    }
}
