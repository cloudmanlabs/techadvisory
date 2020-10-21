<div class="profile-header">
    <div class="header-links display-5 ">
        <ul class="links d-flex flex-row mt-3 mt-md-0">
            <li class="header-link-item {{$nav1 == 'overview' ? 'active' : ''}}">
                <a class=""
                   href="{{route('accenture.benchmark')}}">Overview</a>
            </li>
            <li class="header-link-item ml-3 pl-3 border-left {{$nav1 == 'projectResults' ? 'active' : ''}}">
                <a class=""
                   href="{{route('accenture.benchmark.projectResults')}}">Project Results</a>
            </li>
            <li class="header-link-item ml-3 pl-3 border-left {{$nav1 == 'custom' ? 'active' : ''}}">
                <a class=""
                   href="{{--route('accenture.benchmark.customSearches')--}}">Custom Searches</a>
            </li>
        </ul>
    </div>
</div>

