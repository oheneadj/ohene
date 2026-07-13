<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Lead;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Fired when a new contact-form lead is captured. Drives the follow-up side
 * effects (admin notification + auto-reply) through single-purpose listeners.
 */
class LeadSubmitted
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance for the submitted lead.
     */
    public function __construct(public Lead $lead) {}
}
