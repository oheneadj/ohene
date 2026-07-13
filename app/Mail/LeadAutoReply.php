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
 * Confirmation sent to the person who submitted the contact form, so they know
 * the message arrived and roughly when to expect a reply (requirements 5.5).
 */
class LeadAutoReply extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create the auto-reply for a specific lead.
     */
    public function __construct(public Lead $lead)
    {
        $this->onQueue('emails');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thanks for reaching out — I\'ll be in touch',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.lead.auto-reply',
        );
    }
}
