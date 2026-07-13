<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\LeadStatus;
use App\Events\LeadSubmitted;
use App\Models\Lead;

/**
 * Creates a contact-form lead and kicks off the follow-up side effects
 * (admin notification + auto-reply) via the LeadSubmitted event.
 */
class CreateLeadAction
{
    /**
     * Persist a new lead from validated form data and captured request source.
     *
     * @param  array<string, string|null>  $data
     */
    public function execute(array $data): Lead
    {
        $lead = Lead::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'message' => $data['message'],
            'project_type' => $data['project_type'] ?? null,
            'budget_range' => $data['budget_range'] ?? null,
            'utm_source' => $data['utm_source'] ?? null,
            'utm_medium' => $data['utm_medium'] ?? null,
            'utm_campaign' => $data['utm_campaign'] ?? null,
            'referrer' => $data['referrer'] ?? null,
            'status' => LeadStatus::New,
        ]);

        LeadSubmitted::dispatch($lead);

        return $lead;
    }
}
