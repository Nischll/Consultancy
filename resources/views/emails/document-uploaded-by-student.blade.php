<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document uploaded by student</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 24px; }
        .box { background: #f8fafc; border-left: 4px solid #3b82f6; padding: 16px; margin: 16px 0; }
        .footer { margin-top: 24px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <p>A student has uploaded a new document for review.</p>
    </div>

    <div class="box">
        <p><strong>Student:</strong> {{ $document->student->full_name ?? '—' }}</p>
        <p><strong>Student ID:</strong> {{ $document->student->student_id ?? '—' }}</p>
        <p><strong>Student email:</strong> {{ $document->student->email ?? '—' }}</p>
        <p><strong>Document type:</strong> {{ $document->document_type }}</p>
        <p><strong>Title:</strong> {{ $document->title }}</p>
        <p><strong>File name:</strong> {{ $document->file_name ?? '—' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($document->status) }}</p>
    </div>

    <p>Please review this document in your admin panel.</p>

    <div class="footer">
        <p>This is an automated message from {{ config('app.name') }}.</p>
    </div>
</body>
</html>
