<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasPublicUlid;
use Database\Factories\VideoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'youtube_video_id',
        'description',
        'published_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'immutable_datetime',
        ];
    }

    /**
     * YouTube-hosted thumbnail derived from the video ID (nothing stored on our side).
     */
    public function thumbnailUrl(): string
    {
        return "https://img.youtube.com/vi/{$this->youtube_video_id}/hqdefault.jpg";
    }
}
