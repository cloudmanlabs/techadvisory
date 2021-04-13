@extends('layouts.base')

@section('content')
<div class="main-wrapper">
    <x-client.navbar activeSection="home" />

        <div class="page-wrapper">
            <div class="page-content">
                <x-client.projectNavbar section="projectDiscovery" :project="$project" />

                <x-video :src="nova_get_setting('video_valueTargeting_file')" :text="nova_get_setting('video_valueTargeting_text')"/>

                <br>
                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>Your discovery week</h3>
                                </div>
                                <br><br>
                                <div class="welcome_text welcome_box" style="clear: both; margin-top: 20px;">
                                    <div class="media d-block d-sm-flex">
                                        <div class="media-body" style="padding: 20px;">
                                            {{nova_get_setting('accenture_projectValueTargeting_Title') ?? ''}}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <br><br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Selected Value Levers</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectValueTargeting_selected') ?? ''}}
                                </p>
                                <br>
                                <br>

                                <x-folderFilePreview :folder="$project->selectedValueLeversFolder" />
                                <x-folderFileUploader :disabled="true" :folder="$project->selectedValueLeversFolder" />

                                <br><br><br>

                                <h3>Business Opportunity Details</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectValueTargeting_business') ?? ''}}
                                </p>
                                <br>
                                <br>

                                <x-folderFileUploader :disabled="true" :folder="$project->businessOpportunityFolder" />

                                <br><br><br>

                                <h3>Conclusions</h3>
                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectValueTargeting_conclusions') ?? ''}}
                                </p>
                                <br>
                                <br>

                                <x-folderFilePreview :folder="$project->vtConclusionsFolder" />
                                <x-folderFileUploader :disabled="true" :folder="$project->vtConclusionsFolder" />

                                <div style="float: right; margin-top: 20px;">
                                    <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('client.projectHome', ['project' => $project])}}">
                                        <i data-feather="arrow-left"></i>
                                        Go back to project
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-footer />
        </div>
    </div>
@endsection
