<?php

namespace App\Mail;

use App\Models\Communication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommunicationToStudentMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Communication $communication
    ) {
        $this->communication->load(['student', 'user']);
    }

    public function envelope(): Envelope
    {
        $subject = $this->communication->subject
            ?: ('Message from ' . config('app.name'));
        $replyTo = $this->communication->user?->email ?? config('mail.from.address');
        return new Envelope(
            subject: $subject,
            replyTo: [$replyTo],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.communication-to-student',
        );
    }
}
