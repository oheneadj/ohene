<?php

/**
 * File: AssetHelper.php
 * Description: Utility helper to resolve local and external asset URLs.
 */

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

/**
 * Utility helper class for asset URL resolution.
 * Handles both local public storage paths and external URLs.
 */
class AssetHelper
{
    /**
     * Resolve the asset URL, supporting both local storage paths and external URLs.
     *
     * @param  string|null  $path  The relative path or absolute URL of the asset.
     * @return string|null The fully resolved URL, or null if the path is blank.
     */
    public static function url(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
