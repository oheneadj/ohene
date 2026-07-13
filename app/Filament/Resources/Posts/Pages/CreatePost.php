<?php

declare(strict_types=1);

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Admin create page for a post record.
 */
class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
}
