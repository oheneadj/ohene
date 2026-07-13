<?php

declare(strict_types=1);

use App\Models\Video;

it('derives the thumbnail URL from the YouTube video ID', function () {
    $video = Video::factory()->create(['youtube_video_id' => 'dQw4w9WgXcQ']);

    expect($video->thumbnailUrl())->toBe('https://img.youtube.com/vi/dQw4w9WgXcQ/hqdefault.jpg');
});
