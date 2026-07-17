<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

/**
 * Publication state of a blog post.
 *
 * Drives what the public site shows and what the CMS lets through — only
 * `Published` posts (with a past `published_at`) are visible to visitors.
 */
enum PostStatus: string implements HasLabel, HasColor
{
    case Draft = 'draft';
    case Scheduled = 'scheduled';
    case Published = 'published';

    /**
     * Human-friendly label for admin dropdowns and badges.
     */
    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Scheduled => 'Scheduled',
            self::Published => 'Published',
        };
    }

    public function getLabel(): ?string
    {
        return $this->label();
    }

    /**
     * Filament/Tailwind colour token for status badges.
     */
    public function color(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Scheduled => 'warning',
            self::Published => 'success',
        };
    }

    public function getColor(): string|array|null
    {
        return $this->color();
    }
}
