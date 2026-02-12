<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment received</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 24px; }
        .box { background: #f8fafc; border-left: 4px solid #059669; padding: 16px; margin: 16px 0; }
        .footer { margin-top: 24px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <p>Hello {{ $payment->student->full_name ?? 'Student' }},</p>
        @if($payment->status === 'completed')
        <p>Your payment has been completed. Thank you!</p>
        @else
        <p>We have received your payment. Details are below.</p>
        @endif
    </div>

    <div class="box">
        <p><strong>Payment ID:</strong> {{ $payment->payment_id }}</p>
        <p><strong>Type:</strong> {{ $payment->payment_type }}</p>
        <p><strong>Description:</strong> {{ $payment->description }}</p>
        <p><strong>Amount:</strong> {{ $payment->currency }} {{ number_format($payment->amount, 2) }}</p>
        <p><strong>Paid:</strong> {{ $payment->currency }} {{ number_format($payment->paid_amount, 2) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
        @if($payment->application)
        <p><strong>Application:</strong> {{ $payment->application->application_id ?? '—' }} ({{ $payment->application->university->name ?? '—' }})</p>
        @endif
        @if($payment->paid_date)
        <p><strong>Paid date:</strong> {{ $payment->paid_date->format('M d, Y') }}</p>
        @endif
    </div>

    <p>If you have any questions, please contact your counselor or our office.</p>

    <div class="footer">
        <p>This is an automated message from {{ config('app.name') }}.</p>
    </div>
</body>
</html>
