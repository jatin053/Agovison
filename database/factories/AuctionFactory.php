<?php

namespace Database\Factories;

use App\Models\Auction;
use App\Models\Crop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Auction>
 */
class AuctionFactory extends Factory
{
    protected $model = Auction::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startsAt = now()->subHours(fake()->numberBetween(1, 6));

        return [
            'crop_id' => Crop::factory(),
            'farmer_id' => User::factory(),
            'winner_id' => null,
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'starting_price' => fake()->randomFloat(2, 800, 2400),
            'reserve_price' => fake()->randomFloat(2, 1600, 3200),
            'bid_increment' => fake()->randomElement([25, 50, 100]),
            'starts_at' => $startsAt,
            'ends_at' => $startsAt->copy()->addHours(fake()->numberBetween(8, 48)),
            'status' => fake()->randomElement(['live', 'scheduled']),
            'meta' => ['source' => 'factory'],
        ];
    }
}
