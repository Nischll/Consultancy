<?php

namespace App\Mail;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DocumentRemovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Document $document
    ) {
        $this->document->load('student');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Document removed: ' . $this->document->title . ' - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.document-removed',
        );
    }
}
