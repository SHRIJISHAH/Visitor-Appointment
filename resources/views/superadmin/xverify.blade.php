<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superadmin Verification</title>
</head>
<body>

    <h1>Superadmin Verification</h1>

    <p>Hello Superadmin,</p>

    <p>Please click the link below to verify your account:</p>

    <a href="{{ route('superadmin.verify', ['token' => $superadmin->verification_token]) }}">
        Verify your account
    </a>

    <p>If you did not request this verification, please ignore this email.</p>

</body>
</html>
