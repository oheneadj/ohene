<?php

declare(strict_types=1);

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

/**
 * Admin edit page for a post record.
 */
class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    /**
     * Header actions available on this page.
     */
    protected function getHeaderActions(): array
    {
        return [
            $this->getSaveFormAction(),
            Action::make('preview')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn (): string => route('blog.preview', $this->record), shouldOpenInNewTab: true),
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
