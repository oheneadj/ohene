<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImportProjectsCommand extends Command
{
    protected $signature = 'app:import-projects';

    protected $description = 'Import real projects from scraped JSON and download images';

    public function handle(): void
    {
        $jsonPath = base_path('projects_scrape.json');

        if (! file_exists($jsonPath)) {
            $this->error("JSON file not found at $jsonPath");

            return;
        }

        $data = json_decode((string) file_get_contents($jsonPath), true);
        if (! is_array($data)) {
            $this->error('Invalid JSON format');

            return;
        }

        if (! isset($data['projects'])) {
            $this->error('Invalid JSON format');

            return;
        }

        $this->info('Truncating existing projects...');
        Project::truncate();

        $projects = $data['projects'];

        foreach ($projects as $index => $projectData) {
            $this->info("Importing: {$projectData['title_corrected']}");

            $coverImage = null;
            $gallery = [];

            // Handle images
            if (! empty($projectData['images_raw'])) {
                $this->info('  Downloading '.count($projectData['images_raw']).' images...');

                foreach ($projectData['images_raw'] as $imgIndex => $url) {
                    try {
                        $response = Http::timeout(30)->get($url);
                        if ($response->successful()) {
                            // Extract filename from URL, remove query params if any
                            $filename = basename((string) parse_url($url, PHP_URL_PATH));
                            // Ensure it's unique enough but readable
                            $filename = "{$projectData['slug']}-{$imgIndex}-{$filename}";
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
                        $this->warn("    Error downloading $url: ".$e->getMessage());
                    }
                }
            }

            // Fix HTTP to HTTPS for LDSGH if needed, as flagged in JSON
            $liveUrl = $projectData['live_url'];
            if ($liveUrl === 'http://ldsgh.com') {
                $liveUrl = 'https://ldsgh.com';
            }

            // Create the project
            Project::create([
                'title' => $projectData['title_corrected'],
                'slug' => $projectData['slug'],
                'tagline' => $projectData['summary'],
                'challenge' => $projectData['objectives'],
                'build' => $projectData['strategy'],
                'impact' => $projectData['results'],
                'tech_stack' => $projectData['tools_used'],
                'live_url' => $liveUrl,
                'cover_image' => $coverImage,
                'gallery' => empty($gallery) ? null : $gallery,
                'featured' => true,
                'display_order' => $index,
            ]);

            $this->info("  Created successfully.\n");
        }

        $this->info('All projects imported successfully!');
    }
}
