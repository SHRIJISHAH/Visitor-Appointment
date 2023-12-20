<!-- Form -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Form</title>
</head>

<body>
    <h1>Appointment Form</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <form action="/appointment" method="POST">
        @csrf
        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" required><br><br>

        <label for="time">Time:</label><br>
        <input type="time" id="time" name="time" required><br><br>

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="mobile_no">Mobile Number:</label><br>
        <input type="text" id="mobile_no" name="mobile_no" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br><br>

        <input type="submit" value="Schedule Appointment">
    </form>
</body>

</html>








<!-- Controller -->

<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function showForm()
    {
        return view('appointment.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'name' => 'required|string|max:255',
            'mobile_no' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
        ]);

        // Create an appointment record
        $appointment = Appointment::create([
            'date' => $request->input('date'),
            'time' => $request->input('time'),
            'name' => $request->input('name'),
            'mobile_no' => $request->input('mobile_no'),
            'email' => $request->input('email'),
            'description' => $request->input('description'),
            'user_id' => Auth::id(),
        ]);

        // Generate QR code with appointment details
        $qrCode = QrCode::size(400)->generate(json_encode($appointment->toArray()));

        // Save the QR code as an image file
        $qrCodePath = 'qrcodes/appointment_' . $appointment->id . '.png';
        file_put_contents(public_path($qrCodePath), $qrCode);

        // Update the appointment record with the QR code path
        $appointment->update(['qr_code' => $qrCodePath]);

        return redirect('/appointment')->with('success', 'Appointment scheduled successfully!');
    }
}
