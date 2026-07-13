<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasPublicUlid;
use App\Enums\BudgetRange;
use App\Enums\LeadStatus;
use App\Enums\ProjectType;
use Database\Factories\LeadFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A contact-form submission. Read-only in the admin; the UTM/referrer fields
 * record where the lead came from so we can measure what converts (MR2).
 */
class Lead extends Model
{
    /** @use HasFactory<LeadFactory> */
    use HasFactory;

    use HasPublicUlid;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'message',
        'project_type',
        'budget_range',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'referrer',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'project_type' => ProjectType::class,
            'budget_range' => BudgetRange::class,
            'status' => LeadStatus::class,
        ];
    }
}
