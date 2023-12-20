<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AppointmentController extends Controller
{
    private $qrCode;

    public function __construct(QrCode $qrCode)
    {
        $this->qrCode = $qrCode;
    }

    public function showCalendar()
    {
        return view('appointment.calendar');
    }

    public function showForm()
    {
        return view('appointment.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'name' => 'required|string|max:255',
            'mobile_no' => 'required|string',
            'category' => 'required|in:Meeting,Event,Service',
        ]);

        $appointment = Appointment::create([
            'event_name' => $request->input('event_name'),
            'description' => $request->input('description'),
            'date' => $request->input('date'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'name' => $request->input('name'),
            'mobile_no' => $request->input('mobile_no'),
            'category' => $request->input('category'),
            'user_id' => Auth::id(),
        ]);

        $qrCodeData = [
            'event_name' => $appointment->event_name,
            'description' => $appointment->description,
            'date' => $appointment->date,
            'start_time' => $appointment->start_time,
            'end_time' => $appointment->end_time,
            'name' => $appointment->name,
            'mobile_no' => $appointment->mobile_no,
            'category' => $appointment->category,
        ];

        $qrCodePath = 'qrcodes/appointment_' . $appointment->id . '.png';
        \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(200)->generate(json_encode($qrCodeData), public_path($qrCodePath));

        $appointment->update(['qr_code' => $qrCodePath]);

        $urlToken = Str::random(32);
        $appointment->update(['url_token' => $urlToken]);

        $appointmentUrl = route('appointment.show', ['token' => $urlToken]);

        return redirect()->route('appointment.qrcode', ['token' => $urlToken])
            ->with('success', 'Appointment scheduled successfully!')
            ->with('url', $appointmentUrl);
    }

    public function showByToken($token)
    {
        try {
            $appointment = Appointment::where('url_token', $token)
                ->where('user_id', Auth::id()) // Check if the appointment belongs to the authenticated user
                ->firstOrFail();

            return view('appointment.qrcode', compact('appointment'));
        } catch (ModelNotFoundException $exception) {
            return redirect()->route('calendar')->with('error', 'Appointment not found.');
        }
    }


    public function showQRCode($token)
    {
        try {
            $appointment = Appointment::where('url_token', $token)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            return view('appointment.qrcode', compact('appointment'));
        } catch (ModelNotFoundException $exception) {
            return redirect()->route('calendar')->with('error', 'Appointment not found.');
        }
    }


    public function getAppointmentsByDate($date)
    {
        $user = Auth::user(); // Get the authenticated user

        $appointments = DB::table('appointments')
            ->where('user_id', $user->id) // Filter by user_id
            ->whereDate('date', '=', $date)
            ->get();

        return response()->json($appointments);
    }

    public function logoutUser()
    {
        Auth::guard('user')->logout();

        return redirect('/login')->with('success', 'User logged out successfully.');
    }
}
