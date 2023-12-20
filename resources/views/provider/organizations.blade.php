@extends('layouts.app')

@section('page_title', 'Manage Users')

@section('content')

@include('layouts.provider_sidebar')

<div class="table-responsive">
    <table id="usersTable" class="table">
        <thead>
            <tr>
                <th>Sr No.</th>
                <th>Name</th>
                <th>Address</th>
                <th>GST No.</th>
                <th>Mobile No.</th>
                <th>Email</th>
                <th>Contact Person</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($organizations as $key => $organization)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $organization->org_name }}</td>
                <td>{{ $organization->address }}</td>
                <td>{{ $organization->gst_no }}</td>
                <td>{{ $organization->mobile_no }}</td>
                <td>{{ $organization->org_email }}</td>
                <td>{{ $organization->contact_person }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
