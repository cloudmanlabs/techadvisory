@extends('vendorViews.layouts.app')

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
                                    <div style="text-align: center;"><img src="@logo"
                                            style="max-height: 80px; margin-bottom: 50px;">
                                    </div>

                                    <div>
                                        <a href="{{route('accenture.main')}}">Accenture</a>
                                        <br><br>
                                        <a href="{{route('client.main')}}">Client</a>
                                        <br><br>
                                        <a href="{{route('vendor.main')}}">Vendor</a>
                                        <br><br><br><br>
                                        <p>{{ auth()->check() ? 'You are logged in' : 'You\'re not logged in'}}</p>
                                        <a href="{{route('logout')}}">Logout</a>
                                    </div>
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
