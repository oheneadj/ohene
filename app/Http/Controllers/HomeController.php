<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;

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
        return view('pages.home', [
            'projects' => Project::query()->featured()->ordered()->take(3)->get(),
            'posts' => Post::query()->with('category')->published()->latest('published_at')->take(3)->get(),
            'videos' => \App\Models\Video::query()->latest('published_at')->take(3)->get(),
            'testimonials' => Testimonial::query()->approved()->latest()->take(2)->get(),
            'available' => Setting::get('available_for_projects') === '1',
        ]);
    }
}
