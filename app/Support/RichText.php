<?php

declare(strict_types=1);

namespace App\Support;

use App\RichEditor\YouTubeEmbedBlock;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Throwable;

/**
 * Renders a post body to HTML, resilient to every shape it can take.
 *
 * The RichEditor stores new bodies as a Tiptap JSON document (array), but
 * legacy/seeded posts hold a plain HTML string. Feeding an HTML string straight
 * to the Tiptap renderer crashes ("read property type on null"), so we route by
 * shape and degrade gracefully rather than 500 a page over one bad record.
 */
class RichText
{
    /**
     * Turn a post body into HTML. The renderer natively handles both the Tiptap
     * JSON document (array) that the editor saves and legacy/HTML string bodies,
     * resolving custom blocks (e.g. YouTube embeds) either way. A malformed
     * record is caught and degraded so it can't 500 the page.
     *
     * @param  string|array<string, mixed>|null  $body
     */
    public static function render(string|array|null $body): string
    {
        if (blank($body)) {
            return '';
        }

        try {
            return RichContentRenderer::make($body)
                ->customBlocks([YouTubeEmbedBlock::class])
                ->toUnsafeHtml();
        } catch (Throwable $e) {
            // One bad body must not take down the page; log it and degrade to the
            // raw string (or nothing) rather than surfacing a 500.
            report($e);

            return is_string($body) ? $body : '';
        }
    }
}
