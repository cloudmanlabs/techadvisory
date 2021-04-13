@extends('layouts.base')

@section('content')
<div class="main-wrapper">
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">
            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-8 col-xl-6 mx-auto">
                    <div class="card" style="margin-top: 10rem">
                        <div class="card-header">{{ __('Error') }}</div>

                        <div class="card-body">
                            <p>This password change link is invalid.</p>
                            <p>You might be using an outdated link. Please make sure to use the last sent link.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
