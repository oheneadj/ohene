<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasPublicUlid;
use App\Concerns\RecordsSlugRedirects;
use App\Contracts\RedirectsOnSlugChange;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A case study / portfolio project. `featured` surfaces it on the Home page;
 * ordering across the Work listing is controlled by `display_order`.
 */
class Project extends Model implements RedirectsOnSlugChange
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    use HasPublicUlid;
    use RecordsSlugRedirects;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'tagline',
        'challenge',
        'build',
        'impact',
        'tech_stack',
        'cover_image',
        'cover_image_alt',
        'live_url',
        'repo_url',
        'featured',
        'display_order',
        'meta_title',
        'meta_description',
        'og_image',
        'gallery',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tech_stack' => 'array',
            'featured' => 'boolean',
            'display_order' => 'integer',
            'gallery' => 'array',
        ];
    }

    /**
     * Public URLs bind by slug for SEO and 1:1 parity with the old static site
     * (requirements Section 3, MG2) — the ULID still identifies the record in
     * the admin. Overrides the ULID key from HasPublicUlid for this model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Public case studies live under /work/{slug}.
     */
    public function publicPathPrefix(): string
    {
        return 'work';
    }

    /**
     * Testimonials linked to this project.
     *
     * @return HasMany<Testimonial, $this>
     */
    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    /**
     * Only projects flagged for the Home page preview.
     *
     * @param  Builder<Project>  $query
     */
    public function scopeFeatured(Builder $query): void
    {
        $query->where('featured', true);
    }

    /**
     * Apply the admin-defined display order (then newest as a tiebreaker).
     *
     * @param  Builder<Project>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('display_order')->orderByDesc('created_at');
    }

    /**
     * OG image for social sharing, falling back to the cover image.
     */
    public function ogImage(): ?string
    {
        return $this->og_image ?? $this->cover_image;
    }
}
