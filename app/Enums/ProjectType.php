<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * The kind of work a lead is enquiring about (contact-form dropdown).
 *
 * Kept intentionally broad — this is a qualification hint for Ohene, not a
 * rigid taxonomy, so it maps to the services the site actually pitches.
 */
enum ProjectType: string
{
    case WebApp = 'web_app';
    case Website = 'website';
    case Api = 'api';
    case Maintenance = 'maintenance';
    case Consulting = 'consulting';
    case Other = 'other';

    /**
     * Human-friendly label for the contact form and admin.
     */
    public function label(): string
    {
        return match ($this) {
            self::WebApp => 'Web application',
            self::Website => 'Website',
            self::Api => 'API / integration',
            self::Maintenance => 'Maintenance / support',
            self::Consulting => 'Consulting / audit',
            self::Other => 'Something else',
        };
    }
}
