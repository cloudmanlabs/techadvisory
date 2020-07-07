@extends('accentureViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections" />


        <div class="page-wrapper">
            <div class="page-content">

                <x-accenture.projectNavbar section="projectConclusions" :project="$project" />

                <x-video :src="nova_get_setting('video_conclusions_file')" :text="nova_get_setting('video_conclusions_text')" />

                <br>
                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div style="float: left;">
                                    <h3>Project conclusions</h3>
                                </div>

                                <br><br>

                                <p class="welcome_text extra-top-15px">
                                    {{nova_get_setting('accenture_projectConclusions_title') ?? ''}}
                                </p>
                                <br>
                                <br>

                                <x-folderFilePreview :folder="$project->conclusionsFolder" />

                                <div class="row">
                                    <div class="col-12 col-md-12 col-xl-12">
                                        <x-folderFileUploader :folder="$project->conclusionsFolder" :timeout="1000"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
            </div>

            <x-footer />
        </div>
    </div>
@endsection
