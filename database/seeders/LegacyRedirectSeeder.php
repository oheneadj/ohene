<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Redirect;
use Illuminate\Database\Seeder;

/**
 * Maps the old static site's URLs to the new dynamic routes with 301s so no
 * accrued SEO value is lost at cutover (requirements MG2). Covers both the
 * `.html` files and the directory-index forms the static site exposed.
 */
class LegacyRedirectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $map = [
            '/index.html' => '/',
            '/work/index.html' => '/work',
            '/work/inkbulksms.html' => '/work/inkbulksms',
            '/work/hostel-management.html' => '/work/hostel-management',
            '/work/sikadaka.html' => '/work/sikadaka',
            '/blog/index.html' => '/blog',
            '/blog/laravel-security-checklist.html' => '/blog/laravel-security-checklist',
            '/blog/wordpress-speed-optimization.html' => '/blog/wordpress-speed-optimization',
            '/about/index.html' => '/about',
            '/contact/index.html' => '/contact',
            '/videos/index.html' => '/videos',
        ];

        foreach ($map as $from => $to) {
            Redirect::query()->updateOrCreate(['from_path' => $from], ['to_path' => $to]);
        }
    }
}
