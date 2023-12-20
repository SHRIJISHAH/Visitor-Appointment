<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    public function show($id)
    {
        // Fetch organization details and display them
        $organization = Organization::findOrFail($id);
        return view('organizations.show', compact('organization'));
    }

    public function edit($id)
    {
        // Fetch organization details for editing
        $organization = Organization::findOrFail($id);
        return view('organizations.edit', compact('organization'));
    }

    public function update(Request $request, $id)
    {
        // Validate and update organization details
        $request->validate([
            'org_name' => 'required|string|max:255',
            'address' => 'required|string',
            'gst_no' => 'required|string|max:15|unique:organizations,gst_no,' . $id,
            'mobile_no' => 'required|string|max:15|unique:organizations,mobile_no,' . $id,
            'org_email' => 'required|email|unique:organizations,org_email,' . $id,
            'contact_person' => 'required|string|max:255',
        ]);

        $organization = Organization::findOrFail($id);
        $organization->update($request->all());

        return redirect('/organization/' . $id)->with('success', 'Organization details updated successfully.');
    }

    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();

        // You need to implement the logic to delete the related superadmin here

        return redirect('/')->with('success', 'Organization deleted successfully.');
    }
}
