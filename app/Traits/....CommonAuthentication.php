<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

trait CommonAuthentication
{
    protected function processLogin($modelClass, $mobileNumber, $defaultOtp, $guard, $redirectPath)
    {
        $user = $modelClass::where('mobile_no', $mobileNumber)->first();

        if ($user) {
            Session::put('mobileNumber', $user->mobile_no);
            Session::put('otp', $defaultOtp);

            $redirectTo = $guard ? "/{$guard}/verify-otp" : '/verify-otp';

            return redirect($redirectTo)->with(['success' => 'Please verify your OTP.', 'login_mobile_no' => $mobileNumber]);
        } else {
            $redirectPath = $guard ? "/{$guard}/login" : '/login';
            return redirect($redirectPath)->with('error', 'User not found. Please register first.');
        }
    }

    protected function verifyOtpAndLogin($modelClass, $redirectPath)
    {
        $validator = Validator::make(request()->all(), [
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return redirect($redirectPath)
                ->withErrors($validator)
                ->withInput();
        }

        $enteredOtp = $validator->validated()['otp'];
        $sentOtp = Session::get('otp');

        if ($sentOtp === $enteredOtp) {
            Session::forget('otp');

            $user = $modelClass::where('mobile_no', Session::get('mobileNumber'))->first();
            Auth::login($user);

            return redirect($redirectPath)->with('success', 'OTP verified successfully. You are now logged in.');
        } else {
            return redirect($redirectPath)->with('error', 'Invalid OTP. Please try again.');
        }
    }
}
