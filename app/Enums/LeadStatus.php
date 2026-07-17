<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

/**
 * Where a contact-form lead sits in Ohene's follow-up pipeline.
 *
 * Purely an internal CRM state; never shown to the person who submitted the form.
 */
enum LeadStatus: string implements HasLabel, HasColor
{
    case New = 'new';
    case Contacted = 'contacted';
    case Won = 'won';
    case Lost = 'lost';

    /**
     * Human-friendly label for admin dropdowns and badges.
     */
    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Contacted => 'Contacted',
            self::Won => 'Won',
            self::Lost => 'Lost',
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
            self::New => 'info',
            self::Contacted => 'warning',
            self::Won => 'success',
            self::Lost => 'danger',
        };
    }

    public function getColor(): string|array|null
    {
        return $this->color();
    }
}
