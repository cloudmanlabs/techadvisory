@props(['selected'])

@foreach (\App\Subpractice::all() as $subpractice)
    <option
        value="{{$subpractice->id}}"
        data-practiceid="{{$subpractice->practice->id}}"
        {{in_array($subpractice->id, $selected) ? 'selected' : ''}}
    >{{$subpractice->name}}</option>
@endforeach
