<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Optional budget band a lead can pick on the contact form.
 *
 * Bands (not exact figures) keep the question low-friction while still helping
 * Ohene gauge fit before replying. Values are stored, labels are display-only.
 */
enum BudgetRange: string
{
    case Under1k = 'under_1k';
    case From1kTo5k = '1k_5k';
    case From5kTo10k = '5k_10k';
    case Over10k = 'over_10k';
    case NotSure = 'not_sure';

    /**
     * Human-friendly label for the contact form and admin.
     */
    public function label(): string
    {
        return match ($this) {
            self::Under1k => 'Under $1,000',
            self::From1kTo5k => '$1,000 – $5,000',
            self::From5kTo10k => '$5,000 – $10,000',
            self::Over10k => 'Over $10,000',
            self::NotSure => 'Not sure yet',
        };
    }
}
