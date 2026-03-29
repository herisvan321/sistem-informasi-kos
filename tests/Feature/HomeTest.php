<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    protected $owner;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->owner = User::factory()->create();
        
        $this->category = Category::create(['name' => 'Apartment', 'slug' => 'apartment']);
        
        Listing::create([
            'owner_id' => $this->owner->id,
            'category_id' => $this->category->id,
            'name' => 'Luxury Apartment Padang',
            'city' => 'Padang',
            'district' => 'Padang Utara',
            'address' => 'Jl. Khatib Sulaiman',
            'price' => 5000000,
            'status' => 'Approved',
            'is_premium' => true
        ]);

        Listing::create([
            'owner_id' => $this->owner->id,
            'name' => 'Kos Murah Jakarta',
            'city' => 'Jakarta',
            'district' => 'Tebet',
            'address' => 'Jl. Tebet Raya',
            'price' => 1500000,
            'status' => 'Approved',
            'is_premium' => false
        ]);
    }

    public function test_home_page_is_accessible()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Temukan');
        $response->assertSee('Kenyamanan');
    }

    public function test_user_can_search_by_location()
    {
        $response = $this->get('/?location=Padang');

        $response->assertStatus(200);
        $response->assertSee('Luxury Apartment Padang');
        $response->assertDontSee('Kos Murah Jakarta');
    }

    public function test_user_can_filter_by_category()
    {
        $response = $this->get('/?category_id=' . $this->category->id);

        $response->assertStatus(200);
        $response->assertSee('Luxury Apartment Padang');
        $response->assertDontSee('Kos Murah Jakarta');
    }
}
