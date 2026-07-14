<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Post;
use App\Models\Project;
use App\Models\Setting;
use Database\Seeders\BlogSeeder;
use Database\Seeders\ProjectSeeder;
use Database\Seeders\SettingSeeder;

it('seeds the existing case studies', function () {
    $this->seed(ProjectSeeder::class);

    expect(Project::count())->toBe(11)
        ->and(Project::whereSlug('inkbulksms')->exists())->toBeTrue();
});

it('seeds the blog posts and their categories', function () {
    $this->seed(BlogSeeder::class);

    expect(Post::count())->toBe(5)
        ->and(Category::count())->toBeGreaterThan(1)
        ->and(Post::whereSlug('laravel-security-checklist')->first()->category->name)->toBe('Security');
});

it('seeds the availability toggle setting', function () {
    $this->seed(SettingSeeder::class);

    expect(Setting::get('available_for_projects'))->toBe('1');
});

it('is idempotent — reseeding does not duplicate content', function () {
    $this->seed(ProjectSeeder::class);
    $this->seed(ProjectSeeder::class);

    expect(Project::count())->toBe(11);
});
