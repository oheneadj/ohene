<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

/**
 * Generates and manages 600×450 thumbnail copies of cover images.
 *
 * Thumbnails are stored alongside the original in a `thumbs/` sub-directory
 * on the public disk. The full-resolution image is untouched and remains the
 * single source of truth — the thumbnail is a derived, disposable artefact.
 */
class ThumbnailService
{
    public function __construct(private ?ImageManager $manager = null)
    {
        // GD is the standard driver available without extra system dependencies.
        $this->manager ??= new ImageManager(Driver::class);
    }

    /**
     * Generate a 600×450 thumbnail from a local public-disk path.
     *
     * Returns the public-disk relative path to the new thumbnail,
     * or null when the source file doesn't exist or processing fails.
     *
     * @param  string  $coverPath  Public-disk relative path (e.g. "projects/foo.webp")
     */
    public function generate(string $coverPath): ?string
    {
        // External URLs (e.g. picsum placeholders) can't be processed locally.
        if (str_starts_with($coverPath, 'http')) {
            return null;
        }

        $absolutePath = Storage::disk('public')->path($coverPath);

        if (! file_exists($absolutePath)) {
            Log::warning('ThumbnailService: source file not found.', [
                'cover_path' => $coverPath,
            ]);

            return null;
        }

        try {
            $image = $this->manager->decodePath($absolutePath);
            $image->cover(600, 450);

            $thumbPath = $this->thumbPath($coverPath);

            // encodeUsingFormat is the correct Intervention Image v4 API.
            Storage::disk('public')->put($thumbPath, $image->encodeUsingFormat(Format::JPEG)->toString());

            return $thumbPath;
        } catch (\Throwable $e) {
            // Non-fatal — the full image will be served as a fallback.
            Log::warning('ThumbnailService: generation failed.', [
                'cover_path' => $coverPath,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Delete a thumbnail file from the public disk, if it exists.
     */
    public function delete(string $thumbnailPath): void
    {
        Storage::disk('public')->delete($thumbnailPath);
    }

    /**
     * Derive the public-disk thumbnail path for a given cover image path.
     * Always outputs a .jpg regardless of the source extension.
     */
    private function thumbPath(string $coverPath): string
    {
        $dir = dirname($coverPath);

        return $dir.'/thumbs/'.Str::random(8).'_thumb.jpg';
    }
}
