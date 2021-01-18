{{--
    Subnavbar for the Project views
    --}}

@props(['section', 'subsection', 'project', 'isInvited'])


@php
$vendorApplication = \App\VendorApplication::where('project_id', $project->id)->where('vendor_id', auth()->id())->first();

$showApply = $vendorApplication->phase == 'applicating';
@endphp

<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="float: left;">
                    <h3>{{$project->name}}</h3>
                    <h5>{{$project->practice->name}}</h5>
                </div>

                <x-applicationProgressBar :application="$vendorApplication" />
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
                        @if($section != 'preview' && $section != 'previewApply')
                            <li class="header-link-item d-flex align-items-center {{$section == 'info' ? 'active' : ''}}">
                                <i data-feather="bookmark" style="max-width: 18px; margin-right: 3px; margin-top: -2px"></i>
                                <a
                                    class="pt-1px d-none d-md-block"
                                    href="{{route('vendor.newApplication', ['project' => $project])}}"
                                >Project information</a>
                            </li>
                            @if ($project->useCases !== 'no' && $project->useCasesPhase === 'evaluation' && $isInvited)
                                <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center {{$section == 'useCasesSetUp' ? 'active' : ''}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-check-circle"
                                         style="max-width: 18px; margin-right: 3px; margin-top: -2px">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                    <a class="pt-1px d-none d-md-block" href="{{route('vendor.applicationUseCasesSetUp', ['project' => $project])}}">Use Cases Set Up</a>
                                </li>
                            @endif
                            <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center {{$section == 'apply' ? 'active' : ''}}">
                                <i data-feather="check-circle"
                                    style="max-width: 18px; margin-right: 3px; margin-top: -2px"></i>
                                <a
                                    class="pt-1px d-none d-md-block"
                                    {{--  TODO Change this route depending on if the application has beem submitted or not --}}
                                    @if ($showApply)
                                        href="{{route('vendor.newApplication.apply', ['project' => $project])}}"
                                    @else
                                        href="{{route('vendor.submittedApplication', ['project' => $project])}}"
                                    @endif
                                >Application</a>
                            </li>
                            @if ($project->hasOrals && $vendorApplication->invitedToOrals)
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
                            <li class="header-link-item ml-3 pl-3 d-flex align-items-center {{$section == 'preview' ? 'active' : ''}}">
                                <i data-feather="bookmark" style="max-width: 18px; margin-right: 3px; margin-top: -2px"></i>
                                <a
                                    class="pt-1px d-none d-md-block"
                                    href="{{route('vendor.previewProject', ['project' => $project])}}"
                                >Project information</a>
                            </li>
                            <li class="header-link-item ml-3 pl-3 d-flex align-items-center {{$section == 'previewApply' ? 'active' : ''}}">
                                <i data-feather="check-circle" style="max-width: 18px; margin-right: 3px; margin-top: -2px"></i>
                                <a
                                    class="pt-1px d-none d-md-block"
                                    href="{{route('vendor.previewProjectApply', ['project' => $project])}}"
                                >Application</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
