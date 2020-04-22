@props(['selected'])

@foreach (\App\User::vendorUsers()->where('hasFinishedSetup', true)->get() as $vendor)
<option value="{{$vendor->id}}" {{in_array($vendor->id, $selected) ? 'selected' : ''}}>{{$vendor->name}}</option>
@endforeach
