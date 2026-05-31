<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Crop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Crop>
 */
class CropFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->randomElement([
            'Premium Tomatoes',
            'Organic Potatoes',
            'Fresh Onions',
            'Green Chillies',
            'Hybrid Corn',
            'Golden Wheat',
            'Farm Mangoes',
            'Natural Spinach',
        ]).' '.fake()->numberBetween(1, 99);
        $price = fake()->randomFloat(2, 20, 500);
        $salePrice = fake()->boolean(30) ? fake()->randomFloat(2, 15, $price) : null;

        return [
            'user_id' => User::factory()->farmer(),
            'category_id' => Category::factory(),
            'approved_by' => null,
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(100, 999),
            'sku' => strtoupper(fake()->bothify('AGR-###??')),
            'short_description' => fake()->sentence(),
            'description' => fake()->paragraph(3),
            'price' => $price,
            'sale_price' => $salePrice,
            'stock' => fake()->numberBetween(20, 500),
            'unit' => fake()->randomElement(['kg', 'quintal', 'ton']),
            'location' => fake()->city(),
            'harvest_date' => fake()->dateTimeBetween('-30 days', '+60 days'),
            'organic' => fake()->boolean(40),
            'is_featured' => fake()->boolean(20),
            'views' => fake()->numberBetween(20, 1500),
            'status' => 'approved',
            'approved_at' => now(),
            'meta' => [
                'grade' => fake()->randomElement(['A', 'A+', 'Premium']),
                'packaging' => fake()->randomElement(['Bag', 'Crate', 'Box']),
            ],
        ];
    }
}
