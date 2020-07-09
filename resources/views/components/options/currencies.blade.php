@props(['selected'])

<option disabled {{strlen($selected)  == 0 ? 'selected' : ''}}>
    Please select an option
</option>

@foreach (config('arrays.currencies') as $item)
<option value="{{$item}}" {{($item == $selected) ? 'selected' : ''}}>{{$item}}</option>
@endforeach
