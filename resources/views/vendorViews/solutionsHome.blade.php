@extends('vendorViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="solutions" />

        <div class="page-wrapper">
            <div class="page-content">

                <x-video :src="nova_get_setting('video_opening_file')" :text="nova_get_setting('video_openingVendor_text')"/>

                <br><br>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card" id="open_projects">
                        <div class="card">
                            <div class="card-body">
                                <h3>Solutions</h3>
                                <p class="welcome_text extra-top-15px">Below is your solutions portfolio.</p>
                                <br>
                                <br>
                                @foreach ($solutions as $solution)
                                    <div class="card" style="margin-bottom: 30px;">
                                        <div class="card-body">
                                            <div style="float: left; max-width: 40%;">
                                                <h4>{{$solution->name}}</h4>
                                                <h6>Solution type</h6>
                                            </div>
                                            <div style="float: right; text-align: right; width: 17%;">
                                                <a class="btn btn-primary btn-lg btn-icon-text" href="{{route('vendor.solutionEdit', ['solution' => $solution])}}">View/Edit <i class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-footer />
        </div>
    </div>
@endsection
