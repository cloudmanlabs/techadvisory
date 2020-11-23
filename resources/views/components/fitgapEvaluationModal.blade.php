{{--
    Component that contains the modal for the fitgap for Accenture when evaluating vendors
    --}}

@props(['project', 'vendor', 'disabled'])

@php
$disabled = $disabled ?? false;
$review = $review ?? false;
@endphp

<div style="text-align: center;">
    <button type="button" class="btn btn-primary btn-lg btn-icon-text" data-toggle="modal"
        data-target=".bd-example-modal-xl"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="feather feather-check-square btn-icon-prepend">
            <polyline points="9 11 12 14 22 4"></polyline>
            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
        </svg> Complete Fit Gap table</button>

    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-width: unset; margin: 30px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Please complete the Fit Gap table</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe src="{{route('fitgapEvaluationIframe', ['project' => $project, 'vendor' => $vendor, 'disabled' => $disabled])}}"
                        style="width: 100%; min-height: 600px; border: none;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-lg btn-icon-text" data-toggle="modal"
                        data-target=".bd-example-modal-xl"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-check-square btn-icon-prepend">
                            <polyline points="9 11 12 14 22 4"></polyline>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                        </svg> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
