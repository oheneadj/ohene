<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Database\Eloquent\Concerns\HasUlids;

/**
 * Gives a model a public-facing ULID alongside its internal bigint primary key.
 *
 * Per CLAUDE.md Section 5 the auto-increment `id` stays internal (joins, indexes)
 * while the `ulid` column is what we expose in routes, so raw integer IDs never
 * leak outside the app. Reuses Laravel's HasUlids generation but points it at the
 * `ulid` column instead of the primary key.
 */
trait HasPublicUlid
{
    use HasUlids;

    /**
     * Generate ULIDs for the `ulid` column, not the primary key.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['ulid'];
    }

    /**
     * Bind route models by their public ULID.
     */
    public function getRouteKeyName(): string
    {
        return 'ulid';
    }
}
