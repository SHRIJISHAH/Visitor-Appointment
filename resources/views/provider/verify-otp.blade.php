@extends('layouts.reg-log')

@section('content')
<div class="onboarding">

    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif

    <div class="logo">
        <img src="{{ asset('img/logo.png') }}" alt="Image Alt Text" class="img-fluid">
    </div>

    <form method="POST" action="{{ url('/provider/verify-otp') }}">
        @csrf

        <input type="number" class="num" name="login_mobile_no" value="{{ session('login_mobile_no') }}" readonly>

        <input id="otp" type="text" class="form-control @error('otp') is-invalid @enderror" name="otp" required
            placeholder="Enter OTP" autofocus>

        @error('otp')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <button type="submit" class="gen-otp">
            {{ __('Verify OTP') }}
        </button>
    </form>
</div>

@endsection
