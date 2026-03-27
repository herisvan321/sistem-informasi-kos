<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->sentence(10),
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
