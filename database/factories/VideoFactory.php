<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'youtube_video_id' => fake()->regexify('[A-Za-z0-9_-]{11}'),
            'is_featured' => fake()->boolean(20),
            'description' => fake()->paragraph(),
            'published_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
