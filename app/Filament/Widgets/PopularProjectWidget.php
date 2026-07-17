<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\Widget;

class PopularProjectWidget extends Widget
{
    protected string $view = 'filament.widgets.popular-project-widget';

    protected static ?int $sort = 3;

    protected function getViewData(): array
    {
        $popularProject = Project::orderByDesc('views_count')->first();

        return [
            'projectTitle' => $popularProject ? $popularProject->title : 'None',
            'projectViews' => $popularProject ? $popularProject->views_count : 0,
        ];
    }
}
