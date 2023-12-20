@extends('layouts.reg-log')

@section('content')
<div class="onboarding">
        @if(session('error'))
            <div style="color: red;">{{ session('error') }}</div>
        @endif

        <div class="logo">
            <img src="{{ asset('img/logo.png') }}" alt="Image Alt Text" class="img-fluid">
        </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ url('/provider/login') }}">
                            @csrf

                            <input id="mobile_no" type="text" class="@error('mobile_no') is-invalid @enderror" name="mobile_no" placeholder="Mobile No." value="{{ old('mobile_no') }}" required autofocus>

                                    @error('mobile_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <button type="submit" class="gen-otp">
                                        {{ __('Generate OTP') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
