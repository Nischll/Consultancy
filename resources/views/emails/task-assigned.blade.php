<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task assigned</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 24px; }
        .box { background: #f8fafc; border-left: 4px solid #3b82f6; padding: 16px; margin: 16px 0; }
        .footer { margin-top: 24px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <p>Hello {{ $task->assignedTo->name ?? 'there' }},</p>
        <p>You have been assigned a new task.</p>
    </div>

    <div class="box">
        <p><strong>Task:</strong> {{ $task->title }}</p>
        @if($task->description)
        <p><strong>Description:</strong></p>
        <p style="white-space: pre-wrap;">{{ $task->description }}</p>
        @endif
        <p><strong>Type:</strong> {{ ucfirst($task->type ?? '—') }}</p>
        <p><strong>Priority:</strong> {{ ucfirst($task->priority ?? '—') }}</p>
        @if($task->due_date)
        <p><strong>Due date:</strong> {{ $task->due_date->format('M d, Y') }}</p>
        @endif
        @if($task->student)
        <p><strong>Student:</strong> {{ $task->student->full_name }} ({{ $task->student->student_id ?? '—' }})</p>
        @endif
        @if($task->assignedBy)
        <p><strong>Assigned by:</strong> {{ $task->assignedBy->name }}</p>
        @endif
    </div>

    <p>Please complete this task by the due date.</p>

    <div class="footer">
        <p>This is an automated message from {{ config('app.name') }}.</p>
    </div>
</body>
</html>
