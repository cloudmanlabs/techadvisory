@props(['vendorApplication', 'disabled',])

@php
    $disabled = $disabled ?? false;
@endphp

<div class="form-group questionDiv selectionCriteriaQuestion" data-practice="">
    <label>Solutions used *</label>
    <select id="solutionsUsedSelect"
            class="js-example-basic-multiple w-100 form-control"
            multiple="multiple"
            required
        {{ $disabled ? 'disabled' : '' }}
    >
        <x-options.vendorSolutions :selected="$vendorApplication->solutionsUsed" :vendor="$vendorApplication->vendor"/>
    </select>
</div>

@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            $('#solutionsUsedSelect').change(function () {
                $.post('/vendorApplication/updateSolutionsUsed', {
                    changing: {{$vendorApplication->id}},
                    value: $(this).val()
                }).done(function () {
                    showSavedToast();
                    if (updateSubmitButton) {
                        updateSubmitButton();
                    }
                }).fail(handleAjaxError)
            })
        });
    </script>
@endsection
