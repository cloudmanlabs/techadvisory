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

                                    <p>
                                        Enter your email below and we'll send
                                        you a link to reset your password.
                                    </p>

                                    <br>

                                    <form class="forms-sample">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label> <input class="form-control" id="exampleInputEmail1" placeholder="Email" type="email">
                                        </div>

                                        <div style="margin-top: 30px; float: right; margin-bottom: 20px;">
                                            <div class="mt-3">
                                            {{-- TODO Change to actual login --}}
                                            <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.login')}}">
                                                    <i class="btn-icon-prepend" data-feather="arrow-right"></i>
                                                    Send email
                                                </a>
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
