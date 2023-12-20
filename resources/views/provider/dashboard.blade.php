@extends('layouts.app')

@section('page_title', 'Dashboard')

@section('content')

@include('layouts.provider_sidebar')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Provider Dashboard</div>

                    <div class="card-body">
                        <p>Welcome, {{ Auth::guard('provider')->user()->name }}!</p>

                        <a href="{{ route('provider.showForm') }}" class="btn btn-primary">Add New Organization</a>

                        <a href="{{ route('provider.organizations') }}">View All Organizations</a>

                        <a href="{{ route('provider.showSuperadmins') }}">View Superadmins</a>

                        <hr>

                        <!-- Display success or error messages -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
