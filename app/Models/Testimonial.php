<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasPublicUlid;
use App\Enums\TestimonialStatus;
use Database\Factories\TestimonialFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

/**
 * A client testimonial. Only approved ones are shown publicly — submissions
 * stay pending until Ohene signs off (requirements 5.3).
 */
class Testimonial extends Model
{
    /** @use HasFactory<TestimonialFactory> */
    use HasFactory;

    use HasPublicUlid;

    /**
     * Clear associated work show page cache when testimonials change.
     */
    protected static function booted(): void
    {
        static::saved(function (Testimonial $testimonial): void {
            if ($testimonial->project_id) {
                $project = Project::find($testimonial->project_id);
                if ($project) {
                    Cache::forget("work.show.{$project->slug}");
                }
            }
        });

        static::deleted(function (Testimonial $testimonial): void {
            if ($testimonial->project_id) {
                $project = Project::find($testimonial->project_id);
                if ($project) {
                    Cache::forget("work.show.{$project->slug}");
                }
            }
        });
    }

    /**
     * @var list<string>
     */
    protected $fillable = [
        'project_id',
        'client_name',
        'role',
        'company',
        'quote',
        'avatar',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => TestimonialStatus::class,
        ];
    }

    /**
     * The project this testimonial relates to, if any.
     *
     * @return BelongsTo<Project, $this>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Only testimonials cleared for public display.
     *
     * @param  Builder<Testimonial>  $query
     */
    public function scopeApproved(Builder $query): void
    {
        $query->where('status', TestimonialStatus::Approved);
    }
}
