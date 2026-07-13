<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Moderation state of a testimonial.
 *
 * Nothing reaches the public site until Ohene approves it — see requirements 5.3.
 */
enum TestimonialStatus: string
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
}
