{{--
    Small card to display the vendor info
    --}}

@props(['showProgressBar', 'vendor', 'application', 'project'])
<div class="card" style="margin-bottom: 30px;" id="vendorApplyCard">
    <div class="card-body" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center">
        <div style="max-width: 40%; padding-top: 8px;">
            <h4>{{$vendor->name }}</h4>
            <p>Last update on: 17/03/2020</p>
        </div>

        <div style="width: 10%;">
            {{-- TODO Change image --}}
            <img alt="profile" src="{{url(($vendor && $vendor->logo) ? ('/storage/' . $vendor->logo) : '/assets/images/user.png')}}" style="height: 20px">
        </div>

        @if($showProgressBar ?? true)
            @php
            $application = \App\VendorApplication::where('project_id', $project->id)->where('vendor_id', $vendor->id)->first();
            @endphp
            <x-applicationProgressBar :application="$application" />
        @else
            <p>
                &nbsp;
            </p>
            <p>
                &nbsp;
            </p>
        @endif

        {{$slot}}

    </div>
</div>
