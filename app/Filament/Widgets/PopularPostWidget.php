<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\Widget;

class PopularPostWidget extends Widget
{
    protected string $view = 'filament.widgets.popular-post-widget';

    protected static ?int $sort = 2;

    protected function getViewData(): array
    {
        $popularPost = Post::orderByDesc('views_count')->first();

        return [
            'postTitle' => $popularPost ? $popularPost->title : 'None',
            'postViews' => $popularPost ? $popularPost->views_count : 0,
        ];
    }
}
