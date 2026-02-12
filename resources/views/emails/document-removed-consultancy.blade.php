<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document removed</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 24px; }
        .box { background: #f8fafc; border-left: 4px solid #64748b; padding: 16px; margin: 16px 0; }
        .footer { margin-top: 24px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <p>A document has been removed from records.</p>
    </div>

    <div class="box">
        <p><strong>Document:</strong> {{ $document->title }}</p>
        <p><strong>Type:</strong> {{ $document->document_type }}</p>
        <p><strong>Student:</strong> {{ $document->student->full_name ?? '—' }} ({{ $document->student->student_id ?? '—' }})</p>
    </div>

    <div class="footer">
        <p>This is an automated message from {{ config('app.name') }}.</p>
    </div>
</body>
</html>
