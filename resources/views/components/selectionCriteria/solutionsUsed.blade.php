@props(['vendorApplication', 'disabled',])

@php
$disabled = $disabled ?? false;
@endphp

<div class="form-group questionDiv selectionCriteriaQuestion">
    <label>Solutions used*</label>
    <select id="solutionsUsedSelect" {{$disabled ? 'disabled' : ''}} class="js-example-basic-multiple w-100 form-control" multiple="multiple">
        <x-options.vendorSolutions :selected="$vendorApplication->solutionsUsed" :vendor="$vendorApplication->vendor" />
    </select>
</div>

@section('scripts')
@parent
<script>
    $(document).ready(function() {
        $('#solutionsUsedSelect').change(function(){
            $.post('/vendorApplication/updateSolutionsUsed', {
                changing: {{$vendorApplication->id}},
                value: $(this).val()
            })
            showSavedToast();
        })
    });
</script>
@endsection
