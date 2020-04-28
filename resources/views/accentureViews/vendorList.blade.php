@extends('accentureViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card" id="open_projects">
                        <div class="card">
                            <div class="card-body">
                                <h3>List of Vendors</h3>
                                <p class="welcome_text extra-top-15px">In this list you can see the list of vendors
                                    already registered in the platform. See the detail of the vendor profile by clicking
                                    on the button.</p>
                                <br>
                                <br>
                                @foreach ($vendors as $vendor)
                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%;">
                                            <h4>{{$vendor->name}}</h4>
                                        </div>
                                        <div style="float: right; text-align: right; width: 15%;">
                                            <a class="btn btn-primary btn-lg btn-icon-text"
                                            href="{{route('accenture.vendorProfileView', ['vendor' => $vendor])}}">View <i
                                            class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                        </div>
                                        <div style="float: right; width: 20%; margin-right: 10%;">
                                            <h5>Segment name</h5>
                                        </div>
                                        <div style="float: right; width: 10%; margin-right: 10%;">
                                            <img alt="profile" src="{{url($vendor->logo ? ('/storage/' . $vendor->logo) : '/assets/images/user.png')}}" style="height: 20px">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Vendors pending validation</h3>
                                <p class="welcome_text extra-top-15px">In this list you can see the list of vendors
                                    already registered in the platform. See the detail of the vendor profile by clicking
                                    on the button.</p>
                                <br>
                                <br>
                                @foreach ($vendorsPendingValidation as $vendor)
                                <div class="card" style="margin-bottom: 30px;">
                                    <div class="card-body">
                                        <div style="float: left; max-width: 40%;">
                                            <h4>{{$vendor->name}}</h4>
                                        </div>
                                        <div style="float: right; text-align: right; width: 15%;">
                                            <a class="btn btn-primary btn-lg btn-icon-text"
                                                href="{{route('accenture.vendorValidateResponses', ['vendor' => $vendor])}}">Validate</a>
                                        </div>
                                        <div style="float: right; width: 20%; margin-right: 10%;">
                                            <h5>Segment name</h5>
                                        </div>
                                        <div style="float: right; width: 10%; margin-right: 10%;">
                                            <img alt="profile" src="{{url($vendor->logo ? ('/storage/' . $vendor->logo) : '/assets/images/user.png')}}"
                                                style="height: 20px">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3 style="cursor: pointer" id="filterH3" title="Click to maximize/minimize">Filter +</h3>
                                <div id="filterContainer" style="display: none">
                                    <div class="media-body" style="padding: 20px;">
                                        <p class="welcome_text">
                                            Please choose the Vendors you'd like to see:
                                        </p>
                                        <select id="vendorSelect" class="w-100" multiple="multiple">
                                            @foreach ($vendors as $vendor)
                                            <option>{{$vendor->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <br>
                                <h3>List of vendor solutions</h3>
                                <p class="welcome_text extra-top-15px">In this list you can see the list of solutions.</p>
                                <br>
                                <br>
                                <div id="solutionContainer">
                                    @foreach ($vendorSolutions as $solution)
                                        <div class="card" style="margin-bottom: 30px;"
                                            data-vendor="{{$solution->vendor->name}}">
                                            <div class="card-body">
                                                <div style="float: left; max-width: 40%;">
                                                    <h4>{{$solution->name}}</h4>
                                                </div>
                                                <div style="float: right; text-align: right; width: 15%;">
                                                    <a class="btn btn-primary btn-lg btn-icon-text"
                                                    href="{{route('accenture.vendorSolution', ['solution' => $solution])}}">View</a>
                                                </div>
                                                <div style="float: right; width: 20%; margin-right: 10%;">
                                                    <h5>{{$solution->vendor->name}}</h5>
                                                </div>
                                                <div style="float: right; width: 10%; margin-right: 10%;">
                                                    <img alt="profile" src="{{url($solution->vendor->logo ? ('/storage/' . $solution->vendor->logo) : '/assets/images/user.png')}}" style="height: 20px">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="startnew">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Create new Vendor</h3>
                                <br>
                                <br>

                                <a class="btn btn-primary btn-lg btn-icon-text" href="{{ route('accenture.createVendor') }}"
                                    onclick="event.preventDefault(); document.getElementById('create-project-form').submit();">
                                    Create and do
                                    initial set-up
                                    <i class="btn-icon-prepend" data-feather="arrow-right"></i>
                                </a>
                                <form id="create-project-form" action="{{ route('accenture.createVendor') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
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

@section('scripts')
@parent
<script>
    $(document).ready(function(){
            $('#filterH3').click(function(){
                if($('#filterContainer').css('display') === 'none'){
                    $('#filterContainer').css('display', 'initial')
                    $('#filterH3').text('Filter -')
                } else {
                    $('#filterContainer').css('display', 'none')
                    $('#filterH3').text('Filter +')
                }
            })

            function updateSolutions() {
                // Get all selected practices. If there are none, get all of them
                var selectedVendors = $('#vendorSelect').select2('data').map((el) => {
                    return el.text
                });
                if(selectedVendors.length == 0){
                    selectedVendors = $('#vendorSelect').children().toArray().map((el) => {
                        return el.innerHTML
                    });
                }

                console.log(selectedVendors)

                // Add a display none to the one which don't have this tags
                $('#solutionContainer').children().each(function () {
                    const vendor = $(this).data('vendor');

                    console.log($.inArray(vendor, selectedVendors))

                    if ($.inArray(vendor, selectedVendors) !== -1) {
                        $(this).css('display', 'flex')
                    } else {
                        $(this).css('display', 'none')
                    }
                });
            }

            $('#vendorSelect').select2();
            $('#vendorSelect').on('change', function (e) {
                updateSolutions();
            });
            updateSolutions();
        });
</script>
@endsection
