<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasPublicUlid;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

/**
 * A blog category. Groups posts and drives the "related posts" recommendation.
 */
class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    use HasPublicUlid;

    /**
     * Clear home page post cache when a category changes.
     */
    protected static function booted(): void
    {
        static::saved(function (): void {
            Cache::forget('home.latest_posts');
            Post::query()->pluck('slug')->each(function (string $slug): void {
                Cache::forget("blog.show.{$slug}");
            });
        });

        static::deleted(function (): void {
            Cache::forget('home.latest_posts');
            Post::query()->pluck('slug')->each(function (string $slug): void {
                Cache::forget("blog.show.{$slug}");
            });
        });
    }

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Posts filed under this category.
     *
     * @return HasMany<Post, $this>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
