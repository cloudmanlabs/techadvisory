<div class="row" id="overview-navbar">
    <div class="col-12">
        <div class="profile-header">
            <div class="header-links display-6 text-center">
                <ul class="links d-flex flex-row mt-3 mt-md-0">
                    <li class="header-link-item {{$nav2 == 'overall' ? 'active' : ''}}">
                        <a class=""
                           href="{{route('accenture.benchmark.projectResults')}}">Overall RFP</a>
                    </li>
{{--                    <li class="header-link-item ml-3 pl-3 border-left {{$nav2 == 'overallUseCases' ? 'active' : ''}}">--}}
{{--                        <a class=""--}}
{{--                           href="{{route('accenture.benchmark.projectUseCasesResults')}}">Overall Use Cases</a>--}}
{{--                    </li>--}}
                    <li class="header-link-item ml-3 pl-3 border-left {{$nav2 == 'fitgap' ? 'active' : ''}}">
                        <a class=""
                           href="{{route('accenture.benchmark.projectResults.fitgap')}}">Fitgap</a>
                    </li>
                    <li class="header-link-item ml-3 pl-3 border-left {{$nav2 == 'vendor' ? 'active' : ''}}">
                        <a class=""
                           href="{{route('accenture.benchmark.projectResults.vendor')}}">Vendor</a>
                    </li>
                    <li class="header-link-item ml-3 pl-3 border-left {{$nav2 == 'experience' ? 'active' : ''}}">
                        <a class=""
                           href="{{route('accenture.benchmark.projectResults.experience')}}">Experience</a>
                    </li>
                    <li class="header-link-item ml-3 pl-3 border-left {{$nav2 == 'innovation' ? 'active' : ''}}">
                        <a class=""
                           href="{{route('accenture.benchmark.projectResults.innovation')}}">Innovation & Vision</a>
                    </li>
                    <li class="header-link-item ml-3 pl-3 border-left {{$nav2 == 'implementation' ? 'active' : ''}}">
                        <a class=""
                           href="{{route('accenture.benchmark.projectResults.implementation')}}">Implementations & Commercials</a>
                    </li>
{{--                    <li class="header-link-item ml-3 pl-3 border-left {{$nav2 == 'useCases' ? 'active' : ''}}">--}}
{{--                        <a class=""--}}
{{--                           href="{{route('accenture.benchmark.projectResults.useCases')}}">Use Cases</a>--}}
{{--                    </li>--}}
                </ul>
            </div>
        </div>
    </div>
</div>
