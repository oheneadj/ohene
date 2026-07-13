<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\User;

it('lets an authenticated admin preview a draft with a preview ribbon', function () {
    $draft = Post::factory()->draft()->create(['title' => 'Unreleased Thoughts', 'slug' => 'unreleased']);

    $this->actingAs(User::factory()->create())
        ->get(route('blog.preview', $draft))
        ->assertOk()
        ->assertSee('Unreleased Thoughts')
        ->assertSee('Preview');
});

it('404s the preview for guests so the URL reveals nothing', function () {
    $draft = Post::factory()->draft()->create(['slug' => 'secret-draft']);

    $this->get(route('blog.preview', $draft))->assertNotFound();
});

it('previews a published post fine too', function () {
    $post = Post::factory()->create(['slug' => 'live-one', 'published_at' => now()->subDay()]);

    $this->actingAs(User::factory()->create())
        ->get(route('blog.preview', $post))
        ->assertOk()
        ->assertSee($post->title);
});
