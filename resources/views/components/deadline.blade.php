@props(['project'])

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3>Project deadline</h3>
                <h5>
                    {{$project->deadline->setTimezone($project->timezone)->format('F j Y, \a\t H:i')}}
                    - {{ $project->timezone }}
                </h5>
                <br>

                @if ($project->deadline != null && !$project->deadline->isPast())
                    <div class="card" style="margin-bottom: 30px;">
                        <div class="card-body">
                            <div style="text-align: center;">
                                <div id="clockdiv"
                                     data-enddate="{{$project->deadline->setTimezone($project->timezone)->format('c')}}">
                                    <div>
                                        <span class="days"></span>
                                        <div class="smalltext">Days</div>
                                    </div>
                                    <div>
                                        <span class="hours"></span>
                                        <div class="smalltext">Hours</div>
                                    </div>
                                    <div>
                                        <span class="minutes"></span>
                                        <div class="smalltext">Minutes</div>
                                    </div>
                                    <div>
                                        <span class="seconds"></span>
                                        <div class="smalltext">Seconds</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <h3 style="text-align: center;">Date has already passed!</h3>
                @endif
            </div>
        </div>
    </div>
</div>
