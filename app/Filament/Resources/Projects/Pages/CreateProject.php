<?php

declare(strict_types=1);

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Admin create page for a project record.
 */
class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    protected function afterCreate(): void
    {
        $users = \App\Models\User::all();
        
        \Filament\Notifications\Notification::make()
            ->title('New Project Published')
            ->body("A new case study '{$this->record->title}' has been published.")
            ->success()
            ->sendToDatabase($users);
    }
}
