<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\GeneratesCoverThumbnail;
use App\Concerns\HasPublicUlid;
use App\Concerns\RecordsSlugRedirects;
use App\Contracts\RedirectsOnSlugChange;
use App\Enums\PostStatus;
use App\Exceptions\PostNotPublishableException;
use Carbon\CarbonImmutable;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

/**
 * A blog post. Public visibility depends on both the status and a past
 * `published_at`, so scheduled posts don't leak early.
 *
 * @property PostStatus $status
 * @property CarbonImmutable|null $published_at
 * @property string|array<string, mixed> $body Stored as a JSON string in the DB; Filament's ->json() mode
 *                                             sets this to an array during the saving event before serialising.
 */
class Post extends Model implements RedirectsOnSlugChange
{
    use GeneratesCoverThumbnail;

    /** @use HasFactory<PostFactory> */
    use HasFactory;

    use HasPublicUlid;
    use RecordsSlugRedirects;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'cover_image_thumbnail',
        'cover_image_alt',
        'read_time',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'og_image',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => PostStatus::class,
            'published_at' => 'immutable_datetime',
            'read_time' => 'integer',
        ];
    }

    /**
     * Public URLs bind by slug for SEO and 1:1 parity with the old static site
     * (requirements Section 3, MG2).
     */
    public function publicPathPrefix(): string
    {
        return 'blog';
    }

    /**
     * Only redirect a changed slug once the post has actually been published —
     * a draft's URL isn't indexed yet, so there's nothing to preserve (FR18).
     */
    public function slugRedirectsEnabled(): bool
    {
        return $this->getOriginal('status') === PostStatus::Published;
    }

    /**
     * On save: keep read time derived from the body, and enforce the
     * content-quality gate before a post is allowed to go public.
     */
    protected static function booted(): void
    {
        static::saving(function (Post $post): void {
            if ($post->isDirty('body')) {
                $post->read_time = $post->estimatedReadTime();
            }

            if ($post->status === PostStatus::Published) {
                $post->assertPublishable();
            }
        });

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
     * Guard the publish gate (requirements FR17): a published post needs a
     * slug, a meta description, and alt text for any cover image it carries.
     *
     * @throws PostNotPublishableException
     */
    public function assertPublishable(): void
    {
        $missing = [];

        if (blank($this->slug)) {
            $missing[] = 'a slug';
        }

        if (blank($this->meta_description)) {
            $missing[] = 'a meta description';
        }

        if (filled($this->cover_image) && blank($this->cover_image_alt)) {
            $missing[] = 'cover image alt text';
        }

        if ($missing !== []) {
            throw PostNotPublishableException::missing($missing);
        }
    }

    /**
     * Estimate reading time in whole minutes from the body word count,
     * assuming ~200 words per minute (floor of one minute).
     *
     * The body may be stored as Tiptap JSON (when the editor uses ->asJson())
     * or as legacy HTML. We detect the format and extract plain text from
     * whichever is present before counting words.
     *
     * @return positive-int
     */
    public function estimatedReadTime(): int
    {
        $body = $this->body;

        // Filament's ->json() mode passes the Tiptap state as a PHP array
        // directly to the model attribute before serialising and saving.
        // After a database read, it arrives as a JSON string. Legacy posts
        // are plain HTML strings.
        if (is_array($body)) {
            $text = $this->extractTextFromTiptap($body);
        } else {
            $body = (string) $body;
            $decoded = json_decode($body, true);
            $text = (json_last_error() === JSON_ERROR_NONE && is_array($decoded))
                ? $this->extractTextFromTiptap($decoded)
                : strip_tags($body);
        }

        $words = str_word_count($text);

        return max(1, (int) ceil($words / 200));
    }

    /**
     * Recursively walk a Tiptap node tree and collect all text leaf values.
     * Used to extract readable text from JSON-encoded rich-text bodies.
     *
     * @param  array<string, mixed>  $node
     */
    private function extractTextFromTiptap(array $node): string
    {
        if (isset($node['text'])) {
            return (string) $node['text'];
        }

        $text = '';
        foreach ($node['content'] ?? [] as $child) {
            $text .= ' '.$this->extractTextFromTiptap($child);
        }

        return $text;
    }

    /**
     * The category this post belongs to.
     *
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Limit to posts that are actually live: published status and a due date.
     *
     * @param  Builder<Post>  $query
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('status', PostStatus::Published)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Is this specific post live to the public right now? Mirrors the
     * `published` scope for a single loaded model (e.g. route-bound posts).
     */
    public function isPublic(): bool
    {
        return $this->status === PostStatus::Published
            && $this->published_at !== null
            && $this->published_at->isPast();
    }

    /**
     * OG image for social sharing, falling back to the cover image (requirements 5.1).
     */
    public function ogImage(): ?string
    {
        return $this->og_image ?? $this->cover_image;
    }
}
