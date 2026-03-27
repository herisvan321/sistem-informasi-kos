<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'type' => $this->faker->randomElement(['general', 'putra', 'putri', 'campur', 'fasilitas']),
            'description' => $this->faker->sentence,
        ];
    }
}
