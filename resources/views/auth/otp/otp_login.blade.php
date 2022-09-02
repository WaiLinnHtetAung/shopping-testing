@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4">
                <h1>{{ trans('panel.site_title') }}</h1>

                <p class="text-muted">OTP Login</p>

                @if(session('otp'))
                    <div class="alert alert-info" role="alert">
                        {{ session('otp') }}
                    </div>
                @endif

                {{-- -----wrong otp message----- --}}
                @if(session('wrongOtp'))
                    <div class="alert alert-danger" role="alert">
                          {{ session('wrongOtp') }}
                    </div>
                @endif

                  {{-- -----expire otp message----- --}}
                  @if(session('expireOtp'))
                  <div class="alert alert-danger" role="alert">
                      {{ session('expireOtp') }}
                  </div>
              @endif


                {{-- -----error otp message----- --}}
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{route('otp#getLogin')}}">
                    @csrf

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa-solid fa-key"></i>
                            </span>
                        </div>
                        <input type="hidden" name="user_id" value="{{$user_id}}">
                        <input id="otp" name="otp" type="number" class="form-control{{ $errors->has('otp') ? ' is-invalid' : '' }}" required autocomplete="otp" autofocus placeholder="Enter your OTP ..." value="{{ old('otp', null) }}">

                        @if($errors->has('otp'))
                            <div class="invalid-feedback">
                                {{ $errors->first('otp') }}
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary px-4">
                                Login
                            </button>


                        </div>


                        {{-- <div class="col-6 text-right">
                            @if(Route::has('password.request'))
                                <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                    {{ trans('global.forgot_password') }}
                                </a><br>
                            @endif

                        </div> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
