<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment QR Code</title>
</head>

<body>
    <h1>Appointment QR Code</h1>

    @if(session('url'))
        <div>Appointment URL: <a href="{{ session('url') }}">{{ session('url') }}</a></div>
    @endif

    @if($appointment->qr_code)
        <img src="{{ asset($appointment->qr_code) }}" alt="QR Code">
    @else
        No QR Code available
    @endif

</body>

</html>
