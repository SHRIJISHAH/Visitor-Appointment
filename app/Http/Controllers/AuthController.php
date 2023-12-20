<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $mobileNumber = $request->input('mobile_no');

        // Check in the User table
        $user = \App\Models\User::where('mobile_no', $mobileNumber)->first();

        // Check in the Admins table
        $admin = \App\Models\Admin::where('mobile_no', $mobileNumber)->first();

        // Check in the Superadmins table
        $superadmin = \App\Models\Superadmin::where('mobile_no', $mobileNumber)->first();

        if ($user) {
            // User exists, generate and store OTP for the user
            $otp = 123456;
            Session::put('otp', $otp);
            Session::put('userType', 'user');
        } elseif ($admin) {
            // Admin exists, generate and store OTP for the admin
            $otp = 567890;
            Session::put('otp', $otp);
            Session::put('userType', 'admin');
        } elseif ($superadmin) {
            // Superadmin exists, generate and store OTP for the superadmin
            $otp = 456789;
            Session::put('otp', $otp);
            Session::put('userType', 'superadmin');
        } else {
            // User not found, redirect back with an error message
            return redirect('/login')->with('error', 'Invalid mobile number');
        }

        // Redirect to the OTP verification page
        return redirect('/verify-otp')->with('mobileNumber', $mobileNumber);
    }

    public function showOtpVerificationForm()
    {
        return view('verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $otpInput = $request->input('otp');
        $storedOtp = Session::get('otp');
        $userType = Session::get('userType');

        if ($otpInput == $storedOtp) {
            // OTP is correct, log in the user based on user type
            switch ($userType) {
                case 'user':
                    Auth::guard('user')->loginUsingId(1); // Change this based on your user ID
                    return redirect('/appointment/calendar');
                case 'admin':
                    Auth::guard('admin')->loginUsingId(1); // Change this based on your admin ID
                    return redirect('/admin/dashboard');
                case 'superadmin':
                    Auth::guard('superadmin')->loginUsingId(1); // Change this based on your superadmin ID
                    return redirect('/superadmin/dashboard');
            }
        } else {
            // Invalid OTP, redirect back with an error message
            return redirect('/verify-otp')->with('error', 'Invalid OTP');
        }
    }
}
