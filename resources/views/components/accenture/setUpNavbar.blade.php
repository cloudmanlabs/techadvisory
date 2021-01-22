{{--
    Subnavbar for the Project views
    --}}

@props(['section', 'project', 'isClient'])
<div class="profile-page" id="setUpNavbar">
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="profile-header">
                <div class="header-links">
                    <ul class="links d-flex align-items-center mt-3 mt-md-0">
                        <li class="header-link-item d-flex align-items-center {{$section == 'newProjectSetUp' ? 'active' : ''}}">
                            <i data-feather="bookmark" style="max-width: 18px; margin-right: 3px; margin-top: -2px"></i>
                            <a class="pt-1px d-none d-md-block" href="{{route('accenture.newProjectSetUp', ['project' => $project])}}">
                                RFP Setup
                            </a>
                        </li>
                        <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center {{$section == 'useCasesSetUp' ? 'active' : ''}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-check-circle"
                                 style="max-width: 18px; margin-right: 3px; margin-top: -2px">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <a class="pt-1px d-none d-md-block" href="{{route('accenture.useCasesSetUp', ['project' => $project])}}">
                                {{$project->useCasesPhase === 'evaluation' ? 'Use Cases' : 'Use Cases Set Up'}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
