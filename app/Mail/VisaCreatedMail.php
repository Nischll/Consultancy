<?php

namespace App\Mail;

use App\Models\VisaApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VisaCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public VisaApplication $visaApplication
    ) {
        $this->visaApplication->load(['student', 'application.university']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Visa application created: ' . $this->visaApplication->visa_application_id . ' - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.visa-created',
        );
    }
}
