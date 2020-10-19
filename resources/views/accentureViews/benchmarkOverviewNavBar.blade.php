<div class="row" id="overview-navbar">
    <div class="col-12">
        <div class="profile-header">
            <div class="header-links display-5 ">
                <ul class="links d-flex flex-row mt-3 mt-md-0">
                    <li class="header-link-item {{$nav2 == 'general' ? 'active' : ''}}"
                    >
                        <a class=""
                           href="{{route('accenture.benchmark')}}">General</a>
                    </li>
                    <li class="header-link-item ml-3 pl-3 border-left {{$nav2 == 'historical' ? 'active' : ''}}">
                        <a class=""
                           href="{{route('accenture.benchmark.overview.historical')}}">Historical</a>
                    </li>
                    <li class="header-link-item ml-3 pl-3 border-left {{$nav2 == 'vendor' ? 'active' : ''}}">
                        <a class=""
                           href="{{route('accenture.benchmark.overview.vendor')}}">Vendor</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

