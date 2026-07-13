<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportGithubProjectsCommand extends Command
{
    protected $signature = 'app:import-github-projects';
    protected $description = 'Import projects from scraped GitHub JSON and download images';

    public function handle()
    {
        $jsonPath = base_path('github_projects_scrape.json');
        
        if (!file_exists($jsonPath)) {
            $this->error("JSON file not found at $jsonPath");
            return;
        }

        $data = json_decode(file_get_contents($jsonPath), true);
        
        if (!isset($data['projects'])) {
            $this->error("Invalid JSON format");
            return;
        }

        $projects = $data['projects'];
        $startingOrder = Project::max('display_order') ?? 0;
        
        // Define manual synthesised copy
        $synthesisedCopy = [
            'lautos' => [
                'tagline' => 'Vehicle Shipping Platform replacing a manual order process with a fully automated shipping platform.',
                'challenge' => 'Automating a manual vehicle shipping process and providing transparent tracking and cost estimation.',
                'build' => 'A comprehensive platform built with Laravel, Livewire, Filament, and integrated with Google OAuth, Brevo, and GiantSMS.',
                'impact' => 'Delivered a fully automated platform with role-based access control and real-time tracking.'
            ],
            'subtrack' => [
                'tagline' => 'Client Subscription & Asset Manager for web agencies to track domains, hosting, SSL, and automate invoices.',
                'challenge' => 'Web agencies struggling to track client domains, hosting renewals, and SSL expirations leading to missed deadlines.',
                'build' => 'Built with Laravel 13, Livewire 4, FlyonUI, leveraging scheduled artisan commands for daily checks.',
                'impact' => 'Eliminated missed deadlines and automated professional USD invoice generation.'
            ],
            'openstores' => [
                'tagline' => 'The Operating System for Modern Retail: A comprehensive, multi-tenant SaaS POS solution.',
                'challenge' => 'Independent retailers need a modern, offline-capable POS to compete with big-box giants.',
                'build' => 'A multi-tenant SaaS architecture built with Laravel 12.x, Livewire 3, Alpine.js, and FlyonUI.',
                'impact' => 'Delivered a robust retail OS featuring multi-business switching and advanced inventory tracking.'
            ],
            'podlist' => [
                'tagline' => 'A modern WordPress plugin to easily embed customizable Spotify podcast playlists.',
                'challenge' => 'WordPress users needing an elegant way to embed customizable Spotify podcast playlists without performance hits.',
                'build' => 'Developed using the WordPress Plugin API, PHP, JS, and CSS with built-in caching and infinite scroll support.',
                'impact' => 'A lightweight, customizable plugin that handles infinite scrolling and compact embeds efficiently.'
            ],
            'sikadaka' => [
                'tagline' => 'A Laravel-based financial management system for community savings groups.',
                'challenge' => 'Informal savings communities needed a transparent way to register members and track contributions without manual ledgers.',
                'build' => 'A Laravel-based system for creating communities, registering members and tracking payments, engineered to scale to 1,000+ members.',
                'impact' => 'Gives administrators full transaction visibility and financial transparency across the community.'
            ]
        ];

        foreach ($projects as $index => $projectData) {
            $slug = $projectData['slug'];
            $this->info("Importing: {$projectData['title']} ({$slug})");
            
            // Skip if project already exists to avoid duplicates
            if (Project::where('slug', $slug)->exists()) {
                $this->warn("  Project {$slug} already exists. Skipping.");
                continue;
            }

            $coverImage = null;
            $gallery = [];
            $imageUrlsToDownload = [];
            
            if (!empty($projectData['screenshot'])) {
                $imageUrlsToDownload[] = $projectData['screenshot'];
            }
            if (!empty($projectData['screenshots']) && is_array($projectData['screenshots'])) {
                $imageUrlsToDownload = array_merge($imageUrlsToDownload, $projectData['screenshots']);
            }
            
            if (!empty($imageUrlsToDownload)) {
                $this->info("  Downloading " . count($imageUrlsToDownload) . " images...");
                
                foreach ($imageUrlsToDownload as $imgIndex => $url) {
                    try {
                        $response = Http::timeout(30)->get($url);
                        if ($response->successful()) {
                            // Extract filename from URL, remove query params if any
                            $filename = basename(parse_url($url, PHP_URL_PATH));
                            $filename = "{$slug}-{$imgIndex}-{$filename}";
                            $path = "projects/{$filename}";
                            
                            Storage::disk('public')->put($path, $response->body());
                            
                            if ($imgIndex === 0) {
                                $coverImage = $path;
                            } else {
                                $gallery[] = $path;
                            }
                            $this->line("    Downloaded: $filename");
                        } else {
                            $this->warn("    Failed to download: $url");
                        }
                    } catch (\Exception $e) {
                        $this->warn("    Error downloading $url: " . $e->getMessage());
                    }
                }
            }

            $copy = $synthesisedCopy[$slug] ?? [];
            
            Project::create([
                'title' => $projectData['title'],
                'slug' => $slug,
                'tagline' => $copy['tagline'] ?? $projectData['description'],
                'challenge' => $copy['challenge'] ?? '',
                'build' => $copy['build'] ?? '',
                'impact' => $copy['impact'] ?? '',
                'tech_stack' => $projectData['tech_stack_detected'],
                'live_url' => null,
                'repo_url' => $projectData['repo_url'] ?? null,
                'cover_image' => $coverImage,
                'gallery' => empty($gallery) ? null : $gallery,
                'featured' => true,
                'display_order' => $startingOrder + $index + 1,
            ]);
            
            $this->info("  Created successfully.\n");
        }
        
        $this->info("All GitHub projects imported successfully!");
    }
}
