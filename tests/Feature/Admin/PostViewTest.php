<?php

declare(strict_types=1);

use App\Filament\Resources\Posts\PostResource;
use App\Models\Post;
use App\Models\User;

it('renders the admin post view page when the body is Tiptap JSON (array)', function () {
    // Real posts authored in the RichEditor store the body as a Tiptap document
    // (array), not a string — the infolist must render it without casting to string.
    $post = Post::factory()->create([
        'body' => [
            'type' => 'doc',
            'content' => [
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => 'Hello from a real post.']]],
            ],
        ],
    ]);

    $this->actingAs(User::factory()->create())
        ->get(PostResource::getUrl('view', ['record' => $post]))
        ->assertSuccessful()
        ->assertSee('Hello from a real post.');
});
