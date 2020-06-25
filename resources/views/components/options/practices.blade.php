@props(['selected'])

<option selected="" disabled="">Please select your Practice</option>

@foreach (\App\Practice::all() as $practice)
<option value="{{$practice->id}}" {{$practice->id === $selected ? 'selected' : ''}}>{{$practice->name}}
</option>
@endforeach
