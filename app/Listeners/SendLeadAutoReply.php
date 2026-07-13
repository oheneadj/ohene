<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\LeadSubmitted;
use App\Mail\LeadAutoReply;
use Illuminate\Support\Facades\Mail;

/**
 * Single side effect: send the submitter a confirmation that their message
 * arrived. The mailable is queued, so this listener just hands the work off.
 */
class SendLeadAutoReply
{
    /**
     * Send the auto-reply to the person who submitted the lead.
     */
    public function handle(LeadSubmitted $event): void
    {
        Mail::to($event->lead->email)
            ->send(new LeadAutoReply($event->lead));
    }
}
