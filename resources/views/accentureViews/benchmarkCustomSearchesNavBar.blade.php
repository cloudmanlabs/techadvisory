<div class="row" id="overview-navbar">
    <div class="col-12">
        <div class="profile-header">
            <div class="header-links display-6 ">
                <ul class="links d-flex flex-row mt-3 mt-md-0">
                    <li class="header-link-item {{$nav2 == 'project' ? 'active' : ''}}">
                        <a class=""
                           href="{{route('accenture.benchmark.customSearches')}}">Analytics By Projects</a>
                    </li>
                    <li class="header-link-item ml-3 pl-3 border-left {{$nav2 == 'vendor' ? 'active' : ''}}">
                        <a class=""
                           href="{{route('accenture.benchmark.customSearches.vendor')}}">Vendors Benchmark</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

