<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Seeds the two existing blog posts and their categories from the static site
 * (requirements MG1). Keyed by slug so re-running never duplicates rows.
 */
class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $security = Category::query()->updateOrCreate(
            ['slug' => 'security'],
            ['name' => 'Security'],
        );

        $performance = Category::query()->updateOrCreate(
            ['slug' => 'performance'],
            ['name' => 'Performance'],
        );

        $posts = [
            [
                'category_id' => $security->id,
                'title' => 'A Practical Laravel Security Checklist Before You Launch',
                'slug' => 'laravel-security-checklist',
                'excerpt' => 'A practical, field-tested checklist for securing a Laravel application before launch — environment config, input validation, auth, HTTPS, and monitoring.',
                'body' => $this->laravelSecurityBody(),
                'read_time' => 6,
                'status' => PostStatus::Published,
                'published_at' => Carbon::parse('2026-07-05'),
                'meta_description' => 'A practical, field-tested checklist for securing a Laravel application before launch — environment config, input validation, auth, HTTPS, and monitoring.',
            ],
            [
                'category_id' => $performance->id,
                'title' => 'Why Your WordPress Site Is Slow (And How I\'d Fix It)',
                'slug' => 'wordpress-speed-optimization',
                'excerpt' => 'The most common causes of slow WordPress sites — from bloated plugins to unoptimized images — and the fixes that make the biggest difference.',
                'body' => $this->wordpressSpeedBody(),
                'read_time' => 5,
                'status' => PostStatus::Published,
                'published_at' => Carbon::parse('2026-07-05'),
                'meta_description' => 'The most common causes of slow WordPress sites — from bloated plugins to unoptimized images — and the fixes that make the biggest difference.',
            ],
        ];

        foreach ($posts as $post) {
            Post::query()->updateOrCreate(['slug' => $post['slug']], $post);
        }
    }

    /**
     * Rich-text body (safe HTML subset) for the Laravel security post.
     */
    private function laravelSecurityBody(): string
    {
        return <<<'HTML'
        <p>Over the past few years patching security issues on live client sites, I've noticed the same handful of gaps show up again and again — almost never anything exotic, usually just a default left unchanged or a check skipped under deadline pressure. This is the checklist I run through before any Laravel app goes live.</p>
        <h2>1. Lock down your environment file</h2>
        <p>Your <code>.env</code> file should never be reachable from the browser and should never be committed to version control. Confirm <code>APP_DEBUG</code> is set to false in production — a stray stack trace on a live error page can hand an attacker your database credentials and file paths without them lifting a finger.</p>
        <h2>2. Validate and sanitize every input</h2>
        <p>Laravel's form request validation makes this easy to get right, so there's rarely a good excuse to skip it. Validate on the way in, and use Eloquent or query bindings rather than raw queries to avoid SQL injection. Escape output in Blade templates by default, and be deliberate about the rare cases where you use unescaped output.</p>
        <h2>3. Keep dependencies current</h2>
        <p>Run <code>composer audit</code> regularly and subscribe to security advisories for any packages handling authentication, payments, or file uploads. A surprising number of the vulnerabilities I've patched traced back to an outdated package rather than custom code.</p>
        <h2>4. Harden authentication and sessions</h2>
        <p>Use Laravel's built-in hashing (bcrypt or argon2) — never roll your own. Set sensible session lifetimes, enable HTTPS-only cookies, and add rate limiting to login and password-reset routes so they can't be brute-forced.</p>
        <h2>5. Enforce HTTPS and security headers</h2>
        <p>Force HTTPS in production and add headers like Content-Security-Policy, X-Frame-Options, and X-Content-Type-Options. These are a few lines of middleware that close off a surprising number of common attack vectors.</p>
        <h2>6. Apply least-privilege database access</h2>
        <p>Your application's database user should only have the permissions it actually needs. If it doesn't run migrations in production, it doesn't need schema-altering privileges. This limits the blast radius if application-level access is ever compromised.</p>
        <h2>7. Log and monitor</h2>
        <p>Set up logging for failed login attempts and unusual activity, and make sure someone actually looks at those logs. The fastest way to limit damage from an incident is knowing about it quickly.</p>
        <p>None of this is exotic — it's mostly discipline applied consistently before launch. If you'd like a second pair of eyes on a Laravel app before it goes live, that's exactly the kind of work I take on.</p>
        HTML;
    }

    /**
     * Rich-text body (safe HTML subset) for the WordPress speed post.
     */
    private function wordpressSpeedBody(): string
    {
        return <<<'HTML'
        <p>Most WordPress speed problems I run into on client audits come down to the same three or four causes. Here's the order I check them in, and what usually fixes each one.</p>
        <h2>1. Plugin bloat</h2>
        <p>Every active plugin adds its own scripts, styles and (often) database queries — whether or not the page actually needs them. I start by auditing which plugins run on every page versus which only need to load on specific ones, and disable or replace anything doing more than it should.</p>
        <h2>2. Unoptimized images</h2>
        <p>Full-resolution images uploaded straight from a phone or camera are one of the single biggest drags on load time. Serving properly sized, compressed images in modern formats (WebP where supported) with lazy loading for anything below the fold usually delivers the most visible improvement for the least effort.</p>
        <h2>3. No caching layer</h2>
        <p>WordPress generates pages dynamically by default, which means PHP and database work on every single visit unless something caches the output. A page-caching plugin, combined with server-level caching where possible, can cut load times dramatically without touching a single line of theme code.</p>
        <h2>4. Unoptimized database queries</h2>
        <p>Years of revisions, spam comments and transient options can bloat the database and slow every query down. A periodic cleanup, plus object caching with something like Redis for high-traffic sites, keeps things responsive as content grows.</p>
        <h2>5. Render-blocking scripts</h2>
        <p>Scripts and stylesheets loaded in the wrong order can delay the browser from painting anything at all. Deferring non-critical JavaScript and inlining critical CSS are small changes that measurably improve perceived load speed.</p>
        <h2>What this bought one client</h2>
        <p>On one e-learning platform I worked on, addressing these areas — alongside broader SEO work — contributed to a 40% increase in organic traffic, largely because faster pages and better technical SEO gave search engines less reason to rank the site lower.</p>
        <p>If your WordPress site feels sluggish and you're not sure why, I'm happy to take a look and tell you honestly what's worth fixing first.</p>
        HTML;
    }
}
