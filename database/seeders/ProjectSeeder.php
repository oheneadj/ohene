<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

/**
 * Seeds the three existing case studies carried over from the static site
 * (requirements MG1). Keyed by slug so re-running never duplicates rows.
 */
class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'InkBulkSMS',
                'slug' => 'inkbulksms',
                'tagline' => 'A full-stack application for contact management and bulk SMS dispatch, with real-time delivery tracking.',
                'challenge' => 'Businesses needed a simple way to manage contact lists and send bulk SMS campaigns without juggling spreadsheets and manual sends.',
                'build' => 'A full-stack Laravel and Vue.js application with contact management, message templates and a real-time delivery dashboard.',
                'impact' => 'Client engagement rose by 30% after launch, driven by the real-time tracking dashboard.',
                'tech_stack' => ['Laravel', 'PHP', 'MySQL', 'Vue.js'],
                'live_url' => 'https://inkbulksms.app',
                'featured' => true,
                'display_order' => 1,
            ],
            [
                'title' => 'Hostel Management Web App',
                'slug' => 'hostel-management',
                'tagline' => 'A PHP and MySQL system to streamline room bookings, tenant management and room-key tracking.',
                'challenge' => 'A student hostel was tracking bookings, tenants and key handovers on paper, leading to double-bookings and lost keys.',
                'build' => 'A PHP and MySQL web app with Bootstrap for room booking, tenant records and a key-tracking log accessible to staff.',
                'impact' => 'Digitised operations end to end, tightening key security and cutting admin overhead.',
                'tech_stack' => ['Bootstrap', 'PHP', 'MySQL'],
                'live_url' => null,
                'featured' => true,
                'display_order' => 2,
            ],
            [
                'title' => 'Sikadaka',
                'slug' => 'sikadaka',
                'tagline' => 'A Laravel-based financial management system for community savings groups.',
                'challenge' => 'Informal savings communities needed a transparent way to register members and track contributions without manual ledgers.',
                'build' => 'A Laravel-based system for creating communities, registering members and tracking payments, engineered to scale to 1,000+ members.',
                'impact' => 'Gives administrators full transaction visibility and financial transparency across the community.',
                'tech_stack' => ['Laravel', 'PHP', 'MySQL'],
                'live_url' => 'https://sikadaka.app',
                'featured' => true,
                'display_order' => 3,
            ],
        ];

        foreach ($projects as $project) {
            Project::query()->updateOrCreate(['slug' => $project['slug']], $project);
        }
    }
}
