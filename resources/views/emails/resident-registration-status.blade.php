<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Status</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #1f2937;">
    <p>Dear {{ $resident->name }},</p>

    @if($status === 'approved')
        <p>Your registration request has been <strong>approved</strong> by the Barangay Bagacay administrator.</p>
        <p>You may now access your account using this website link:</p>
        <p>
            <a href="{{ $loginUrl }}" style="color: #2563eb;">{{ $loginUrl }}</a>
        </p>
        <p>If you have trouble signing in, please contact the barangay administrator.</p>
    @else
        <p>Your registration request has been <strong>rejected</strong> by the Barangay Bagacay administrator.</p>
        <p><strong>Reason for rejection:</strong> {{ $reason }}</p>
        <p>Please correct the issue and submit a new registration request.</p>
    @endif

    <p>Thank you.</p>
    <p>Barangay Bagacay Administration</p>
</body>
</html>
