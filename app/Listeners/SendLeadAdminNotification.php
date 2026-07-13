<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\LeadSubmitted;
use App\Mail\LeadAdminNotification;
use Illuminate\Support\Facades\Mail;

/**
 * Single side effect: email Ohene about a new lead. The mailable is queued, so
 * this listener just hands the work off (see LeadAdminNotification).
 */
class SendLeadAdminNotification
{
    /**
     * Send the admin notification for the submitted lead.
     */
    public function handle(LeadSubmitted $event): void
    {
        Mail::to(config('mail.lead_recipient'))
            ->send(new LeadAdminNotification($event->lead));
    }
}
