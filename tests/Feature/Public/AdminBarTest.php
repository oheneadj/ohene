<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\User;

it('does not show the admin bar to guests', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertDontSee('Log Out')
        ->assertDontSee('Dashboard')
        ->assertDontSee('New Post');
});

it('shows the admin bar to authenticated users', function () {
    $user = User::factory()->create(['name' => 'Ohene Admin']);

    $this->actingAs($user)
        ->get(route('home'))
        ->assertOk()
        ->assertSee('Dashboard')
        ->assertSee('New Post')
        ->assertSee('Log Out')
        ->assertSee('Howdy, Ohene');
});

it('shows the edit post link when viewing a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $this->actingAs($user)
        ->get(route('blog.show', $post))
        ->assertOk()
        ->assertSee('Edit Post')
        ->assertSee('/admin/posts/'.$post->ulid.'/edit');
});
