<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Response;

/**
 * Serves the blog RSS feed at /rss.xml (FR16).
 */
class FeedController extends Controller
{
    /**
     * Render the blog feed of published posts, newest first.
     */
    public function blog(): Response
    {
        $posts = Post::query()->published()->latest('published_at')->take(20)->get();

        // The XML prolog is prepended here so Blade never sees a literal "<?xml".
        $body = '<?xml version="1.0" encoding="UTF-8"?>'."\n".view('feeds.blog', ['posts' => $posts])->render();

        return response($body, 200, ['Content-Type' => 'application/xml']);
    }
}
