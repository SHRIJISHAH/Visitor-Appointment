<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public function showScanner()
    {
        return view('scan');
    }

    public function uploadQRCode(Request $request)
    {
        $request->validate([
            'qrCodeFile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $request->file('qrCodeFile');
        $imageName = 'uploaded_qr_code.' . $image->getClientOriginalExtension();
        $image->move(public_path('qrcodes'), $imageName);

        return redirect()->route('qr-code-scanner')->with('success', 'QR Code uploaded successfully!');
    }

    public function getQRCodeDetails()
    {
        try {
            $qrCodeDetails = QRCodeDetails::firstOrFail(); // Adjust this based on your database structure
            return view('qr_code_details', compact('qrCodeDetails'));
        } catch (\Exception $e) {
            return redirect()->route('qr-code-scanner')->with('error', 'QR Code details not found.');
        }
    }
}
