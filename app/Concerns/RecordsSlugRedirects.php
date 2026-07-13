<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Contracts\RedirectsOnSlugChange;
use App\Models\Redirect;
use Illuminate\Database\Eloquent\Model;

/**
 * Records a 301 redirect when a model's slug changes after it's public
 * (requirements FR18): the old URL keeps working instead of 404-ing, which
 * protects any SEO value already accrued (FR15).
 *
 * Consumers implement {@see RedirectsOnSlugChange} — providing the public path
 * prefix (e.g. "work", "blog") and, optionally, narrowing when redirects apply
 * (posts only redirect once they've been published).
 */
trait RecordsSlugRedirects
{
    /**
     * Hook the model's update lifecycle to capture slug changes.
     */
    public static function bootRecordsSlugRedirects(): void
    {
        static::updated(function (Model&RedirectsOnSlugChange $model): void {
            if (! $model->wasChanged('slug') || ! $model->slugRedirectsEnabled()) {
                return;
            }

            $prefix = $model->publicPathPrefix();

            Redirect::record(
                '/'.$prefix.'/'.$model->getOriginal('slug'),
                '/'.$prefix.'/'.$model->getAttribute('slug'),
            );
        });
    }

    /**
     * Whether slug changes on this record should generate redirects. Defaults to
     * always; models with a draft state override this to require publication.
     */
    public function slugRedirectsEnabled(): bool
    {
        return true;
    }
}
