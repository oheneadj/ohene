<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    public function getTitle(): string | Htmlable
    {
        $hour = now()->hour;
        if ($hour < 12) {
            $greeting = 'Good morning';
        } elseif ($hour < 18) {
            $greeting = 'Good afternoon';
        } else {
            $greeting = 'Good evening';
        }
        $name = Auth::check() ? Auth::user()->name : 'Guest';
        return "{$greeting}, {$name}";
    }
    /**
     * Define the header actions available on the dashboard.
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('new_post')
                ->label('New Post')
                ->url(fn (): string => \App\Filament\Resources\Posts\PostResource::getUrl('create'))
                ->icon('heroicon-m-document-plus')
                ->color('success'),

            Action::make('new_case_study')
                ->label('New Case Study')
                ->url(fn (): string => \App\Filament\Resources\Projects\ProjectResource::getUrl('create'))
                ->icon('heroicon-m-briefcase')
                ->color('primary'),

            Action::make('view_live_site')
                ->label('View Live Site')
                ->url(url('/'))
                ->openUrlInNewTab()
                ->icon('heroicon-m-arrow-top-right-on-square')
                ->color('gray'),
        ];
    }
}
