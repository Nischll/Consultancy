<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentDoneMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Payment $payment
    ) {
        $this->payment->load(['student', 'application.university']);
    }

    public function envelope(): Envelope
    {
        $status = $this->payment->status === 'completed' ? 'Payment completed' : 'Payment received';
        return new Envelope(
            subject: $status . ': ' . $this->payment->payment_id . ' - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-done',
        );
    }
}
