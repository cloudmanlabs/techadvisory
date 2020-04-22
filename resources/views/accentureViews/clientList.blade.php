@extends('accentureViews.layouts.app')

@section('content')
    <div class="main-wrapper">
        <x-accenture.navbar activeSection="sections" />

        <div class="page-wrapper">
            <div class="page-content">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h2>Accenture's <span class="badge badge-primary">Tech Advisory Platform</span></h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card" id="open_projects">
                        <div class="card">
                            <div class="card-body">
                                <h3>List of Clients</h3>
                                <p class="welcome_text extra-top-15px">In this list you can see the list of clients
                                    already registered in the platform. See the detail of the client profile by clicking
                                    on the button.</p>
                                <br>
                                <br>
                                @foreach ($clients as $client)
                                    <div class="card" style="margin-bottom: 30px;">
                                        <div class="card-body">
                                            <div style="float: left; max-width: 40%;">
                                                <h4>{{$client->name}}</h4>
                                            </div>
                                            <div style="float: right; text-align: right; width: 15%;">
                                                <a class="btn btn-primary btn-lg btn-icon-text"
                                                href="{{route('accenture.clientProfileView', ['client' => $client])}}">View <i
                                                class="btn-icon-prepend" data-feather="arrow-right"></i></a>
                                            </div>
                                            <div style="float: right; width: 20%; margin-right: 10%;">
                                                <h5>Industry name</h5>
                                            </div>
                                            <div style="float: right; width: 10%; margin-right: 10%;">
                                                <img alt="profile" src="{{url($client->logo ? ('/storage/' . $client->logo) : '/assets/images/user.png')}}" style="height: 20px">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="startnew">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Create new Client</h3>
                                <br>
                                <br>

                                <a class="btn btn-primary btn-lg btn-icon-text" href="{{ route('accenture.createClient') }}"
                                    onclick="event.preventDefault(); document.getElementById('create-project-form').submit();">
                                    Create and do
                                    initial set-up
                                    <i class="btn-icon-prepend" data-feather="arrow-right"></i>
                                </a>
                                <form id="create-project-form" action="{{ route('accenture.createClient') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-footer />
        </div>
    </div>
@endsection
