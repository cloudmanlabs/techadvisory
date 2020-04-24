@props(['changing', 'score'])

<div class="formItemContainer">
    <div class="form-group">
        {{ $slot }}
    </div>
    <div class="evalDiv">
        <input type="number" name="asdf"
        min="0"
        max="10"
        data-changingid="{{$changing}}"
        value="{{$score}}"
        onkeypress="if(event.which &lt; 48 || event.which &gt; 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
    </div>
</div>
