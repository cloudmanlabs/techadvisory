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

{{--
    Used in accenture.newProjectSetUp to decide which Sizing questions to show to the client
    --}}
