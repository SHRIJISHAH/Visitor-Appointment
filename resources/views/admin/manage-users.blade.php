@extends('layouts.app')

@section('page_title', 'Manage Users')

@section('content')

@include('layouts.sidebar')

<div class="table-responsive">
    <table id="usersTable" class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile Number</th>
                <th>Designation</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $key => $user)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile_no }}</td>
                <td>{{ $user->designation }}</td>
                <td>{{ $user->department }}</td>
                <td>
                    <a href="{{ route('admin.show-user', ['id' => $user->id]) }}" class="btn btn-info a-btn-slide-text">
                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('admin.edit-user', ['id' => $user->id]) }}" class="btn btn-warning a-btn-slide-text">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('admin.delete-user', ['id' => $user->id]) }}" class="btn btn-danger a-btn-slide-text"
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
