<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response to your inquiry</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 24px; }
        .subject { font-size: 18px; font-weight: bold; color: #1e40af; margin-bottom: 16px; }
        .message { background: #f8fafc; border-left: 4px solid #3b82f6; padding: 16px; margin: 16px 0; white-space: pre-wrap; }
        .footer { margin-top: 24px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <p>Hello {{ $inquiry->name }},</p>
        <p>Thank you for your inquiry. Here is our response:</p>
    </div>

    <div class="subject">Re: {{ $inquiry->subject }}</div>

    <div class="message">{{ $responseMessage }}</div>

    <p>If you have any further questions, please reply to this email or contact us directly.</p>

    <div class="footer">
        <p>This is an automated message from {{ config('app.name') }}.</p>
    </div>
</body>
</html>
