<?php

declare(strict_types=1);

use App\RichEditor\YouTubeEmbedBlock;

// getId / getLabel

it('has the expected stable identifier', function () {
    expect(YouTubeEmbedBlock::getId())->toBe('youtube-embed');
});

it('returns a human-readable label', function () {
    expect(YouTubeEmbedBlock::getLabel())->toBe('YouTube Video');
});

// toHtml — URL parsing

it('renders an iframe for a full youtube.com watch URL', function () {
    $html = YouTubeEmbedBlock::toHtml(['url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'], []);

    expect($html)
        ->toContain('iframe')
        ->toContain('https://www.youtube.com/embed/dQw4w9WgXcQ');
});

it('renders an iframe for a shortened youtu.be URL', function () {
    $html = YouTubeEmbedBlock::toHtml(['url' => 'https://youtu.be/dQw4w9WgXcQ'], []);

    expect($html)
        ->toContain('iframe')
        ->toContain('https://www.youtube.com/embed/dQw4w9WgXcQ');
});

it('renders an iframe for a youtube.com embed URL', function () {
    $html = YouTubeEmbedBlock::toHtml(['url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'], []);

    expect($html)
        ->toContain('iframe')
        ->toContain('https://www.youtube.com/embed/dQw4w9WgXcQ');
});

it('prefers $data url over $config url when both are present', function () {
    $html = YouTubeEmbedBlock::toHtml(
        ['url' => 'https://youtu.be/AAAAAAAAAAAA'],
        ['url' => 'https://youtu.be/dQw4w9WgXcQ'],
    );

    expect($html)->toContain('dQw4w9WgXcQ');
});

it('returns null when the URL is missing', function () {
    expect(YouTubeEmbedBlock::toHtml([], []))->toBeNull();
});

it('returns null when the URL does not contain a recognisable video ID', function () {
    expect(YouTubeEmbedBlock::toHtml(['url' => 'https://example.com/not-a-video'], []))->toBeNull();
});

it('includes required iframe sandbox attributes', function () {
    $html = YouTubeEmbedBlock::toHtml(['url' => 'https://youtu.be/dQw4w9WgXcQ'], []);

    expect($html)
        ->toContain('allowfullscreen')
        ->toContain('allow="accelerometer');
});

// toPreviewHtml

it('returns a placeholder when no url is configured yet', function () {
    $html = YouTubeEmbedBlock::toPreviewHtml([]);

    expect($html)
        ->toContain('YouTube embed')
        ->not->toContain('iframe');
});

it('returns a live iframe preview when a valid url is configured', function () {
    $html = YouTubeEmbedBlock::toPreviewHtml(['url' => 'https://youtu.be/dQw4w9WgXcQ']);

    expect($html)
        ->toContain('iframe')
        ->toContain('dQw4w9WgXcQ');
});

it('returns a placeholder when the configured url is not a valid youtube url', function () {
    $html = YouTubeEmbedBlock::toPreviewHtml(['url' => 'https://example.com']);

    expect($html)
        ->not->toContain('iframe');
});
