<?php

declare(strict_types=1);

namespace App\Contracts;

/**
 * Marks a model whose slug changes should be recorded as 301 redirects
 * (FR15/FR18). Implemented via the RecordsSlugRedirects trait.
 */
interface RedirectsOnSlugChange
{
    /**
     * The URL segment this model lives under, e.g. "work" or "blog".
     */
    public function publicPathPrefix(): string;

    /**
     * Whether slug changes on this record should generate redirects.
     */
    public function slugRedirectsEnabled(): bool;
}
