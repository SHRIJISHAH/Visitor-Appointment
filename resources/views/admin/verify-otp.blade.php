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

        <form method="POST" action="{{ route('admin.verify-otp') }}">
            @csrf
            <input type="number" class="num" name="login_mobile_no" value="{{ session('login_mobile_no') }}" readonly>
            <input id="otp" type="number" class="element @error('otp') is-invalid @enderror" name="otp" placeholder="Enter OTP" required autocomplete="off">
            @error('otp')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <button type="submit" class="gen-otp">LOGIN VIA OTP</button>
        </form>
    </div>
@endsection




<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto Sans' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
<div class="container">
        <div class="onboarding">
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="logo">
                <img src="{{ asset('img/logo.png') }}" alt="Image Alt Text" class="img-fluid">
            </div>

            <form method="POST" action="{{ route('admin.verify-otp') }}">
                @csrf
                <input type="number" class="num" name="login_mobile_no" value="{{ session('login_mobile_no') }}" readonly>
                <input id="otp" type="number" class="element @error('otp') is-invalid @enderror" name="otp" placeholder="Enter OTP" required autocomplete="off">
                @error('otp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <button type="submit" class="gen-otp">LOGIN VIA OTP</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WyPIvz9zqz2byFfllJi9p4g0unwNGJh6g"
        crossorigin="anonymous"></script>
</body>

</html> -->
