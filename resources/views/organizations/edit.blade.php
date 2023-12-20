<?php

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Organization') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ url('/organization/' . $organization->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="org_name">{{ __('Organization Name') }}</label>
                                <input id="org_name" type="text" class="form-control @error('org_name') is-invalid @enderror" name="org_name" value="{{ old('org_name', $organization->org_name) }}" required autocomplete="org_name" autofocus>

                                @error('org_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Add other fields (address, gst_no, mobile_no, org_email, contact_person) -->

                            <button type="submit" class="btn btn-primary">
                                {{ __('Update Organization') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
