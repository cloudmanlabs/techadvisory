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

                                    <div>
                                        <a href="{{route('accenture.main')}}">Accenture</a>
                                        <br><br>
                                        <a href="{{route('client.main')}}">Client</a>
                                        <br><br>
                                        <a href="{{route('vendor.main')}}">Vendor</a>
                                        <br><br><br><br>
                                        <p>{{ auth()->check() ? 'You are logged in' : 'You are not logged in'}}</p>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
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
</div>
@endsection
