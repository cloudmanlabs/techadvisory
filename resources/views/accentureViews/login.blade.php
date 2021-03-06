@extends('layouts.base')

@section('content')
<div class="main-wrapper" style="margin-top: 10vh;">
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">
            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-8 col-xl-6 mx-auto">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-4 pr-md-0">
                                <div class="auth-left-wrapper">
                                </div>
                            </div>

                            <div class="col-md-8 pl-md-0">
                                <div class="auth-form-wrapper px-4 py-5">
                                    <div style="text-align: center;">
                                        <img src="{{url('/assets/images/accenture-logo.svg')}}" style="max-height: 60px;">
                                        <p style="color: #A100FF; font-size: 2rem; margin-top: 5px; margin-bottom: 2rem">
                                            <span style="font-weight: bold">Tech</span>Advisory Platform
                                        </p>
                                    </div>

                                    @if ($errors->has('notAccenture'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('notAccenture') }}</strong>
                                    </span>
                                    @endif

                                    <br>

                                    <form method="POST" action="{{route('accenture.loginPost')}}" class="forms-sample">
                                        @csrf
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input class="form-control" name="email" placeholder="Email" type="email" required>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input autocomplete="current-password" class="form-control" name="password" placeholder="Password" type="password" required>
                                            @if ($errors->has('password'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                        <div class="form-check form-check-flat form-check-primary">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="remember">
                                                Remember me
                                            </label>
                                        </div>
                                        <p style="margin-top: 1rem; margin-bottom: 2rem" target="_blank">
                                            By logging into the platform, I agree to the <a href="{{route('terms')}}">Terms of Use</a>
                                            and I acknowledge receipt of <a href="{{route('privacy')}}">Privacy Statement</a>
                                        </p>

                                        <a href="{{route('password.request')}}" class="purpleColor">I forgot my password</a>


                                        <div style="margin-top: 30px; float: right; margin-bottom: 20px;">
                                            <div class="mt-3">
                                                <button class="btn btn-primary btn-lg btn-icon-text" type="submit">
                                                    <i class="btn-icon-prepend" data-feather="arrow-right"></i>
                                                    Log in
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
