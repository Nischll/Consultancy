<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskCreatedConsultancyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Task $task
    ) {
        $this->task->load(['student', 'assignedTo', 'assignedBy']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New task created: ' . $this->task->title . ' - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.task-created-consultancy',
        );
    }
}
