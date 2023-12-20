@extends('layouts.app')

@section('page_title', 'Manage Admins')

@section('content')

@include('layouts.admin_sidebar')

<div class="table-responsive">
    <table id="usersTable" class="table">
        <thead>
            <tr>
                <th>Sr No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile No.</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $key => $admin)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->mobile_no }}</td>
                <td>
                    <a href="{{ route('superadmin.show-admin', ['id' => $admin->id]) }}" class="btn btn-info a-btn-slide-text">
                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('superadmin.edit-admin', ['id' => $admin->id]) }}" class="btn btn-warning a-btn-slide-text">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('superadmin.delete-admin', ['id' => $admin->id]) }}" class="btn btn-danger a-btn-slide-text"
                        onclick="return confirm('Are you sure?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
