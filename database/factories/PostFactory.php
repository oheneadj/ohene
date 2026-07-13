<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(5);

        return [
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => str($title)->slug()->value(),
            'excerpt' => fake()->sentence(15),
            'body' => fake()->paragraphs(4, true),
            'cover_image' => null,
            'cover_image_alt' => fake()->sentence(4),
            'read_time' => fake()->numberBetween(3, 10),
            'status' => PostStatus::Published,
            'published_at' => fake()->dateTimeBetween('-1 year'),
            'meta_title' => null,
            'meta_description' => fake()->sentence(12),
            'og_image' => null,
        ];
    }

    /**
     * A draft post that must not appear on the public site.
     */
    public function draft(): static
    {
        return $this->state(fn (): array => [
            'status' => PostStatus::Draft,
            'published_at' => null,
        ]);
    }
}
