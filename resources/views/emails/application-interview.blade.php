<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview scheduled</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 24px; }
        .box { background: #f0fdf4; border-left: 4px solid #22c55e; padding: 16px; margin: 16px 0; }
        .footer { margin-top: 24px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <p>Hello {{ $application->student->full_name ?? 'Student' }},</p>
        <p>Your application has been updated with interview information.</p>
    </div>

    <div class="box">
        <p><strong>Application ID:</strong> {{ $application->application_id }}</p>
        <p><strong>University:</strong> {{ $application->university->name ?? '—' }}</p>
        <p><strong>Intake:</strong> {{ $application->intake ?? '—' }}</p>
        <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $application->status ?? '—')) }}</p>
        @if($application->interview_date)
        <p><strong>Interview date & time:</strong> {{ $application->interview_date->format('l, F j, Y \a\t g:i A') }}</p>
        @endif
        @if($application->interview_mode)
        <p><strong>Interview mode:</strong> {{ $application->interview_mode }}</p>
        @endif
        @if($application->interview_notes)
        <p><strong>Notes:</strong></p>
        <p style="white-space: pre-wrap;">{{ $application->interview_notes }}</p>
        @endif
    </div>

    <p>Please be prepared and contact your counselor if you have any questions.</p>

    <div class="footer">
        <p>This is an automated message from {{ config('app.name') }}.</p>
    </div>
</body>
</html>
