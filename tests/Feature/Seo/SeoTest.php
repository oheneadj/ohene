<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\Project;

it('serves a sitemap with published content and excludes drafts', function () {
    $project = Project::factory()->create(['slug' => 'shipped']);
    $post = Post::factory()->create(['slug' => 'live-post', 'published_at' => now()->subDay()]);
    Post::factory()->draft()->create(['slug' => 'hidden-draft']);

    $response = $this->get('/sitemap.xml');

    $response->assertOk();
    expect($response->headers->get('Content-Type'))->toContain('xml');
    $response->assertSee(route('home'), false)
        ->assertSee(route('work.show', $project), false)
        ->assertSee(route('blog.show', $post), false)
        ->assertDontSee('/blog/hidden-draft', false);
});

it('serves an RSS feed of published posts only', function () {
    Post::factory()->create(['title' => 'Feed Post', 'slug' => 'feed-post', 'published_at' => now()->subDay()]);
    Post::factory()->draft()->create(['title' => 'Draft Post', 'slug' => 'draft-post']);

    $response = $this->get('/rss.xml');

    $response->assertOk();
    expect($response->headers->get('Content-Type'))->toContain('xml');
    $response->assertSee('Feed Post', false)
        ->assertDontSee('Draft Post', false);
});

it('renders Person and ProfessionalService JSON-LD on the home page', function () {
    $this->get(route('home'))
        ->assertSee('application/ld+json', false)
        ->assertSee('ProfessionalService', false);
});

it('renders BlogPosting JSON-LD on a post page', function () {
    $post = Post::factory()->create(['slug' => 'jsonld-post', 'published_at' => now()->subDay()]);

    $this->get(route('blog.show', $post))->assertSee('BlogPosting', false);
});

it('ships a robots.txt that points at the sitemap', function () {
    $robots = file_get_contents(public_path('robots.txt'));

    expect($robots)->toContain('Sitemap:')->toContain('sitemap.xml');
});
