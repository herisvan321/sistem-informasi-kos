<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Listing;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'listing_id' => Listing::factory(),
            'room_id' => Room::factory(),
            'amount' => $this->faker->numberBetween(500000, 2000000),
            'status' => 'Pending',
            'payment_method' => 'Transfer Bank',
            'check_in_date' => $this->faker->date(),
            'duration_months' => 1,
        ];
    }
}
