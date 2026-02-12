<?php

namespace App\Mail;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DocumentStatusMail extends Mailable
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
        $subject = $this->status === 'verified'
            ? 'Document verified: ' . $this->document->title . ' - ' . config('app.name')
            : 'Document update: ' . $this->document->title . ' - ' . config('app.name');
        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.document-status',
        );
    }
}
