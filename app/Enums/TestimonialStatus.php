<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

/**
 * Moderation state of a testimonial.
 *
 * Nothing reaches the public site until Ohene approves it — see requirements 5.3.
 */
enum TestimonialStatus: string implements HasLabel, HasColor
{
    case Pending = 'pending';
    case Approved = 'approved';

    /**
     * Human-friendly label for admin dropdowns and badges.
     */
    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Approved => 'Approved',
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
            self::Pending => 'warning',
            self::Approved => 'success',
        };
    }

    public function getColor(): string|array|null
    {
        return $this->color();
    }
}
