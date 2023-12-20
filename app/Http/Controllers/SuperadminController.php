<?php

namespace App\Http\Controllers;

use App\Models\Superadmin;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SuperadminController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:superadmins',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect('/superadmin/register')
                ->withErrors($validator)
                ->withInput();
        }

        $superadmin = Superadmin::create([
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            'verification_token' => Str::uuid(), // Ensure you use the Str class
            'status' => 'initiated',
        ]);

        Auth::guard('superadmin')->login($superadmin);

        // Use the updated method to send verification email
        $this->sendVerificationEmailToSuperadmin($superadmin);

        return redirect('/superadmin/dashboard')->with('success', 'Superadmin registered and logged in successfully.');
    }

    public function showDashboard()
    {
        return view('superadmin.dashboard');
    }

    public function manageAdmins()
    {
        $admins = Admin::all();
        return view('superadmin.manage-admins', ['admins' => $admins]);
    }

    public function editAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        return view('superadmin.edit-admin', compact('admin'));
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            // Add other validation rules as needed
        ]);

        $admin->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            // Update other fields as needed
        ]);

        return redirect()->route('superadmin.manage-admins')->with('success', 'Admin updated successfully.');
    }

    public function showAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        return view('superadmin.show-admin', compact('admin'));
    }

    public function deleteAdminConfirmation($id)
    {
        $admin = Admin::findOrFail($id);
        return view('superadmin.delete-admin', compact('admin'));
    }

    public function confirmDeleteAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('superadmin.manage-admins')->with('success', 'Admin deleted successfully.');
    }

    public function showVerificationForm()
    {
        return view('superadmin.verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'token' => 'required|exists:superadmins,verification_token',
            'mobile_no' => 'required|string', // Add any other validation rules as needed
        ]);

        $token = $request->input('token');
        $mobileNo = $request->input('mobile_no');

        // Find the Superadmin by the verification token
        $superadmin = Superadmin::where('verification_token', $token)->first();

        if (!$superadmin) {
            return redirect()->route('superadmin.showVerificationForm')->with('error', 'Invalid verification token.');
        }

        // Verify mobile number
        if ($superadmin->mobile_no === $mobileNo) {
            // Update Superadmin status to 'verified'
            $superadmin->update(['status' => 'verified']);

            return redirect('/superadmin/dashboard')->with('success', 'Superadmin verified successfully.');
        } else {
            return redirect()->route('superadmin.showVerificationForm')->with('error', 'Invalid mobile number.');
        }
    }

    // Superadmin Logout
    public function logout()
    {
        Auth::guard('superadmin')->logout();

        return redirect('/login')->with('success', 'Superadmin logged out successfully.');
    }
}
