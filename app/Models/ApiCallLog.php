<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Audit log of outbound third-party API calls, per CLAUDE.md Section 21.
 * Captures request/response payloads for tracking external service integrations.
 * Payloads are encrypted at rest to protect potential secrets.
 */
class ApiCallLog extends Model
{
    protected $guarded = [];

    protected $casts = [
        'request_payload' => 'encrypted:array',
        'response_payload' => 'encrypted:array',
        'status_code' => 'integer',
    ];
}
