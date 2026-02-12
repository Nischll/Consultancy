<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document status update</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 24px; }
        .box { background: #f8fafc; border-left: 4px solid #3b82f6; padding: 16px; margin: 16px 0; }
        .verified { border-left-color: #059669; }
        .rejected { border-left-color: #dc2626; }
        .footer { margin-top: 24px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <p>Hello {{ $document->student->full_name ?? 'Student' }},</p>
        @if($status === 'verified')
        <p>Your document has been <strong>verified</strong>.</p>
        @else
        <p>Your document has been <strong>rejected</strong>. Please review the reason below and re-upload if needed.</p>
        @endif
    </div>

    <div class="box {{ $status === 'verified' ? 'verified' : 'rejected' }}">
        <p><strong>Document:</strong> {{ $document->title }}</p>
        <p><strong>Type:</strong> {{ $document->document_type }}</p>
        <p><strong>Status:</strong> {{ ucfirst($status) }}</p>
        @if($status === 'rejected' && $document->rejection_reason)
        <p><strong>Reason:</strong> {{ $document->rejection_reason }}</p>
        @endif
        @if($document->verified_at)
        <p><strong>Date:</strong> {{ $document->verified_at->format('M d, Y') }}</p>
        @endif
    </div>

    <p>If you have any questions, please contact your counselor or our office.</p>

    <div class="footer">
        <p>This is an automated message from {{ config('app.name') }}.</p>
    </div>
</body>
</html>
