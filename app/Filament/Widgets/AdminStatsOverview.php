<?php

/**
 * File: AdminStatsOverview.php
 * Description: Widget displaying key metrics for the admin dashboard.
 */

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\LeadStatus;
use App\Enums\TestimonialStatus;
use App\Models\Lead;
use App\Models\Post;
use App\Models\Project;
use App\Models\Testimonial;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * Dashboard summary of the counts Ohene acts on day to day.
 * Displays new leads and pending testimonials, plus content totals.
 */
class AdminStatsOverview extends StatsOverviewWidget
{
    // Four cheap COUNT queries — render inline rather than lazy-loading, so the
    // numbers are there on first paint (and testable).
    protected static bool $isLazy = false;

    /**
     * Column span of the widget.
     */
    protected int|string|array $columnSpan = 'full';

    /**
     * Get the number of columns to display the stats in.
     */
    protected function getColumns(): int
    {
        return 4;
    }

    /**
     * The stat cards shown at the top of the admin dashboard.
     *
     * @return array<int, Stat>
     */
    protected function getStats(): array
    {
        return [
            Stat::make('New leads', Lead::query()->where('status', LeadStatus::New)->count())
                ->description('Awaiting first contact')
                ->color('info'),
            Stat::make('Pending testimonials', Testimonial::query()->where('status', TestimonialStatus::Pending)->count())
                ->description('Awaiting approval')
                ->color('warning'),
            Stat::make('Published posts', Post::query()->published()->count())
                ->description('Live on the blog'),
            Stat::make('Case studies', Project::query()->count())
                ->description('In the portfolio'),
        ];
    }
}
