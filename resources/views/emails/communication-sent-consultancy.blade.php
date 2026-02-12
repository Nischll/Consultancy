<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communication sent</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 24px; }
        .box { background: #f8fafc; border-left: 4px solid #3b82f6; padding: 16px; margin: 16px 0; }
        .footer { margin-top: 24px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <p>A communication has been recorded.</p>
    </div>

    <div class="box">
        <p><strong>Student:</strong> {{ $communication->student->full_name ?? '—' }} ({{ $communication->student->student_id ?? '—' }})</p>
        <p><strong>Type:</strong> {{ ucfirst($communication->type) }}</p>
        <p><strong>Direction:</strong> {{ ucfirst($communication->direction) }}</p>
        @if($communication->subject)
        <p><strong>Subject:</strong> {{ $communication->subject }}</p>
        @endif
        @if($communication->user)
        <p><strong>Sent by:</strong> {{ $communication->user->name }}</p>
        @endif
        <hr style="margin: 12px 0; border: 0; border-top: 1px solid #e2e8f0;">
        <p><strong>Content:</strong></p>
        <p style="white-space: pre-wrap;">{{ \Illuminate\Support\Str::limit($communication->content, 500) }}</p>
    </div>

    <div class="footer">
        <p>This is an automated message from {{ config('app.name') }}.</p>
    </div>
</body>
</html>
