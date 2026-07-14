<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Video;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

/**
 * Renders the marketing home page — the site's primary pitch and previews.
 */
class HomeController extends Controller
{
    /**
     * Show the home page with featured work, latest posts and testimonials.
     */
    public function index(): View
    {
        $projects = Cache::remember('home.featured_projects', now()->addDay(), function () {
            return Project::query()->featured()->ordered()->take(3)->get();
        });

        $posts = Cache::remember('home.latest_posts', now()->addDay(), function () {
            return Post::query()->with('category')->published()->latest('published_at')->take(3)->get();
        });

        $videos = Cache::remember('home.latest_videos', now()->addDay(), function () {
            return Video::query()->featured()->latest('published_at')->take(3)->get();
        });

        return view('pages.home', [
            'projects' => $projects,
            'posts' => $posts,
            'videos' => $videos,
            'available' => Setting::get('available_for_projects') === '1',
        ]);
    }
}
