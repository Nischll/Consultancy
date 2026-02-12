<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Student $student
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome – Your student account has been created: ' . $this->student->student_id . ' - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.student-created',
        );
    }
}
