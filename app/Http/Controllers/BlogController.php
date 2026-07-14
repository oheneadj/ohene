<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

/**
 * Renders the public blog listing and individual posts.
 */
class BlogController extends Controller
{
    /**
     * List published posts, newest first, paginated (FR2).
     */
    public function index(): View
    {
        return view('pages.blog.index', [
            'posts' => Post::query()->published()->with('category')->latest('published_at')->paginate(9),
        ]);
    }

    /**
     * Show a single published post plus a few related posts in the same category.
     */
    public function show(Post $post): View
    {
        abort_unless($post->isPublic(), 404);

        return $this->renderPost($post, preview: false);
    }

    /**
     * Preview any post (including drafts/scheduled) exactly as it will look live.
     * Admin-only: guests get a 404 so the URL reveals nothing (FR9).
     */
    public function preview(Post $post): View
    {
        abort_unless(auth()->check(), 404);

        return $this->renderPost($post, preview: true);
    }

    /**
     * Render the post detail with its related posts, shared by show() and preview().
     */
    private function renderPost(Post $post, bool $preview): View
    {
        if ($preview) {
            $post->loadMissing('category');

            $related = Post::query()
                ->published()
                ->where('category_id', $post->category_id)
                ->whereKeyNot($post->getKey())
                ->latest('published_at')
                ->take(3)
                ->get();

            $related->each(function (Post $item) use ($post) {
                $item->setRelation('category', $post->category);
            });

            $previous = null;
            $next = null;

            if ($post->published_at) {
                $previous = Post::query()
                    ->published()
                    ->where('published_at', '<', $post->published_at)
                    ->latest('published_at')
                    ->first();

                $next = Post::query()
                    ->published()
                    ->where('published_at', '>', $post->published_at)
                    ->oldest('published_at')
                    ->first();
            }

            return view('pages.blog.show', [
                'post' => $post,
                'related' => $related,
                'previous' => $previous,
                'next' => $next,
                'preview' => $preview,
            ]);
        }

        $data = Cache::remember("blog.show.{$post->slug}", now()->addDay(), function () use ($post) {
            $post->loadMissing('category');

            $related = Post::query()
                ->published()
                ->where('category_id', $post->category_id)
                ->whereKeyNot($post->getKey())
                ->latest('published_at')
                ->take(3)
                ->get();

            $related->each(function (Post $item) use ($post) {
                $item->setRelation('category', $post->category);
            });

            $previous = null;
            $next = null;

            if ($post->published_at) {
                $previous = Post::query()
                    ->published()
                    ->where('published_at', '<', $post->published_at)
                    ->latest('published_at')
                    ->first();

                $next = Post::query()
                    ->published()
                    ->where('published_at', '>', $post->published_at)
                    ->oldest('published_at')
                    ->first();
            }

            return [
                'post' => $post,
                'related' => $related,
                'previous' => $previous,
                'next' => $next,
            ];
        });

        return view('pages.blog.show', array_merge($data, [
            'preview' => $preview,
        ]));
    }
}
