<?php

declare(strict_types=1);

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

/**
 * Admin read-only detail page for a project record.
 */
class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    /**
     * Header actions available on this page.
     */
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
