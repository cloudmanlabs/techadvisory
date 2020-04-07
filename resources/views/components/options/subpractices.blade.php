@props(['selected'])

@foreach (\App\Subpractice::all() as $subpractice)
    <option value="{{$subpractice->id}}" {{in_array($subpractice->id, $selected) ? 'selected' : ''}}>{{$subpractice->name}}</option>
@endforeach
