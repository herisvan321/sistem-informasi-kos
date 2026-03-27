<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ListingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'owner_id' => User::factory(), // Will be overridden or create user
            'name' => $this->faker->words(3, true),
            'address' => $this->faker->address,
            'price' => $this->faker->randomElement([450000, 600000, 800000, 1200000, 1500000]),
            'status' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']),
            'is_premium' => $this->faker->boolean(20),
        ];
    }
}
