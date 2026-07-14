<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;
use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;

class AnalyticsTopPagesWidget extends Widget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.widgets.analytics-top-pages';

    /**
     * @var array<int, array<string, mixed>>
     */
    public array $rows = [];

    public function mount(): void
    {
        try {
            $analytics = app(Analytics::class);
            $this->rows = Cache::remember('ga4.top_pages', now()->addHours(6), function () use ($analytics) {
                return $analytics->get(
                    period: Period::days(28),
                    metrics: ['screenPageViews', 'sessions'],
                    dimensions: ['pagePath', 'pageTitle'],
                    maxResults: 10
                )->map(fn ($row) => [
                    'title' => $row['pageTitle'] ?? 'Unknown',
                    'path' => $row['pagePath'] ?? '/',
                    'views' => number_format((int) ($row['screenPageViews'] ?? 0)),
                    'sessions' => number_format((int) ($row['sessions'] ?? 0)),
                ])->toArray();
            });
        } catch (\Throwable) {
            $this->rows = [];
        }
    }
}
