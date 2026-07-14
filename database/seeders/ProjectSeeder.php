<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

/**
 * Seeds the existing case studies carried over from the static site
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
                'cover_image' => 'https://picsum.photos/seed/inkbulksms/800/600',
                'cover_image_alt' => 'InkBulkSMS Dashboard',
                'gallery' => [],
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
                'cover_image' => 'https://picsum.photos/seed/hostel/800/600',
                'cover_image_alt' => 'Hostel Management Dashboard',
                'gallery' => [],
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
                'cover_image' => 'https://picsum.photos/seed/sikadaka/800/600',
                'cover_image_alt' => 'Sikadaka Financial Dashboard',
                'gallery' => [],
            ],
            [
                'title' => 'Emerging English Coaching',
                'slug' => 'emerging-english-coaching',
                'tagline' => 'Emerging English Coaching (EEC) is an online coaching service dedicated to helping English learners improve their communication skills and English teachers enhance their teaching strategies.',
                'challenge' => 'Establish a strong online presence to connect with a global audience of English learners and teachers. Core goals: accessible, quality online training for English communication skills and TEFL/TESOL certification.',
                'build' => 'Built a website designed to maximize course signups, including dedicated landing pages tailored to specific student demographics. Developed interactive tools to enhance learning engagement.',
                'impact' => 'Website traffic increased 200%. Gained more signups from students in Asia and Europe. Recognized as the best online English school in West Africa and Africa in 2022 and 2023.',
                'tech_stack' => ['WordPress', 'Elementor', 'TalentLMS', 'WooCommerce'],
                'live_url' => 'https://emergingenglishcoaching.com/',
                'featured' => true,
                'display_order' => 4,
                'cover_image' => 'https://ohene.dev/wp-content/uploads/2025/07/emergingenglishcoaching-contact-2025-07-30-22_38_26-1-scaled.webp',
                'cover_image_alt' => 'Emerging English Coaching Contact Page',
                'gallery' => [
                    'https://ohene.dev/wp-content/uploads/2025/07/emergingenglishcoaching-product-the-language-teachers-golden-companion-digital-copy-2025-07-30-22_40_34-scaled.webp',
                    'https://ohene.dev/wp-content/uploads/2025/05/emergingenglishcoaching-2-scaled.webp',
                    'https://ohene.dev/wp-content/uploads/2025/07/emergingenglishcoaching-tefl-tesol-180-2025-07-30-22_37_52-scaled.webp',
                    'https://ohene.dev/wp-content/uploads/2025/07/emergingenglishcoaching-work-abroad-2025-07-30-22_45_27-scaled.webp',
                    'https://ohene.dev/wp-content/uploads/2025/07/emergingenglishcoaching-tools-2025-07-30-22_41_07.webp',
                    'https://ohene.dev/wp-content/uploads/2025/07/emergingenglishcoaching-2024-04-02-cultivating-inclusive-classrooms-dr-gloria-bouttes-trailblazing-impact-on-tefl-tesol-education-2025-07-30-22_39_18-scaled.webp',
                    'https://ohene.dev/wp-content/uploads/2025/07/emergingenglishcoaching-blog-2025-07-30-22_38_49-scaled.webp',
                ],
            ],
            [
                'title' => 'Livingston Delivery Services (LDSGH)',
                'slug' => 'ldsgh-delivery-services',
                'tagline' => 'Livingston Delivery Services is a ride and parcel delivery service in Accra, Ghana, aiming to provide affordable services at reasonable prices.',
                'challenge' => 'Build a website with booking functionality so clients could book easily and the company could track and manage bookings while achieving higher search rankings.',
                'build' => 'Blog/marketing site built with WordPress and Elementor. Booking app built with Laravel and Livewire, with FilamentPHP for the admin dashboard. OpenStreetMap integration for geo-location-based cost estimation.',
                'impact' => 'Website reached approximately 200 visitors per day. Booking estimator gave users up-front cost details before booking, improving customer experience and retention.',
                'tech_stack' => ['Laravel', 'Livewire', 'FilamentPHP', 'WordPress'],
                'live_url' => 'http://ldsgh.com',
                'featured' => true,
                'display_order' => 5,
                'cover_image' => 'https://ohene.dev/wp-content/uploads/2025/12/2-16-Contact-LDSGH.png',
                'cover_image_alt' => 'LDSGH Delivery Services App Interface',
                'gallery' => [
                    'https://ohene.dev/wp-content/uploads/2025/12/1-46-Latest-News-LDSGH.png',
                    'https://ohene.dev/wp-content/uploads/2025/12/0-55-About-LDSGH-scaled.png',
                    'https://ohene.dev/wp-content/uploads/2025/12/2-00-Ullamcorper-Sitamet-Risusnullam-LDSGH-scaled.png',
                    'https://ohene.dev/wp-content/uploads/2025/12/3-03-LDSGH-Delivery-Ride-Booking.png',
                    'https://ohene.dev/wp-content/uploads/2025/12/3-43-LDSGH-Delivery-Ride-Booking.png',
                    'https://ohene.dev/wp-content/uploads/2025/12/3-31-LDSGH-Delivery-Ride-Booking.png',
                    'https://ohene.dev/wp-content/uploads/2025/12/3-17-LDSGH-Delivery-Ride-Booking.png',
                    'https://ohene.dev/wp-content/uploads/2025/12/4-49-LDSGH-Delivery-Ride-Booking.png',
                    'https://ohene.dev/wp-content/uploads/2025/12/4-39-LDSGH-Delivery-Ride-Booking.png',
                    'https://ohene.dev/wp-content/uploads/2025/12/2-43-LDSGH.png',
                ],
            ],
            [
                'title' => 'The Comforters Room',
                'slug' => 'the-comforters-room',
                'tagline' => 'The Comforters Room is an online Christian group focused on providing comfort and support to those who are hurting.',
                'challenge' => 'Establish a robust blog website to migrate existing blog content and publish new articles. Reach over 5,000 people with the blog and significantly increase website traffic.',
                'build' => 'Built on WordPress with Elementor for content management and flexible design. Comprehensive on-page and technical SEO, and integrations with Facebook and Spotify.',
                'impact' => '200% traffic increase compared to the old blog. Enhanced brand reputation and improved blog management, streamlining content delivery and audience interaction.',
                'tech_stack' => ['WordPress', 'Spotify API', 'Omnisend Email'],
                'live_url' => 'https://thecomfortersroom.com/',
                'featured' => false,
                'display_order' => 6,
                'cover_image' => 'https://ohene.dev/wp-content/uploads/2025/07/thecomfortersroom-gods-character-2025-07-30-22_00_29-scaled.webp',
                'cover_image_alt' => 'The Comforters Room Blog Article',
                'gallery' => [
                    'https://ohene.dev/wp-content/uploads/2025/07/thecomfortersroom-devotionals-2025-07-30-21_59_07-scaled.webp',
                    'https://ohene.dev/wp-content/uploads/2025/07/thecomfortersroom-2025-07-30-21_57_49-scaled.webp',
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
                'featured' => false,
                'display_order' => 7,
                'cover_image' => 'https://picsum.photos/seed/zelosworks/800/600',
                'cover_image_alt' => 'ZelosWorks Landing Page',
                'gallery' => [],
            ],
        ];

        foreach ($projects as $project) {
            Project::query()->updateOrCreate(['slug' => $project['slug']], $project);
        }
    }
}
