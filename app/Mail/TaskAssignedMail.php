<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Task $task
    ) {
        $this->task->load(['student', 'application', 'assignedTo', 'assignedBy']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You have been assigned a task: ' . $this->task->title . ' - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.task-assigned',
        );
    }
}
