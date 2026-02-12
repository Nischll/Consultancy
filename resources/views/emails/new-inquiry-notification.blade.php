<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New inquiry</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 24px; }
        .box { background: #f8fafc; border-left: 4px solid #3b82f6; padding: 16px; margin: 16px 0; }
        .footer { margin-top: 24px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <p>A new inquiry has been submitted from your website.</p>
    </div>

    <div class="box">
        <p><strong>Inquiry ID:</strong> {{ $inquiry->inquiry_id ?? '—' }}</p>
        <p><strong>From:</strong> {{ $inquiry->name }}</p>
        <p><strong>Email:</strong> {{ $inquiry->email }}</p>
        @if($inquiry->phone)
        <p><strong>Phone:</strong> {{ $inquiry->phone }}</p>
        @endif
        <p><strong>Subject:</strong> {{ $inquiry->subject }}</p>
        <p><strong>Type:</strong> {{ ucfirst($inquiry->type ?? 'general') }}</p>
        <p><strong>Source:</strong> {{ $inquiry->source ?? 'Website' }}</p>
        <hr style="margin: 12px 0; border: 0; border-top: 1px solid #e2e8f0;">
        <p><strong>Message:</strong></p>
        <p style="white-space: pre-wrap;">{{ $inquiry->message }}</p>
    </div>

    <p>Please respond to this inquiry from your admin panel or by replying to {{ $inquiry->email }}.</p>

    <div class="footer">
        <p>This is an automated message from {{ config('app.name') }}.</p>
    </div>
</body>
</html>
