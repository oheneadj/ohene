<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Contracts\View\View;

/**
 * Renders the standalone marketing pages (about, videos, contact).
 */
class PageController extends Controller
{
    /**
     * Show the about page.
     */
    public function about(): View
    {
        return view('pages.about');
    }

    /**
     * Show the video gallery (embeds only — see requirements 5.4).
     */
    public function videos(): View
    {
        return view('pages.videos', [
            'videos' => Video::query()->latest('published_at')->get(),
        ]);
    }

    /**
     * Show the contact page (direct links + next steps; the lead form is Phase 3).
     */
    public function contact(): View
    {
        return view('pages.contact', [
            'testimonials' => \App\Models\Testimonial::query()->with('project')->approved()->latest()->take(4)->get(),
            'faqs' => \App\Models\Faq::query()->active()->orderBy('display_order')->get(),
        ]);
    }

    /**
     * Show the privacy policy (required for GA4 + the cookie-consent banner).
     */
    public function privacy(): View
    {
        return view('pages.privacy');
    }
}
