<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Services\ThumbnailService;

/**
 * Hooks into the model's `saving` event to automatically generate a
 * 600×450 thumbnail whenever the `cover_image` field changes.
 *
 * The actual processing is delegated to ThumbnailService — this trait
 * only wires up the lifecycle hook, keeping business logic out of the model.
 *
 * Models using this trait must have `cover_image` and
 * `cover_image_thumbnail` as fillable attributes.
 */
trait GeneratesCoverThumbnail
{
    /**
     * Register the thumbnail generation hook via Laravel's boot convention.
     * Called automatically alongside other trait boot methods.
     */
    public static function bootGeneratesCoverThumbnail(): void
    {
        static::saving(function (self $model): void {
            if (! $model->isDirty('cover_image')) {
                return;
            }

            /** @var ThumbnailService $service */
            $service = app(ThumbnailService::class);

            // Clean up the old thumbnail when the cover is being replaced or cleared.
            if ($old = $model->getOriginal('cover_image_thumbnail')) {
                $service->delete($old);
                $model->cover_image_thumbnail = null;
            }

            if (blank($model->cover_image)) {
                return;
            }

            $model->cover_image_thumbnail = $service->generate($model->cover_image);
        });
    }
}
