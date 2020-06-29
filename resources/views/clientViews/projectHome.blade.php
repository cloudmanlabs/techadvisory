@extends('clientViews.layouts.app')

@section('content')
<div class="main-wrapper">
    <x-client.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">

                <x-client.projectNavbar section="projectHome" :project="$project" />

                <br>
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Vendors applicating</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('client_projectHome_invited') ?? ''}}
                                </p>
                                <br>
                                <br>

                                @foreach ($startedVendors as $vendor)
                                <x-vendorCard :vendor="$vendor" :project="$project">
                                </x-vendorCard>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Released responses</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('client_projectHome_released') ?? ''}}
                                </p>
                                <br>
                                <br>

                                @foreach ($submittedVendors as $vendor)
                                <x-vendorCard :showProgressBar="false" :vendor="$vendor" :project="$project">
                                    <div style="text-align: right; width: 15%;">
                                        <a class="btn btn-primary btn-lg btn-icon-text" target="_blank" href="{{route('client.downloadVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">Download response
                                        </a>
                                    </div>
                                    <div style=" text-align: right; width: 15%;">
                                        <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('client.viewVendorProposal', ['project' => $project, 'vendor' => $vendor])}}">View response
                                        </a>
                                    </div>
                                </x-vendorCard>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

               <x-deadline :project="$project" />
            </div>

            <x-footer />
        </div>
    </div>
@endsection
