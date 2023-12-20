@extends('layouts.reg-log')

@section('content')
<div class="onboarding">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="logo">
        <img src="{{ asset('img/logo.png') }}" alt="Image Alt Text" class="img-fluid">
    </div>
    <form action="{{ url('/login') }}" method="post">
        @csrf
        <input type="text" name="mobile_no" placeholder="Mobile Number" value="{{ old('mobile_no') }}" required>
        <button type="submit" class="gen-otp">Login</button>
    </form>
</div>
@endsection
