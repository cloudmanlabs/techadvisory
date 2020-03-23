@extends('accentureViews.layouts.app')

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
                                    <div style="text-align: center;"><img src="@logo" style="max-height: 80px; margin-bottom: 50px;">
                                    </div>

                                    @if ($errors->has('notAccenture'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('notAccenture') }}</strong>
                                    </span>
                                    @endif

                                    <br>

                                    <form method="POST" action="{{route('accenture.loginPost')}}"
                                    class="forms-sample">
                                        @csrf
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input class="form-control" name="email" placeholder="Email" type="email">
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input autocomplete="current-password" class="form-control" name="password" placeholder="Password" type="password">
                                            @if ($errors->has('password'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                        <div class="form-check form-check-flat form-check-primary">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox">
                                                Remember me
                                            </label>
                                        </div>

                                        <a href="{{route('accenture.forgotPassword')}}" class="purpleColor">I forgot my password</a>


                                        <div style="margin-top: 30px; float: right; margin-bottom: 20px;">
                                            <div class="mt-3">

                                            {{-- TODO Change to actual login --}}
                                            <button class="btn btn-primary btn-lg btn-icon-text" type="submit">
                                                <i class="btn-icon-prepend" data-feather="arrow-right"></i>
                                                Log in
                                            </button>
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
