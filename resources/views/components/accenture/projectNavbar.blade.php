@props(['section', 'subsection'])

<div class="profile-page">
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="profile-header">
                <div class="header-links">
                    <ul class="links d-flex align-items-center mt-3 mt-md-0">
                        <li class="header-link-item d-flex align-items-center {{$section == 'projectHome' ? 'active' : ''}}">
                            <i data-feather="bookmark" style="max-width: 18px; margin-right: 3px; margin-top: -2px"></i>
                            <a class="pt-1px d-none d-md-block" href="{{route('accenture.projectHome')}}">Project home</a>
                        </li>
                        <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center {{$section == 'projectEditView' ? 'active' : ''}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-edit"
                                style="max-width: 18px; margin-right: 3px; margin-top: -2px">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                </path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                </path>
                            </svg>
                            <a class="pt-1px d-none d-md-block" href="{{route('accenture.projectEditView')}}">View/Edit project</a>
                        </li>
                        <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center {{$section == 'projectValueTargeting' ? 'active' : ''}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-calendar"
                                style="max-width: 18px; margin-right: 3px; margin-top: -2px">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <a class="pt-1px d-none d-md-block" href="{{route('accenture.projectValueTargeting')}}">
                                Value Targeting Outcomes
                            </a>
                        </li>
                        <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center {{$section == 'projectBenchmark' ? 'active' : ''}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-pie-chart"
                                style="max-width: 18px; margin-right: 3px; margin-top: -2px">
                                <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                            </svg>
                            <a class="pt-1px d-none d-md-block" href="{{route('accenture.projectBenchmark')}}">
                                Project Analytics
                            </a>
                        </li>
                        <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center {{$section == 'projectOrals' ? 'active' : ''}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" style="max-width: 18px; margin-right: 3px; margin-top: -2px"
                                class="feather feather-smile link-icon">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                <line x1="15" y1="9" x2="15.01" y2="9"></line>
                            </svg>
                            <a class="pt-1px d-none d-md-block" href="{{route('accenture.projectOrals')}}">
                                Orals
                            </a>
                        </li>
                        <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center {{$section == 'projectConclusions' ? 'active' : ''}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-check-circle"
                                style="max-width: 18px; margin-right: 3px; margin-top: -2px">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <a class="pt-1px d-none d-md-block" href="{{route('accenture.projectConclusions')}}">
                                Conclusions & Recommendations
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            @if($section == 'projectBenchmark')
            <div class="profile-header">
                <div class="header-links">
                    <ul class="links d-flex align-items-center mt-3 mt-md-0">
                        <li class="header-link-item d-flex align-items-center {{$subsection == 'overall' ? 'active' : ''}}">
                            <a class="pt-1px d-none d-md-block"
                                href="{{route('accenture.projectBenchmark')}}">Overall</a>
                        </li>
                        <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center {{$subsection == 'fitgap' ? 'active' : ''}}">
                            <a class="pt-1px d-none d-md-block"
                                href="{{route('accenture.projectBenchmarkFitgap')}}">Fit Gap</a>
                        </li>
                        <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center {{$subsection == 'vendor' ? 'active' : ''}}">
                            <a class="pt-1px d-none d-md-block"
                                href="{{route('accenture.projectBenchmarkVendor')}}">Vendor</a>
                        </li>
                        <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center {{$subsection == 'experience' ? 'active' : ''}}">
                            <a class="pt-1px d-none d-md-block"
                                href="{{route('accenture.projectBenchmarkExperience')}}">Experience</a>
                        </li>
                        <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center {{$subsection == 'innovation' ? 'active' : ''}}">
                            <a class="pt-1px d-none d-md-block"
                                href="{{route('accenture.projectBenchmarkInnovation')}}">Innovation &
                                Vision</a>
                        </li>
                        <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center {{$subsection == 'implementation' ? 'active' : ''}}">
                            <a class="pt-1px d-none d-md-block"
                                href="{{route('accenture.projectBenchmarkImplementation')}}">Implementation
                                & Commercials</a>
                        </li>
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
