@props(['section', 'subsection', 'project'])

<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="float: left;">
                    <h3>{{$project->name}}</h3>
                    <h5>{{$project->practice->name}}</h5>
                </div>

                <x-applicationProgressBar progressFitgap="20" progressVendor="10" progressExperience="0" progressInnovation="0"
                    progressImplementation="0" progressSubmit="0" />
            </div>
        </div>
    </div>
</div>

<div class="profile-page">
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="profile-header">
                <div class="header-links">
                    <ul class="links d-flex align-items-center mt-3 mt-md-0">
                        @if($section != 'preview')
                            <li class="header-link-item d-flex align-items-center {{$section == 'info' ? 'active' : ''}}">
                                <i data-feather="bookmark" style="max-width: 18px; margin-right: 3px; margin-top: -2px"></i>
                                <a
                                    class="pt-1px d-none d-md-block"
                                    href="{{route('vendor.newApplication', ['project' => $project])}}"
                                >Project information</a>
                            </li>
                            <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center {{$section == 'apply' ? 'active' : ''}}">
                                <i data-feather="check-circle"
                                    style="max-width: 18px; margin-right: 3px; margin-top: -2px"></i>
                                <a
                                    class="pt-1px d-none d-md-block"
                                    href="{{route('vendor.newApplication.apply', ['project' => $project])}}"
                                >Apply to project</a>
                            </li>
                            @if ($project->hasOrals)
                            <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center {{$section == 'projectOrals' ? 'active' : ''}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    style="max-width: 18px; margin-right: 3px; margin-top: -2px" class="feather feather-smile link-icon">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                    <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                    <line x1="15" y1="9" x2="15.01" y2="9"></line>
                                </svg>
                                <a
                                    class="pt-1px d-none d-md-block"
                                    href="{{route('vendor.newApplication.orals', ['project' => $project])}}"
                                >Orals</a>
                            </li>
                            @endif
                        @else
                            <li class="header-link-item d-flex align-items-center active">
                                <i data-feather="bookmark" style="max-width: 18px; margin-right: 3px; margin-top: -2px"></i>
                                <a
                                    class="pt-1px d-none d-md-block"
                                    href="{{route('vendor.previewProject', ['project' => $project])}}"
                                >Project information</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
