<?php

declare(strict_types=1);

use App\Enums\PostStatus;
use App\Models\Post;
use App\RichEditor\YouTubeEmbedBlock;
use Filament\Forms\Components\RichEditor\RichContentRenderer;

// Cover image — save behaviour fix (regression guard)

it('persists cover_image after saving a post with one', function () {
    $post = Post::factory()->create([
        'slug' => 'test-cover-save',
        'cover_image' => 'posts/test.jpg',
        'cover_image_alt' => 'Test image',
        'status' => PostStatus::Draft,
    ]);

    // Reload from DB — confirms the value wasn't overwritten to null on save
    expect($post->fresh()->cover_image)->toBe('posts/test.jpg');
});

it('allows cover_image to be cleared without affecting og_image independently set', function () {
    $post = Post::factory()->create([
        'slug' => 'test-og-independence',
        'cover_image' => 'posts/cover.jpg',
        'cover_image_alt' => 'Cover',
        'og_image' => 'posts/og/custom.jpg',
        'status' => PostStatus::Draft,
    ]);

    $post->update(['cover_image' => null, 'cover_image_alt' => null]);

    expect($post->fresh())
        ->cover_image->toBeNull()
        ->og_image->toBe('posts/og/custom.jpg');
});

it('falls back to cover_image for ogImage() when og_image is null', function () {
    $post = Post::factory()->create([
        'slug' => 'test-og-fallback',
        'cover_image' => 'posts/cover.jpg',
        'cover_image_alt' => 'Cover',
        'og_image' => null,
        'status' => PostStatus::Draft,
    ]);

    expect($post->ogImage())->toBe('posts/cover.jpg');
});

// YouTube embed — frontend rendering

it('renders a youtube embed iframe on the blog post page', function () {
    $body = '<div data-type="customBlock" data-id="youtube-embed" data-config="{&quot;url&quot;:&quot;https://youtu.be/dQw4w9WgXcQ&quot;}"></div>';

    $post = Post::factory()->create([
        'slug' => 'post-with-youtube',
        'body' => $body,
        'status' => PostStatus::Published,
        'published_at' => now()->subDay(),
    ]);

    $this->get(route('blog.show', $post))
        ->assertOk()
        ->assertSee('iframe', escape: false)
        ->assertSee('dQw4w9WgXcQ', escape: false);
});

it('renders normal post body content without youtube blocks unchanged', function () {
    $post = Post::factory()->create([
        'slug' => 'post-no-youtube',
        'body' => '<p>Hello world</p>',
        'status' => PostStatus::Published,
        'published_at' => now()->subDay(),
    ]);

    $this->get(route('blog.show', $post))
        ->assertOk()
        ->assertSee('Hello world');
});

// RichContentRenderer integration

it('resolves a youtube custom block marker into an iframe via the renderer', function () {
    $body = '<div data-type="customBlock" data-id="youtube-embed" data-config="{&quot;url&quot;:&quot;https://youtu.be/dQw4w9WgXcQ&quot;}"></div>';

    $html = RichContentRenderer::make($body)
        ->customBlocks([YouTubeEmbedBlock::class])
        ->toUnsafeHtml();

    expect($html)
        ->toContain('iframe')
        ->toContain('dQw4w9WgXcQ');
});

it('leaves normal html untouched when no custom block markers are present', function () {
    $html = RichContentRenderer::make('<p>Just a paragraph</p>')
        ->customBlocks([YouTubeEmbedBlock::class])
        ->toUnsafeHtml();

    expect($html)->toContain('Just a paragraph');
});
