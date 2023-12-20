@extends('layouts.app')

@include('layouts.admin_sidebar')

@section('content')
    <div class="container">
        <h2>Delete Admin</h2>

        <p>Are you sure you want to delete the admin "{{ $admin->name }}"?</p>

        <form method="post" action="{{ route('superadmin.confirm-delete-admin', ['id' => $admin->id]) }}">
            @csrf
            @method('DELETE')

            <button type="submit">Yes, Delete Admin</button>
        </form>

        <a href="{{ route('superadmin.manage-admins') }}">Cancel</a>
    </div>
@endsection
