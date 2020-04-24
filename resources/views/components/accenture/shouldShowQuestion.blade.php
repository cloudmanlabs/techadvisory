@props(['changing', 'shouldShow'])

<div class="formItemContainer">
    <div class="form-group">
        {{ $slot }}
    </div>
    <div class="checkboxesDiv">
        <input
            type="checkbox"
            name="asdf"
            data-changingid="{{$changing}}"
            {{$shouldShow ? 'checked' : ''}}>
    </div>
</div>
