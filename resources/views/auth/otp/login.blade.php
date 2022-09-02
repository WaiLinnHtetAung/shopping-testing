@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4">
                <h1>{{ trans('panel.site_title') }}</h1>

                <p class="text-muted">OTP Login</p>

                @if(session('message'))
                    <div class="alert alert-info" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                {{-- -----wrong phone message----- --}}
                @if(session('pherror'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{session('pherror')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form method="POST" action="{{route('otp#get')}}">
                    @csrf

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa-solid fa-phone"></i>
                            </span>
                        </div>

                        <input id="phone" name="phone" type="number" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" required autocomplete="phone" autofocus placeholder="Enter your registered phone..." value="{{ old('phone', null) }}">

                        @if($errors->has('phone'))
                            <div class="invalid-feedback">
                                {{ $errors->first('phone') }}
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary px-4">
                                Get OTP
                            </button>

                            {{-- ----login with otp----  --}}
                            <a href="{{url('/login')}}">Login with Email</a>
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
