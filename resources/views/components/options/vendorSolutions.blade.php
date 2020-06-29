@props(['selected', 'vendor'])

@foreach ($vendor->vendorSolutions as $solution)
<option value="{{$solution->id}}" {{in_array($solution->id, $selected ?? []) ? 'selected' : ''}}>
    {{$solution->name}}
</option>
@endforeach
