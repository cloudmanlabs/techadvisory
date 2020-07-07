@props(['selected'])
{{--
<option disabled {{count($selected)  == 0 ? 'selected' : ''}}>
    Please select the range
</option> --}}

@foreach (config('arrays.regions') as $item)
<option value="{{$item}}" {{in_array($item, $selected) ? 'selected' : ''}}>{{$item}}</option>
@endforeach
