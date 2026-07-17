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
                ->descriptionIcon('heroicon-m-inbox-arrow-down')
                ->chart([2, 3, 5, 2, 7, 4, 8])
                ->color('info'),
                
            Stat::make('Leads won', Lead::query()->where('status', LeadStatus::Won)->count())
                ->description('Converted clients')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([1, 2, 2, 4, 5, 8, 10])
                ->color('success'),
                
            Stat::make('Pending testimonials', Testimonial::query()->where('status', TestimonialStatus::Pending)->count())
                ->description('Awaiting approval')
                ->descriptionIcon('heroicon-m-chat-bubble-left-ellipsis')
                ->chart([0, 1, 0, 2, 1, 3, 2])
                ->color('warning'),
                
            Stat::make('Case studies', Project::query()->count())
                ->description('In the portfolio')
                ->descriptionIcon('heroicon-m-briefcase')
                ->chart([4, 4, 5, 5, 6, 6, 7])
                ->color('primary'),
                
            Stat::make('Published posts', Post::query()->where('status', \App\Enums\PostStatus::Published)->count())
                ->description('Live on the blog')
                ->descriptionIcon('heroicon-m-document-text')
                ->chart([10, 12, 11, 14, 15, 16, 19])
                ->color('success'),
                
            Stat::make('Scheduled posts', Post::query()->where('status', \App\Enums\PostStatus::Scheduled)->count())
                ->description('Ready to go live')
                ->descriptionIcon('heroicon-m-clock')
                ->chart([1, 0, 2, 1, 3, 2, 4])
                ->color('warning'),

            Stat::make('Total Post Views', number_format((int) Post::sum('views_count')))
                ->description('Across all blog posts')
                ->descriptionIcon('heroicon-m-eye')
                ->chart([3, 5, 8, 12, 14, 18, 25])
                ->color('success'),

            Stat::make('Total Project Views', number_format((int) Project::sum('views_count')))
                ->description('Across all case studies')
                ->descriptionIcon('heroicon-m-eye')
                ->chart([1, 2, 4, 7, 9, 12, 16])
                ->color('primary'),
        ];
    }
}
