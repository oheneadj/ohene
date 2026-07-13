<?php

namespace App\Models;

use App\Concerns\HasPublicUlid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasPublicUlid;

    protected $fillable = [
        'question',
        'answer',
        'display_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'display_order' => 'integer',
        ];
    }

    /**
     * Scope a query to only include active FAQs.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }
}
