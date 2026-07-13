<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->word();

        return [
            'title' => ucfirst($title),
            'slug' => str($title)->slug()->value(),
            'tagline' => fake()->sentence(8),
            'challenge' => fake()->paragraph(),
            'build' => fake()->paragraph(),
            'impact' => fake()->paragraph(),
            'tech_stack' => fake()->randomElements(['Laravel', 'PHP', 'MySQL', 'Vue.js', 'React', 'Tailwind'], 3),
            'cover_image' => null,
            'cover_image_alt' => fake()->sentence(4),
            'live_url' => fake()->url(),
            'repo_url' => null,
            'featured' => false,
            'display_order' => fake()->numberBetween(0, 20),
            'meta_title' => null,
            'meta_description' => fake()->sentence(12),
            'og_image' => null,
        ];
    }

    /**
     * A project featured on the Home page.
     */
    public function featured(): static
    {
        return $this->state(fn (): array => ['featured' => true]);
    }
}
