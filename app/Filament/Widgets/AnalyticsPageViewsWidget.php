<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Cache;
use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;

class AnalyticsPageViewsWidget extends ChartWidget
{
    protected ?string $heading = 'Page Views — Last 30 Days';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        try {
            $analytics = app(Analytics::class);
            $rows = Cache::remember('ga4.pageviews_chart', now()->addHours(6), static function () use ($analytics) {
                return $analytics->get(
                    period: Period::days(30),
                    metrics: ['screenPageViews'],
                    dimensions: ['date']
                );
            });

            $labels = [];
            $data = [];
            foreach ($rows as $row) {
                $date = $row['date'] ?? '';
                $labels[] = Carbon::createFromFormat('Ymd', $date)?->format('M j') ?? $date;
                $data[] = (int) ($row['screenPageViews'] ?? 0);
            }

            return [
                'datasets' => [[
                    'label' => 'Page Views',
                    'data' => $data,
                    'borderColor' => '#22c55e',
                    'backgroundColor' => 'rgba(34,197,94,0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ]],
                'labels' => $labels,
            ];
        } catch (\Throwable) {
            return ['datasets' => [['label' => 'Page Views', 'data' => []]], 'labels' => []];
        }
    }

    protected function getType(): string
    {
        return 'line';
    }
}
