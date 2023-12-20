<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Details</title>
    <!-- Include any additional styles or scripts you might need -->
</head>
<body>
    <div class="container">
        <h2>QR Code Details</h2>

        @if (isset($qrCodeDetails))
            <img src="{{ asset($qrCodeDetails->image_path) }}" alt="QR Code Image">
            <p>Details: {{ $qrCodeDetails->details }}</p>
            <!-- Add any other details you want to display -->
        @else
            <p>No QR Code details found.</p>
        @endif

        <a href="{{ route('qr-code-scanner') }}" class="btn btn-primary">Back to QR Code Scanner</a>
    </div>
    <!-- Include any additional scripts you might need -->
</body>
</html>
