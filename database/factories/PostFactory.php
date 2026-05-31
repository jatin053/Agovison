<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(4),
            'body' => fake()->paragraph(3),
            'image_path' => null,
            'location' => fake()->city(),
            'visibility' => 'public',
            'tags' => fake()->randomElements(['soil', 'market', 'disease', 'irrigation', 'organic'], fake()->numberBetween(1, 3)),
            'meta' => ['source' => 'factory'],
        ];
    }
}
