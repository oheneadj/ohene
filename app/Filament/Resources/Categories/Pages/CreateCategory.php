<?php

declare(strict_types=1);

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Admin create page for a category record.
 */
class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
