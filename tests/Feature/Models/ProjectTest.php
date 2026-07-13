<?php

declare(strict_types=1);

use App\Models\Project;

it('scopes to featured projects only', function () {
    Project::factory()->featured()->create();
    Project::factory()->count(2)->create(['featured' => false]);

    expect(Project::featured()->count())->toBe(1);
});

it('orders projects by display order', function () {
    Project::factory()->create(['display_order' => 3, 'title' => 'Third']);
    Project::factory()->create(['display_order' => 1, 'title' => 'First']);
    Project::factory()->create(['display_order' => 2, 'title' => 'Second']);

    expect(Project::ordered()->pluck('title')->all())->toBe(['First', 'Second', 'Third']);
});

it('casts the tech stack to an array', function () {
    $project = Project::factory()->create(['tech_stack' => ['Laravel', 'MySQL']]);

    expect($project->tech_stack)->toBe(['Laravel', 'MySQL']);
});
