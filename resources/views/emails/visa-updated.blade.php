<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visa application updated</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 24px; }
        .box { background: #f8fafc; border-left: 4px solid #3b82f6; padding: 16px; margin: 16px 0; }
        .footer { margin-top: 24px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <p>Hello {{ $visaApplication->student->full_name ?? 'Student' }},</p>
        <p>Your visa application has been updated.</p>
    </div>

    <div class="box">
        <p><strong>Visa application ID:</strong> {{ $visaApplication->visa_application_id }}</p>
        <p><strong>Visa type:</strong> {{ $visaApplication->visa_type ?? '—' }}</p>
        <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $visaApplication->status ?? '—')) }}</p>
        @if($visaApplication->application)
        <p><strong>University:</strong> {{ $visaApplication->application->university->name ?? '—' }}</p>
        @endif
    </div>

    <p>If you have any questions, please contact your counselor or our office.</p>

    <div class="footer">
        <p>This is an automated message from {{ config('app.name') }}.</p>
    </div>
</body>
</html>
