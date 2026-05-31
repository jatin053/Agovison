<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Vegetables',
            'Fruits',
            'Grains',
            'Herbs',
            'Organic Produce',
            'Spices',
            'Seeds',
            'Leafy Greens',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'icon' => fake()->randomElement(['fa-leaf', 'fa-seedling', 'fa-carrot', 'fa-wheat-awn']),
            'image' => null,
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
