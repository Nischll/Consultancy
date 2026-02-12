<?php

namespace App\Mail;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DocumentStatusConsultancyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Document $document,
        public string $status
    ) {
        $this->document->load(['student', 'verifiedBy']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Document ' . $status . ': ' . $this->document->title . ' - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.document-status-consultancy',
        );
    }
}
