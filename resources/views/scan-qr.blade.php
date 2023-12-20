<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <!-- Include QuaggaJS library -->
    <script src="https://cdn.rawgit.com/serratus/quaggaJS/0.12.1/dist/quagga.min.js"></script>
</head>
<body>
    <h2>QR Code Scanner</h2>
    <!-- Video feed container for the camera -->
    <div id="camera-feed"></div>

    <!-- Result container to display the scanned QR code -->
    <div id="result"></div>

    <!-- Form for submitting the scanned QR code -->
    <form action="{{ route('scan-qr.process') }}" method="post" id="scanForm">
        @csrf
        <input type="hidden" name="scanned_code" id="scannedCode">
    </form>

    <script>
        // Set up QuaggaJS
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector("#camera-feed"),
            },
            decoder: {
                readers: ["code_128_reader", "ean_reader", "ean_8_reader", "code_39_reader", "code_39_vin_reader", "codabar_reader", "upc_reader", "upc_e_reader", "i2of5_reader"],
            },
        });

        // Start the scanner
        Quagga.start();

        // Handle the scan result
        Quagga.onDetected((result) => {
            const code = result.codeResult.code;
            document.querySelector("#result").innerText = `Scanned QR Code: ${code}`;

            // Set the scanned code in the hidden input field
            document.querySelector("#scannedCode").value = code;

            // Submit the form
            document.querySelector("#scanForm").submit();
        });
    </script>
</body>
</html>
