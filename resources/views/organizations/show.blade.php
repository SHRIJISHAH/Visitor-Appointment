<?php

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Organization Details') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <h2>{{ $organization->org_name }}</h2>
                        <p>{{ $organization->address }}</p>
                        <!-- Display other organization details here -->

                        <a href="{{ url('/organization/' . $organization->id . '/edit') }}" class="btn btn-primary">{{ __('Edit') }}</a>
                        <form action="{{ url('/organization/' . $organization->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">{{ __('Delete') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
