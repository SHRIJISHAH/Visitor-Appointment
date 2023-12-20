@extends('layouts.reg-log')

@section('content')
<div class="onboarding">

        <div class="logo">
            <img src="{{ asset('img/logo.png') }}" alt="Image Alt Text" class="img-fluid">
        </div>

    <form method="POST" action="{{ url('/superadmin/login') }}">
        @csrf

        <input id="username" type="text" class="@error('username') is-invalid @enderror" name="username"
            value="{{ old('username') }}" placeholder="Username" required autofocus>

        @error('username')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password"
            placeholder="Password" required>

        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <button type="submit" class="gen-otp">
            {{ __('Login') }}
        </button>

        @if (Route::has('password.request'))
        <a class="btn btn-link" href="{{ route('password.request') }}">
            {{ __('Forgot Your Password?') }}
        </a>
        @endif
    </form>
</div>
@endsection
