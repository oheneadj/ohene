<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\BudgetRange;
use App\Enums\LeadStatus;
use App\Enums\ProjectType;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'message' => fake()->paragraph(),
            'project_type' => fake()->randomElement(ProjectType::cases()),
            'budget_range' => fake()->randomElement(BudgetRange::cases()),
            'utm_source' => fake()->optional()->randomElement(['google', 'linkedin', 'twitter']),
            'utm_medium' => fake()->optional()->randomElement(['organic', 'referral', 'social']),
            'utm_campaign' => null,
            'referrer' => fake()->optional()->url(),
            'status' => LeadStatus::New,
        ];
    }
}
