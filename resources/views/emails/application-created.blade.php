<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application created</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 24px; }
        .box { background: #f8fafc; border-left: 4px solid #3b82f6; padding: 16px; margin: 16px 0; }
        .footer { margin-top: 24px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <p>Hello {{ $application->student->full_name ?? 'Student' }},</p>
        <p>A new application has been created for you.</p>
    </div>

    <div class="box">
        <p><strong>Application ID:</strong> {{ $application->application_id }}</p>
        <p><strong>University:</strong> {{ $application->university->name ?? '—' }}</p>
        <p><strong>Intake:</strong> {{ $application->intake ?? '—' }}</p>
        @if($application->course_name)
        <p><strong>Course:</strong> {{ $application->course_name }}</p>
        @endif
    </div>

    <p>If you have any questions, please contact your counselor or our office.</p>

    <div class="footer">
        <p>This is an automated message from {{ config('app.name') }}.</p>
    </div>
</body>
</html>
