<?php

namespace Database\Factories;

use App\Models\Crop;
use App\Models\SoilReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SoilReport>
 */
class SoilReportFactory extends Factory
{
    protected $model = SoilReport::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'crop_id' => Crop::factory(),
            'soil_type' => fake()->randomElement(['loamy', 'clay', 'sandy', 'black']),
            'season' => fake()->randomElement(['kharif', 'rabi', 'zaid']),
            'ph' => fake()->randomFloat(2, 5.8, 7.8),
            'nitrogen' => fake()->randomFloat(2, 18, 58),
            'phosphorus' => fake()->randomFloat(2, 8, 24),
            'potassium' => fake()->randomFloat(2, 24, 52),
            'moisture_percentage' => fake()->randomFloat(2, 28, 82),
            'water_level_percentage' => fake()->randomFloat(2, 24, 88),
            'field_size' => fake()->randomFloat(2, 0.8, 12),
            'recommendations' => fake()->sentence(),
            'logged_at' => now(),
            'meta' => ['source' => 'factory'],
        ];
    }
}
