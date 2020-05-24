@props(['question', 'fileUploadRoute', 'disabled', 'required'])

@php
    $randId = random_int(100, 9000);
    $identifier = $question->id . $randId;
@endphp

<div class="form-group">
    <label>{{$question->originalQuestion->label}}{{$question->originalQuestion->required ? '*' : ''}}</label>
    <input
        id="file-{{$identifier}}"
        {{$disabled ? 'disabled' : ''}}
        {{$required ? 'required' : ''}}
        class="file-upload-default"
        name="file"
        type="file">

    <div class="input-group col-xs-12">
        <input
            id="input-{{$identifier}}"
            disabled
            class="form-control file-upload-info"
            value="{{$question->response ? 'File selected' : 'No file selected'}}"
            type="text">
        @if (!$disabled)
        <span class="input-group-append">
            <button class="btn btn-primary" id="button-{{$identifier}}" type="button">
                <span
                    class="input-group-append"
                    id="span-{{$identifier}}">{{$question->response ? 'Replace file' : 'Select file'}}</span>
            </button>
        </span>
        @endif
    </div>
</div>

@section('scripts')
@parent
<script>
    $(document).ready(function() {
        $('#button-{{$identifier}}').on('click', function(e) {
            console.log('hey')
            $("#file-{{$identifier}}").trigger('click');
        });

        $('#input-{{$identifier}}').on('click', function(e) {
            if ({{$question->response ? 'true' : 'false'}}) {
                window.open('/storage/questionFiles/{{$question->response}}', '_blank');
            }
        });

        $("#file-{{$identifier}}").change(function (){
            var fileName = $(this).val().split('\\').pop();

            $('#span-{{$identifier}}').html('Replace file')
            $("#input-{{$identifier}}").val(fileName);

            var formData = new FormData();
            formData.append('image', $(this).get(0).files[0]);
            $.ajax({
                url : "{{$fileUploadRoute}}",
                type: "POST",
                data : formData,
                processData: false,
                contentType: false,
            });
        });
    });
</script>
@endsection
