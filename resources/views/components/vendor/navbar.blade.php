@props(['activeSection'])

<div class="horizontal-menu">
    <nav class="navbar top-navbar">
        <div class="container">
            <div class="navbar-content">
                <a class="navbar-brand" href="{{route('vendor.main')}}">
                    <img src="{{url('/assets/images/accenture-logo.svg')}}" style="height: 30px;">
                </a>

                <form class="search-form">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i data-feather="search"></i>
                            </div>
                        </div>
                        <input class="form-control" id="navbarForm" placeholder="Search here..." type="text">
                    </div>
                </form>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown nav-profile">
                        <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle"
                            data-toggle="dropdown" href="#" id="profileDropdown" role="button">
                            <img alt="profile" src="{{url(auth()->user()->logo ? ('/storage/' . auth()->user()->logo) : '/assets/images/user.png')}}">
                        </a>

                        <div aria-labelledby="profileDropdown" class="dropdown-menu">
                            <div class="dropdown-header d-flex flex-column align-items-center">
                                <div class="info text-center">
                                    <p class="name font-weight-bold mb-0">{{auth()->user()->name}}</p>
                                </div>
                            </div>

                            <div class="dropdown-body">
                                <ul class="profile-nav p-0 pt-3">
                                    @if(auth()->user()->hasFinishedSetup)
                                    <li class="nav-item" style="display: flex; justify-content: center">
                                        <a class="nav-link" href="{{route('vendor.profile')}}">
                                            <span>My Profile</span>
                                        </a>
                                    </li>
                                    @endif
                                    <li class="nav-item" style="display: flex; justify-content: center">
                                        <a class="nav-link" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();" id="logout-button">
                                            <i data-feather="log-out"></i>
                                            <span>Log Out</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center"
                    data-toggle="horizontal-menu-toggle" type="button"><i data-feather="menu"></i></button>
            </div>
        </div>
    </nav>

    <nav class="bottom-navbar">
        <div class="container">
            <div style="position: relative; float: left">
                <a href="{{route('vendor.main')}}">
                    <p style="color: #A100FF; font-size: 2rem; margin-top: 5px">
                        <span style="font-weight: bold">Tech</span>Advisory Platform
                    </p>
                    {{-- <img src="{{url('/assets/images/simple-logo.png')}}" style="height: 50px; margin-top: 4px"> --}}
                </a>
            </div>
            <ul class="nav page-navigation">
                @if(auth()->user()->hasFinishedSetup)
                <li class="nav-item {{$activeSection == 'home' ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('vendor.home')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-box link-icon">
                            <path
                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                            </path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        <span class="menu-title">Home</span>
                    </a>
                </li>
                <li class="nav-item {{$activeSection == 'projects' ? 'active' : ''}}">
                    <a href="#" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-book link-icon">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        </svg>
                        <span class="menu-title">Projects</span>
                        <i class="link-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul class="submenu-item">
                            <li class="category-heading">Projects</li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('vendor.home')}}#invitation_phase">
                                    Invitation Phase
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('vendor.home')}}#open_projects">
                                    Started Applications
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('vendor.home')}}#closed_projects">
                                    Submitted Applications
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('vendor.home')}}#closed_projects">
                                    Rejected Projects
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item {{$activeSection == 'solutions' ? 'active' : ''}}">
                    <a href="#" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-pie-chart link-icon">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <span class="menu-title">Solutions</span>
                        <i class="link-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul class="submenu-item">
                            <li class="category-heading">Solutions</li>
                            <li class="nav-item"><a class="nav-link" href="{{route('vendor.solutions')}}">View solutions</a></li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('vendor.createSolution')}}"
                                onclick="event.preventDefault(); document.getElementById('create-solution-form').submit();">Add new solution</a>
                                <form id="create-solution-form" action="{{ route('vendor.createSolution') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </nav>
</div>
