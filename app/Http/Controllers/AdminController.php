<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function showDashboard()
    {
        return view('admin.dashboard');
    }

    public function showRegistrationFormOnDashboard()
    {
        return view('admin.dashboard')->with('registeringAdmin', true);
    }

    public function logoutAdmin()
    {
        Auth::guard('admin')->logout();

        return redirect('/login')->with('success', 'Admin logged out successfully.');
    }

    public function showAddUserForm()
    {
        return view('admin.add-user');
    }

    public function addUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'mobile_no' => 'required|string|max:15|unique:users',
            'designation' => 'required|string|max:255',
            'department' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile_no' => $request->input('mobile_no'),
            'designation' => $request->input('designation'),
            'department' => $request->input('department'),
        ]);

        return redirect('/admin/dashboard')->with('success', 'User added successfully.');
    }
    public function showAllUsers()
    {
        $users = User::all();
        return view('admin.dashboard')->with(['showAllUsers' => true, 'users' => $users]);
    }

    public function manageUsers()
    {
        $users = User::all();
        return view('admin.manage-users', ['users' => $users]);
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.show-user', ['user' => $user]);
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', ['user' => $user]);
    }
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'mobile_no' => 'required|string|max:15|unique:users,mobile_no,' . $user->id,
            'designation' => 'required|string|max:255',
            'department' => 'required|string|max:255',
        ]);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile_no' => $request->input('mobile_no'),
            'designation' => $request->input('designation'),
            'department' => $request->input('department'),
        ]);

        return redirect('/admin/dashboard')->with('success', 'User updated successfully.');
    }

    public function deleteUserConfirmation($id)
    {
        $user = User::findOrFail($id);
        return view('admin.delete-user', ['user' => $user]);
    }

    public function confirmDeleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/admin/dashboard')->with('success', 'User deleted successfully.');
    }

    public function showAllAppointments()
    {
        $appointments = Appointment::all();

        return view('admin.all-appointments', ['appointments' => $appointments]);
    }

    public function showRegistrationForm()
    {
        return view('admin.reg');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins|unique:users',
            'mobile_no' => 'required|string|max:15|unique:admins|unique:users',
            'role' => 'required|in:admin,user',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
        ]);

        // Check if the logged-in user is an admin
        if (Auth::guard('admin')->check()) {
            if ($request->input('role') === 'admin') {
                // Registration logic for admins
                $admin = Admin::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'mobile_no' => $request->input('mobile_no'),
                ]);

                return redirect('/admin/dashboard')->with('success', 'Admin registered successfully.');
            } else {
                // Registration logic for users
                $user = User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'mobile_no' => $request->input('mobile_no'),
                    'designation' => $request->input('designation'),
                    'department' => $request->input('department'),
                ]);

                return redirect('/admin/dashboard')->with('success', 'User registered successfully.');
            }
        } else {
            // Redirect if the user is not an admin
            return redirect('/admin/login')->with('error', 'You do not have permission to perform this action.');
        }
    }

}
