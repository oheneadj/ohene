<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\TestimonialStatus;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => null,
            'client_name' => fake()->name(),
            'role' => fake()->jobTitle(),
            'company' => fake()->company(),
            'quote' => fake()->paragraph(),
            'avatar' => null,
            'status' => TestimonialStatus::Pending,
        ];
    }

    /**
     * An approved testimonial that may be shown publicly.
     */
    public function approved(): static
    {
        return $this->state(fn (): array => ['status' => TestimonialStatus::Approved]);
    }
}
