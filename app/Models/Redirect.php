<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A stored 301 redirect from an old path to a new one (FR15). Populated when a
 * published post or project changes its slug, and consulted when a request 404s.
 */
class Redirect extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'from_path',
        'to_path',
    ];

    /**
     * Record a redirect from one path to another, keeping the chain flat.
     *
     * Skips no-op redirects, repoints any existing redirect that targeted the
     * old path at the new destination, and never lets a path redirect to itself.
     */
    public static function record(string $from, string $to): void
    {
        if ($from === $to) {
            return;
        }

        // Anything that used to land on the old path should now skip to the new one.
        static::query()->where('to_path', $from)->update(['to_path' => $to]);

        static::query()->updateOrCreate(['from_path' => $from], ['to_path' => $to]);

        // A brand-new redirect must never point back at itself.
        static::query()->where('from_path', $to)->delete();
    }
}
