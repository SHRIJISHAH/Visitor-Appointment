<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <!-- Add your CSS and JavaScript dependencies here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <h2>QR Code Scanner</h2>

        <!-- Video feed container for the camera -->
        <div id="camera-feed"></div>

        <!-- Result container to display the scanned QR code -->
        <div id="result"></div>

        <!-- Add your form to submit the QR code content -->
        <form id="qrCodeForm">
            @csrf
            <input type="hidden" id="content" name="content">
            <button type="submit">Log Scan</button>
        </form>

        <!-- Include QuaggaJS library -->
        <script src="https://cdn.rawgit.com/serratus/quaggaJS/0.12.1/dist/quagga.min.js"></script>

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
                document.querySelector("#content").value = code;
            });

            // Handle form submission
            $("#qrCodeForm").submit(function (e) {
                e.preventDefault();

                // Get the form data
                const formData = $(this).serialize();

                // Make an AJAX request to log the QR code scan
                $.ajax({
                    type: "POST",
                    url: "/log-qr-code-scan",
                    data: formData,
                    success: function (response) {
                        alert(response.message);
                        // You can add additional logic here
                    },
                    error: function (error) {
                        alert("Error logging QR code scan.");
                    },
                });
            });
        </script>
    </div>
</body>

</html>
