<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasPublicUlid;
use Database\Factories\VideoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * A YouTube video embed. We keep only the video ID and derive the thumbnail
 * URL from it — no video files are ever stored locally (requirements 5.4).
 */
class Video extends Model
{
    /** @use HasFactory<VideoFactory> */
    use HasFactory;

    use HasPublicUlid;

    /**
     * Clear home page video cache on save or delete.
     */
    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('home.latest_videos'));
        static::deleted(fn () => Cache::forget('home.latest_videos'));
    }

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'youtube_video_id',
        'is_featured',
        'description',
        'published_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'published_at' => 'immutable_datetime',
        ];
    }

    /**
     * Scope a query to only include featured videos.
     *
     * @param \Illuminate\Database\Eloquent\Builder<Video> $query
     */
    public function scopeFeatured($query): void
    {
        $query->where('is_featured', true);
    }

    /**
     * YouTube-hosted thumbnail derived from the video ID (nothing stored on our side).
     */
    public function thumbnailUrl(): string
    {
        return "https://img.youtube.com/vi/{$this->youtube_video_id}/hqdefault.jpg";
    }
}
