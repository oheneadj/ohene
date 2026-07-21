<?php

declare(strict_types=1);

use App\Enums\PostStatus;
use App\Exceptions\PostNotPublishableException;
use App\Models\Post;

it('only treats published, past-dated posts as published', function () {
    Post::factory()->create(['status' => PostStatus::Published, 'published_at' => now()->subDay()]);
    Post::factory()->draft()->create();
    Post::factory()->create(['status' => PostStatus::Scheduled, 'published_at' => now()->addWeek()]);
    Post::factory()->create(['status' => PostStatus::Published, 'published_at' => now()->addDay()]);

    expect(Post::published()->count())->toBe(1);
});

it('auto-calculates read time from the body word count on save', function () {
    $post = Post::factory()->create([
        'body' => str_repeat('word ', 400), // 400 words ~ 2 minutes
    ]);

    expect($post->read_time)->toBe(2);
});

it('never falls below a one-minute read time', function () {
    $post = Post::factory()->create(['body' => 'short body']);

    expect($post->read_time)->toBe(1);
});

it('falls back to the cover image for the OG image', function () {
    $post = Post::factory()->create(['cover_image' => 'covers/a.jpg', 'og_image' => null]);

    expect($post->ogImage())->toBe('covers/a.jpg');

    $post->og_image = 'og/b.jpg';
    expect($post->ogImage())->toBe('og/b.jpg');
});

it('routes publicly by slug while still carrying a ULID', function () {
    $post = Post::factory()->create();

    // HasPublicUlid keeps the model's route key as 'ulid' for Filament admin routes.
    // Public blog routes use explicit {post:slug} binding in web.php — a separate concern.
    expect($post->getRouteKeyName())->toBe('ulid')
        ->and($post->ulid)->toHaveLength(26)
        ->and($post->slug)->not->toBeEmpty();

    // The public blog.show route resolves by slug via explicit binding.
    $response = $this->get(route('blog.show', $post));
    $response->assertOk();
});

it('blocks publishing without a meta description', function () {
    Post::factory()->create(['status' => PostStatus::Published, 'meta_description' => null]);
})->throws(PostNotPublishableException::class);

it('blocks publishing a cover image that has no alt text', function () {
    Post::factory()->create([
        'status' => PostStatus::Published,
        'cover_image' => 'covers/a.jpg',
        'cover_image_alt' => null,
    ]);
})->throws(PostNotPublishableException::class);

it('allows publishing when the content gate is satisfied', function () {
    $post = Post::factory()->create([
        'status' => PostStatus::Published,
        'meta_description' => 'A complete description.',
        'cover_image' => 'covers/a.jpg',
        'cover_image_alt' => 'Descriptive alt text',
    ]);

    expect($post->status)->toBe(PostStatus::Published);
});

it('lets drafts skip the publish gate', function () {
    $post = Post::factory()->draft()->create(['meta_description' => null]);

    expect($post->status)->toBe(PostStatus::Draft);
});
