@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add New Organization</h2>
        <form method="post" action="{{ route('provider.create-organization') }}">
            @csrf
            <div class="form-group">
                <label for="org_name">Organization Name:</label>
                <input type="text" class="form-control" id="org_name" name="org_name" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address" required></textarea>
            </div>
            <div class="form-group">
                <label for="gst_no">GST Number:</label>
                <input type="text" class="form-control" id="gst_no" name="gst_no" required>
            </div>
            <div class="form-group">
                <label for="mobile_no">Mobile Number:</label>
                <input type="text" class="form-control" id="mobile_no" name="mobile_no" required>
            </div>
            <div class="form-group">
                <label for="org_email">Organization Email:</label>
                <input type="email" class="form-control" id="org_email" name="org_email" required>
            </div>
            <div class="form-group">
                <label for="contact_person">Contact Person:</label>
                <input type="text" class="form-control" id="contact_person" name="contact_person" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
