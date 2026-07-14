<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

/**
 * Seeds the existing case studies carried over from the static site
 * and github scrapes. Keyed by slug so re-running never duplicates rows.
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
                'repo_url' => null,
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
                'repo_url' => null,
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
                'tech_stack' => ['Laravel', 'PHP', 'MySQL', 'Blade', 'Tailwind CSS'],
                'live_url' => 'https://sikadaka.app',
                'repo_url' => 'https://github.com/oheneadj/sikadaka',
                'featured' => true,
                'display_order' => 3,
            ],
            [
                'title' => 'Emerging English Coaching',
                'slug' => 'emerging-english-coaching',
                'tagline' => 'An online coaching service dedicated to helping English learners improve their communication skills.',
                'challenge' => 'Establish a strong online presence to connect with a global audience of English learners and teachers. Core goals: accessible, quality online training for English communication skills and TEFL/TESOL certification.',
                'build' => 'Built a website designed to maximize course signups, including dedicated landing pages tailored to specific student demographics. Developed interactive tools to enhance learning engagement.',
                'impact' => 'Website traffic increased 200%. Gained more signups from students in Asia and Europe. Recognized as the best online English school in West Africa and Africa in 2022 and 2023.',
                'tech_stack' => ['WordPress', 'Elementor', 'TalentLMS', 'WooCommerce'],
                'live_url' => 'https://emergingenglishcoaching.com/',
                'repo_url' => null,
                'featured' => true,
                'display_order' => 4,
                'cover_image' => 'projects/2AttGR7zK3_emerging-english-coaching_0.webp',
                'cover_image_alt' => 'Emerging English Coaching Contact Page',
                'gallery' => [
                    'projects/gallery/uUggXDpjxO_emerging-english-coaching_1.webp',
                    'projects/gallery/Ed5MZiNO3l_emerging-english-coaching_2.webp',
                    'projects/gallery/w1nckW9ewM_emerging-english-coaching_3.webp',
                    'projects/gallery/2Vp2jurn0a_emerging-english-coaching_4.webp',
                    'projects/gallery/7Eqxm52fRn_emerging-english-coaching_5.webp',
                    'projects/gallery/99tlQDnmg3_emerging-english-coaching_6.webp',
                    'projects/gallery/uj3ZEHgovc_emerging-english-coaching_7.webp',
                ],
            ],
            [
                'title' => 'Livingston Delivery Services (LDSGH)',
                'slug' => 'ldsgh-delivery-services',
                'tagline' => 'A ride and parcel delivery service in Accra, Ghana, aiming to provide affordable services.',
                'challenge' => 'Build a website with booking functionality so clients could book easily and the company could track and manage bookings while achieving higher search rankings.',
                'build' => 'Blog/marketing site built with WordPress and Elementor. Booking app built with Laravel and Livewire, with FilamentPHP for the admin dashboard. OpenStreetMap integration for geo-location-based cost estimation.',
                'impact' => 'Website reached approximately 200 visitors per day. Booking estimator gave users up-front cost details before booking, improving customer experience and retention.',
                'tech_stack' => ['Laravel', 'Livewire', 'FilamentPHP', 'WordPress'],
                'live_url' => 'http://ldsgh.com',
                'repo_url' => null,
                'featured' => true,
                'display_order' => 5,
                'cover_image' => 'projects/63jCZ8X5f4_ldsgh-delivery-services_0.png',
                'cover_image_alt' => 'LDSGH Delivery Services App Interface',
                'gallery' => [
                    'projects/gallery/VEi0j99j58_ldsgh-delivery-services_1.png',
                    'projects/gallery/mXRXyxIL7h_ldsgh-delivery-services_2.png',
                    'projects/gallery/hSLB01WgSb_ldsgh-delivery-services_3.png',
                    'projects/gallery/kZSbpCWUCD_ldsgh-delivery-services_4.png',
                    'projects/gallery/ULHtilM0bw_ldsgh-delivery-services_5.png',
                    'projects/gallery/tRxWYPXsBs_ldsgh-delivery-services_6.png',
                    'projects/gallery/3GDVFgwsZW_ldsgh-delivery-services_7.png',
                    'projects/gallery/E8vr1drrF9_ldsgh-delivery-services_8.png',
                    'projects/gallery/KlVUV8385n_ldsgh-delivery-services_9.png',
                    'projects/gallery/FvpPBg4d4g_ldsgh-delivery-services_10.png',
                ],
            ],
            [
                'title' => 'The Comforters Room',
                'slug' => 'the-comforters-room',
                'tagline' => 'An online Christian group focused on providing comfort and support to those who are hurting.',
                'challenge' => 'Establish a robust blog website to migrate existing blog content and publish new articles. Reach over 5,000 people with the blog and significantly increase website traffic.',
                'build' => 'Built on WordPress with Elementor for content management and flexible design. Comprehensive on-page and technical SEO, and integrations with Facebook and Spotify.',
                'impact' => '200% traffic increase compared to the old blog. Enhanced brand reputation and improved blog management, streamlining content delivery and audience interaction.',
                'tech_stack' => ['WordPress', 'Spotify API', 'Omnisend Email'],
                'live_url' => 'https://thecomfortersroom.com/',
                'repo_url' => null,
                'featured' => false,
                'display_order' => 6,
                'cover_image' => 'projects/tTrgvjPo6v_the-comforters-room_0.webp',
                'cover_image_alt' => 'The Comforters Room Blog Article',
                'gallery' => [
                    'projects/gallery/AasVnVBpsB_the-comforters-room_1.webp',
                    'projects/gallery/3IJkH4TNkt_the-comforters-room_2.webp',
                ],
            ],
            [
                'title' => 'ZelosWorks',
                'slug' => 'zelosworks',
                'tagline' => 'ZelosWorks is a software development agency that develops custom software for businesses in Ghana.',
                'challenge' => 'A dedicated, responsive one-page landing page to simplify client engagement, enable direct booking, and highlight ZelosWorks\' capabilities.',
                'build' => 'Built a fully responsive one-page site highlighting essential information, with prominent CTAs to guide visitors and boost engagement. Integrated Google Calendar.',
                'impact' => '200% increase in qualified leads. Simple design and seamless booking integration improved accessibility for scheduling meetings via Google Calendar.',
                'tech_stack' => ['WordPress', 'Elementor', 'Google Calendar'],
                'live_url' => 'https://zelosworks.com/',
                'repo_url' => null,
                'featured' => false,
                'display_order' => 7,
            ],
            [
                'title' => 'LAutos',
                'slug' => 'lautos',
                'tagline' => 'Vehicle Shipping Platform',
                'challenge' => 'Replace a manual vehicle order process with a fully automated shipping platform.',
                'build' => 'A full-stack application enabling customers to browse available vehicles, place orders, upload payment proof, and track shipments. Features Google OAuth login, role-based access control, real-time tracking, Brevo email notifications, GiantSMS alerts, and Sentry error monitoring.',
                'impact' => 'Streamlined operations and automated manual processes. Phase 2 will introduce an import duty and cost calculator.',
                'tech_stack' => ['Laravel', 'Blade', 'Livewire', 'Alpine.js', 'Filament', 'MySQL'],
                'live_url' => null,
                'repo_url' => 'https://github.com/oheneadj/lautos',
                'featured' => true,
                'display_order' => 8,
            ],
            [
                'title' => 'SubTrack',
                'slug' => 'subtrack',
                'tagline' => 'Client Subscription & Asset Manager for web agencies.',
                'challenge' => 'Web agencies needed an internal tool to track client subscriptions (domains, hosting, SSL, maintenance), automate renewal reminders, and generate professional USD invoices.',
                'build' => 'Dashboard with high-level overview of critical expiries. Automated daily expiry checks and email notifications via scheduled commands. Invoicing capabilities via DomPDF.',
                'impact' => 'Eliminated missed renewal deadlines via Laravel scheduled jobs and simplified billing processes.',
                'tech_stack' => ['Laravel 13', 'Livewire 4', 'FlyonUI', 'DomPDF', 'MySQL'],
                'live_url' => null,
                'repo_url' => 'https://github.com/oheneadj/SubTrack',
                'featured' => true,
                'display_order' => 9,
                'cover_image' => 'projects/9SVVNeSUbU_subtrack_0.png',
                'cover_image_alt' => 'SubTrack Dashboard Interface',
            ],
            [
                'title' => 'OpenStores',
                'slug' => 'openstores',
                'tagline' => 'The Operating System for Modern Retail',
                'challenge' => 'Independent retailers needed a comprehensive SaaS solution to compete with big-box giants through better inventory and POS tools.',
                'build' => 'Developed a multi-tenant SaaS with a high-speed, offline-capable Point of Sale (POS), advanced real-time inventory tracking, multi-business architecture, and role-based access.',
                'impact' => 'Empowered retailers with live analytics, fast checkout, and scalable cloud infrastructure.',
                'tech_stack' => ['Laravel 12.x', 'Livewire 3', 'Alpine.js v3', 'Tailwind CSS', 'FlyonUI', 'MySQL'],
                'live_url' => null,
                'repo_url' => 'https://github.com/oheneadj/openstorev2',
                'featured' => false,
                'display_order' => 10,
                'cover_image' => 'projects/iAZvPRgoFb_openstores_0.png',
                'cover_image_alt' => 'OpenStores Business Dashboard',
                'gallery' => [
                    'projects/gallery/jJ63kT9e6s_openstores_1.png',
                ],
            ],
            [
                'title' => 'PodList',
                'slug' => 'podlist',
                'tagline' => 'WordPress Podcast Playlist Plugin',
                'challenge' => 'Provide a simple way to embed Spotify podcast playlists on WordPress with customizable display options.',
                'build' => 'A modern WordPress plugin featuring a simple shortcode `[podlist]`, built-in caching, pagination (Load More / Infinite Scroll), and an admin settings panel.',
                'impact' => 'Created an easy-to-use open source solution for podcasters on WordPress.',
                'tech_stack' => ['PHP', 'JavaScript', 'CSS', 'WordPress Plugin API'],
                'live_url' => null,
                'repo_url' => 'https://github.com/oheneadj/podlist',
                'featured' => false,
                'display_order' => 11,
            ],
        ];

        foreach ($projects as $project) {
            Project::query()->updateOrCreate(['slug' => $project['slug']], $project);
        }
    }
}
