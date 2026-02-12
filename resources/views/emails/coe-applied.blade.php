<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COE applied</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 24px; }
        .box { background: #f8fafc; border-left: 4px solid #059669; padding: 16px; margin: 16px 0; }
        .footer { margin-top: 24px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <p>Hello {{ $application->student->full_name ?? 'Student' }},</p>
        <p>Confirmation of Entry (COE) has been applied for your application.</p>
    </div>

    <div class="box">
        <p><strong>Application ID:</strong> {{ $application->application_id }}</p>
        <p><strong>University:</strong> {{ $application->university->name ?? '—' }}</p>
        <p><strong>Intake:</strong> {{ $application->intake ?? '—' }}</p>
        <p><strong>COE status:</strong> {{ ucfirst(str_replace('_', ' ', $application->coe_status ?? 'applied')) }}</p>
        @if($application->coe_applied_date)
        <p><strong>COE applied date:</strong> {{ $application->coe_applied_date->format('M d, Y') }}</p>
        @endif
    </div>

    <p>If you have any questions, please contact your counselor or our office.</p>

    <div class="footer">
        <p>This is an automated message from {{ config('app.name') }}.</p>
    </div>
</body>
</html>
