<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Application $application
    ) {
        $this->application->load(['student', 'university']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application updated: ' . $this->application->application_id . ' - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.application-updated',
        );
    }
}
