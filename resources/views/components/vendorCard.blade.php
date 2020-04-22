@props(['showProgressBar', 'vendor'])

<div class="card" style="margin-bottom: 30px;">
    <div class="card-body" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center">
        <div style="max-width: 40%; padding-top: 8px;">
            <h4>{{$vendor->name ?? 'NO VENDOR'}}</h4>
            <p>Last update on: 17/03/2020</p>
        </div>

        <div style="width: 10%;">
            {{-- TODO Change image --}}
            <img alt="profile" src="{{url(($vendor && $vendor->logo) ? ('/storage/' . $vendor->logo) : '/assets/images/user.png')}}" style="height: 20px">
        </div>

        @if($showProgressBar ?? true)
            <x-applicationProgressBar progressFitgap="20" progressVendor="10" progressExperience="0" progressInnovation="0"
            progressImplementation="0" progressSubmit="0" />
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
