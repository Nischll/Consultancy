<?php

namespace App\Mail;

use App\Models\Communication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommunicationSentConsultancyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Communication $communication
    ) {
        $this->communication->load(['student', 'user']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Communication sent: ' . ($this->communication->subject ?: 'Message') . ' - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.communication-sent-consultancy',
        );
    }
}
