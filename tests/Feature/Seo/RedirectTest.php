<?php

declare(strict_types=1);

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\Project;
use App\Models\Redirect;
use Database\Seeders\LegacyRedirectSeeder;

it('records a redirect and 301s when a published post slug changes', function () {
    $post = Post::factory()->create([
        'slug' => 'old-slug',
        'status' => PostStatus::Published,
        'published_at' => now()->subDay(),
        'meta_description' => 'A description.',
    ]);

    $post->update(['slug' => 'new-slug']);

    expect(Redirect::where('from_path', '/blog/old-slug')->where('to_path', '/blog/new-slug')->exists())->toBeTrue();

    $this->get('/blog/old-slug')
        ->assertStatus(301)
        ->assertRedirect('/blog/new-slug');
});

it('does not record a redirect when a draft slug changes', function () {
    $draft = Post::factory()->draft()->create(['slug' => 'draft-old']);

    $draft->update(['slug' => 'draft-new']);

    expect(Redirect::count())->toBe(0);
});

it('records a redirect when a project slug changes', function () {
    $project = Project::factory()->create(['slug' => 'proj-old']);

    $project->update(['slug' => 'proj-new']);

    expect(Redirect::where('from_path', '/work/proj-old')->exists())->toBeTrue();

    $this->get('/work/proj-old')->assertRedirect('/work/proj-new');
});

it('flattens redirect chains so old paths point to the final destination', function () {
    Redirect::record('/a', '/b');
    Redirect::record('/b', '/c');

    expect(Redirect::where('from_path', '/a')->value('to_path'))->toBe('/c')
        ->and(Redirect::where('from_path', '/b')->value('to_path'))->toBe('/c');
});

it('301s the old static .html URLs to their new routes (MG2)', function () {
    $this->seed(LegacyRedirectSeeder::class);

    $this->get('/work/inkbulksms.html')->assertStatus(301)->assertRedirect('/work/inkbulksms');
    $this->get('/blog/laravel-security-checklist.html')->assertRedirect('/blog/laravel-security-checklist');
    $this->get('/about/index.html')->assertRedirect('/about');
});
