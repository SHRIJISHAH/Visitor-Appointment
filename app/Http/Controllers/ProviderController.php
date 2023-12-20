<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\Superadmin;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Mail\SuperadminVerification;
use Illuminate\Support\Facades\Mail;

class ProviderController extends Controller
{
    // Provider Login
    public function showLoginForm()
    {
        return view('provider.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect('/provider/login')
                ->withErrors($validator)
                ->withInput();
        }

        $mobileNumber = $validator->validated()['mobile_no'];
        $defaultOtp = '234567'; // Default OTP for providers

        // Store mobile number and OTP in session for verification
        Session::put('mobileNumber', $mobileNumber);
        Session::put('otp', $defaultOtp);

        return redirect('/provider/verify-otp')->with(['success' => 'Please verify your OTP.', 'login_mobile_no' => $mobileNumber]);
    }

    // Provider OTP Verification
    public function showOtpVerificationForm()
    {
        return view('provider.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return redirect('/provider/login')
                ->withErrors($validator)
                ->withInput();
        }

        $enteredOtp = $validator->validated()['otp'];
        $sentOtp = Session::get('otp');

        if ($sentOtp === $enteredOtp) {
            Session::forget('otp');

            // Check if the provider with the given mobile number exists
            $provider = Provider::where('mobile_no', Session::get('mobileNumber'))->first();

            if ($provider) {
                Auth::guard('provider')->login($provider);

                return redirect('/provider/dashboard')->with('success', 'OTP verified successfully. You are now logged in.');
            } else {
                return redirect('/provider/login')->with('error', 'Provider not found. Please register first.');
            }
        } else {
            return redirect('/provider/login')->with('error', 'Invalid OTP. Please try again.');
        }
    }

    // Provider Dashboard and Logout
    public function dashboard()
    {
        return view('provider.dashboard');
    }

    public function logoutProvider()
    {
        Auth::guard('provider')->logout();

        return redirect('/provider/login')->with('success', 'Provider logged out successfully.');
    }

    public function showForm()
    {
        return view('provider.create_organization');
    }

    public function addOrganization(Request $request)
    {
        $request->validate([
            'org_name' => 'required|string|max:255',
            'address' => 'required|string',
            'gst_no' => 'required|string|max:15|unique:organizations',
            'mobile_no' => 'required|string|max:15|unique:organizations',
            'org_email' => 'required|email|unique:organizations',
            'contact_person' => 'required|string|max:255',
        ]);

        // Generate org_id based on the current count of organizations
        $orgCount = Organization::count() + 1;
        $orgId = 'org' . $orgCount;

        // Create a new organization
        $organization = Organization::create([
            'org_id' => $orgId,
            'org_name' => $request->input('org_name'),
            'address' => $request->input('address'),
            'gst_no' => $request->input('gst_no'),
            'mobile_no' => $request->input('mobile_no'),
            'org_email' => $request->input('org_email'),
            'contact_person' => $request->input('contact_person'),
        ]);

        // Create a new superadmin with a username based on the organization email
        $superadmin = Superadmin::create([
            'username' => $organization->org_email,
            'mobile_no' => $organization->mobile_no,
            'password' => Hash::make(Str::random(8)),
            'verification_token' => Str::uuid(),
            'status' => 'initiated',
        ]);

        // Update the organization with the superadmin's ID
        $organization->update([
            'superadmin_id' => $superadmin->id,
        ]);

        // Send the verification email
        $this->sendVerificationEmailToSuperadmin($superadmin);

        return redirect()->route('provider.dashboard')->with('success', 'Organization created successfully.');
    }

    public function showOrganizations()
    {
        $organizations = Organization::all();
        return view('provider.organizations', compact('organizations'));
    }

    public function showSuperadmins()
    {
        // Fetch all superadmins
        $superadmins = Superadmin::all();

        // Display the superadmins on the provider dashboard
        return view('provider.show-superadmins', ['superadmins' => $superadmins]);
    }

    protected function sendVerificationEmailToSuperadmin($superadmin)
{
    // Generate the verification link with the correct route and token
    $verificationLink = route('superadmin.verify', ['token' => $superadmin->verification_token]);

    // Pass the verification link, superadmin, and OTP to the SuperadminVerification Mailable
    Mail::to($superadmin->username)->send(new SuperadminVerification($verificationLink, $superadmin, '456789'));
}

}
