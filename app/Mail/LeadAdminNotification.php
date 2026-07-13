<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Notifies Ohene that a new lead came in, so nothing gets lost to a mailbox.
 */
class LeadAdminNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create the notification for a specific lead.
     */
    public function __construct(public Lead $lead)
    {
        $this->onQueue('emails');
    }

    /**
     * Get the message envelope, keyed to the lead's contact so replies work.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New project inquiry from '.$this->lead->name,
            replyTo: [$this->lead->email],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.lead.admin-notification',
        );
    }
}
