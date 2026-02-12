<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message from consultancy</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 24px; }
        .box { background: #f8fafc; border-left: 4px solid #3b82f6; padding: 16px; margin: 16px 0; }
        .footer { margin-top: 24px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <p>Hello {{ $communication->student->full_name ?? 'Student' }},</p>
        <p>You have a new message from {{ config('app.name') }}.</p>
    </div>

    @if($communication->subject)
    <p><strong>Subject:</strong> {{ $communication->subject }}</p>
    @endif

    <div class="box">
        <p style="white-space: pre-wrap;">{{ $communication->content }}</p>
    </div>

    @if($communication->user)
    <p>— {{ $communication->user->name }}</p>
    @endif

    <div class="footer">
        <p>This message was sent from {{ config('app.name') }}. You can reply to this email.</p>
    </div>
</body>
</html>
