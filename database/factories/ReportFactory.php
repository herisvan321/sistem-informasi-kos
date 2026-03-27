<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'reporter_id' => User::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(['Spam', 'Inappropriate', 'Suspicious']),
            'status' => $this->faker->randomElement(['Pending', 'Resolved']),
            'listing_id' => \App\Models\Listing::factory(),
        ];
    }
}
