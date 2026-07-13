<?php

declare(strict_types=1);

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

/**
 * Admin read-only detail page for a post record.
 */
class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;

    /**
     * Header actions available on this page.
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('preview')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn (): string => route('blog.preview', $this->record), shouldOpenInNewTab: true),
            EditAction::make(),
        ];
    }
}
