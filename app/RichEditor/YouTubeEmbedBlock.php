<?php

/**
 * Custom RichEditor block that lets editors embed YouTube videos inside blog post bodies.
 *
 * The block is stored as a structured marker in the Tiptap JSON — not raw HTML — so the
 * iframe is only rendered at display time via RichContentRenderer::toUnsafeHtml(). This
 * keeps the stored content clean and portable while still producing a real embed on-screen.
 */

declare(strict_types=1);

namespace App\RichEditor;

use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\TextInput;

/**
 * A Filament RichEditor custom block for embedding YouTube videos.
 *
 * Registered on the Post RichEditor via ->customBlocks([YouTubeEmbedBlock::class]).
 * On the frontend, the body must be rendered through RichContentRenderer (not raw
 * {!! $post->body !!}) so that block markers are resolved into iframes.
 */
class YouTubeEmbedBlock extends RichContentCustomBlock
{
    /**
     * Unique identifier stored in the Tiptap JSON alongside the config.
     * Must be stable — changing this would break existing saved posts.
     */
    public static function getId(): string
    {
        return 'youtube-embed';
    }

    /**
     * Label shown in the custom blocks picker panel inside the editor.
     */
    public static function getLabel(): string
    {
        return 'YouTube Video';
    }

    /**
     * Converts the stored block config into the rendered iframe HTML shown on the frontend.
     * Returns null when the URL is missing or unparseable (block is silently skipped).
     *
     * @param  array<string, mixed>  $config  Block config saved by the editor form.
     * @param  array<string, mixed>  $data  Optional runtime data injected at render time.
     */
    public static function toHtml(array $config, array $data): ?string
    {
        $url = $data['url'] ?? $config['url'] ?? null;

        if (blank($url)) {
            return null;
        }

        $videoId = static::extractVideoId((string) $url);

        if (blank($videoId)) {
            return null;
        }

        return <<<HTML
        <div class="relative w-full aspect-video my-6 rounded-xl overflow-hidden shadow-lg">
            <iframe
                class="absolute inset-0 w-full h-full"
                src="https://www.youtube.com/embed/{$videoId}"
                title="YouTube video"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen
            ></iframe>
        </div>
        HTML;
    }

    /**
     * Renders a live preview of the embed inside the Filament editor panel.
     * Falls back to a placeholder tile when the URL hasn't been set yet.
     *
     * @param  array<string, mixed>  $config  Current block config (may be empty on first open).
     */
    public static function toPreviewHtml(array $config): ?string
    {
        $url = $config['url'] ?? null;
        $videoId = $url ? static::extractVideoId((string) $url) : null;

        if (blank($videoId)) {
            return '<div style="padding:1rem;background:#f1f5f9;border-radius:.5rem;text-align:center;color:#64748b;font-family:sans-serif;">🎬 YouTube embed — paste a URL to preview</div>';
        }

        return <<<HTML
        <div style="position:relative;width:100%;padding-bottom:56.25%;border-radius:.5rem;overflow:hidden;background:#000;">
            <iframe
                style="position:absolute;inset:0;width:100%;height:100%;"
                src="https://www.youtube.com/embed/{$videoId}"
                title="YouTube video preview"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
            ></iframe>
        </div>
        HTML;
    }

    /**
     * Configures the modal form that pops up when an editor inserts or edits this block.
     * Accepts any standard YouTube URL format — full, shortened (youtu.be), or embed URLs.
     */
    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalHeading('Embed YouTube Video')
            ->modalWidth('lg')
            ->form([
                TextInput::make('url')
                    ->label('YouTube URL')
                    ->placeholder('https://www.youtube.com/watch?v=...')
                    ->url()
                    ->required()
                    ->helperText('Paste any YouTube video URL — full URL, shortened (youtu.be), or embed URL.'),
            ]);
    }

    /**
     * Extracts the 11-character video ID from any supported YouTube URL format.
     * Returns null when the URL doesn't match a known YouTube pattern.
     */
    protected static function extractVideoId(string $url): ?string
    {
        // youtu.be/ID (shortened share links)
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return $m[1];
        }

        // youtube.com/watch?v=ID, /embed/ID, or /v/ID
        if (preg_match('/(?:v=|\/embed\/|\/v\/)([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return $m[1];
        }

        return null;
    }
}
