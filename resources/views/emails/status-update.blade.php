<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status update</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 24px; }
        .box { background: #f8fafc; border-left: 4px solid #3b82f6; padding: 16px; margin: 16px 0; }
        .footer { margin-top: 24px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <p>Hello {{ $recipientName }},</p>
        <p>This is to inform you that the status of your <strong>{{ ucfirst($entityType) }}</strong> has been updated.</p>
    </div>

    <div class="box">
        <p><strong>Reference:</strong> {{ $entityIdentifier }}</p>
        <p><strong>Previous status:</strong> {{ $oldStatus ? ucfirst(str_replace('_', ' ', $oldStatus)) : '—' }}</p>
        <p><strong>New status:</strong> {{ ucfirst(str_replace('_', ' ', $newStatus)) }}</p>
    </div>

    <p>If you have any questions, please contact your counselor or our office.</p>

    <div class="footer">
        <p>This is an automated message from {{ config('app.name') }}.</p>
    </div>
</body>
</html>
