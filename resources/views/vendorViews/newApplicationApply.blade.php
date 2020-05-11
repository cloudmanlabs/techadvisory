@extends('vendorViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="projects" />


        <div class="page-wrapper">
            <div class="page-content">
                <x-vendor.projectNavbar section="apply" :project="$project"/>

                <x-video :src="nova_get_setting('vendor_NewApplication')" />

                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>Apply to project</h3>
                                <p class="welcome_text extra-top-15px">Please complete your profile and get ready to use the platform. It won't take you more than just a few minutes and you can do it today. Note that, if you do not currently have the info for some specific fields, you can leave them blank and fill up them later.</p>
                                <br>
                                <div id="wizard_vendor_go_to_home">
                                    <h2>Fit gap</h2>
                                    <section>
                                        <h4>Fit Gap</h4>
                                        <br>
                                        <p>
                                            Phasellus vehicula suscipit mauris, et aliquet urna. Fusce sed ipsum eu
                                            nunc
                                            pellentesque luctus. ipsum dolor sit amet, consectetur adipiscing elit.
                                            Donec
                                            aliquam ornare sapien, ut dictum nunc pharetra a.Phasellus vehicula
                                            suscipit
                                            mauris, et aliquet urna. Fusce sed ipsum eu nunc pellentesque luctus.
                                            ipsum
                                            dolor sit amet.
                                        </p>
                                        <br><br>
                                        <div style="text-align: center;">
                                            <div class="input-group col-xs-12">
                                                <input class="form-control file-upload-info"
                                                    placeholder="Upload Fit Gap model in CSV format"
                                                    type="text">
                                                <span class="input-group-append">
                                                    <button
                                                        class="file-upload-browse btn btn-primary"
                                                        type="button">
                                                        <span class="input-group-append">Upload</span>
                                                    </button>
                                                </span>
                                            </div>
                                            <div class="modal fade bd-example-modal-xl" tabindex="-1"
                                                role="dialog" aria-labelledby="myExtraLargeModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                Please
                                                                complete the Fit Gap table</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <iframe
                                                                src="{{url('/assets/vendors_techadvisory/jexcel-3.6.1/doc.html')}}"
                                                                style="width: 100%; min-height: 600px; border: none;"></iframe>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-primary btn-lg btn-icon-text"
                                                                data-toggle="modal"
                                                                data-target=".bd-example-modal-xl"><svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" stroke="currentColor"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    class="feather feather-check-square btn-icon-prepend">
                                                                    <polyline points="9 11 12 14 22 4">
                                                                    </polyline>
                                                                    <path
                                                                        d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11">
                                                                    </path>
                                                                </svg> Done</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br><br>
                                        <h4>Questions</h4>
                                        <br>
                                        <x-questionForeach :questions="$fitgapQuestions" :class="'selectionCriteriaQuestion'" :disabled="false"
                                            :required="false" />
                                    </section>

                                    <h2>Vendor</h2>
                                    <section>
                                        <h4>Corporate information</h4>
                                        <br>
                                        <x-questionForeach :questions="$vendorCorporateQuestions" :class="'selectionCriteriaQuestion'" :disabled="false" :required="false" />

                                        <br><br>
                                        <h4>Market presence</h4>
                                        <x-questionForeach :questions="$vendorMarketQuestions" :class="'selectionCriteriaQuestion'" :disabled="false" :required="false" />
                                    </section>

                                    <h2>Experience</h2>
                                    <section>
                                        <h4>Questions</h4>
                                        <br>
                                        <x-questionForeach :questions="$experienceQuestions" :class="'selectionCriteriaQuestion'" :disabled="false"
                                            :required="false" />
                                    </section>

                                    <h2>Innovation & Vision</h2>
                                    <section>
                                        <h4>IT Enablers</h4>
                                        <br>
                                        <x-questionForeach :questions="$innovationDigitalEnablersQuestions" :class="'selectionCriteriaQuestion'" :disabled="false" :required="false" />

                                        <h4>Alliances</h4>
                                        <br>
                                        <x-questionForeach :questions="$innovationAlliancesQuestions" :class="'selectionCriteriaQuestion'" :disabled="false" :required="false" />

                                        <h4>Product</h4>
                                        <br>
                                        <x-questionForeach :questions="$innovationProductQuestions" :class="'selectionCriteriaQuestion'" :disabled="false" :required="false" />

                                        <h4>Sustainability</h4>
                                        <br>
                                        <x-questionForeach :questions="$innovationSustainabilityQuestions" :class="'selectionCriteriaQuestion'" :disabled="false" :required="false" />
                                    </section>

                                    <h2>Implementation & Commercials</h2>
                                    <section>
                                        <h4>Implementation</h4>
                                        <br>
                                        <x-questionForeach :questions="$implementationImplementationQuestions" :class="'selectionCriteriaQuestion'"
                                            :disabled="false" :required="false" />

                                        <h4>Deliverables per phase</h4>
                                        <x-questionForeach :questions="$implementationRunQuestions" :class="'selectionCriteriaQuestion'"
                                            :disabled="false" :required="false" />
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-footer />
        </div>
    </div>
@endsection

@section('head')
@parent

<style>
    select.form-control {
        color: #495057;
    }

    .select2-results__options .select2-results__option[aria-disabled=true] {
        display: none;
    }
</style>
@endsection

@section('scripts')
@parent
<script>
    jQuery.expr[':'].hasValue = function(el,index,match) {
        return el.value != "";
    };

    /**
     *  Returns false if any field is empty
     */
    function checkIfAllRequiredsAreFilled(){
        let array = $('input,textarea,select').filter('[required]').toArray();
		if(array.length == 0) return true;

        return array.reduce((prev, current) => {
            return !prev ? false : $(current).is(':hasValue')
        }, true)
    }

    function checkIfAllRequiredsInThisPageAreFilled(){
        let array = $('input,textarea,select').filter('[required]:visible').toArray();
        if(array.length == 0) return true;

        return array.reduce((prev, current) => {
            return !prev ? false : $(current).is(':hasValue')
        }, true)
    }

    function updateSubmitButton()
    {
        // If we filled all the fields, remove the disabled from the button.
        if(checkIfAllRequiredsAreFilled()){
            $('#submitButton').attr('disabled', false)
        } else {
            $('#submitButton').attr('disabled', true)
        }
    }

    function showSavedToast()
    {
        $.toast({
            heading: 'Saved!',
            showHideTransition: 'slide',
            icon: 'success',
            hideAfter: 1000,
            position: 'bottom-right'
        })
    }

    $(document).ready(function() {
        $('.selectionCriteriaQuestion input,.selectionCriteriaQuestion textarea,.selectionCriteriaQuestion select')
            .filter(function(el) {
                return $( this ).data('changing') !== undefined
            })
            .change(function (e) {
                var value = $(this).val();
                if($.isArray(value) && value.length == 0 && $(this).attr('multiple') !== undefined){
                    value = '[]'
                }

                $.post('/selectionCriteriaQuestion/changeResponse', {
                    changing: $(this).data('changing'),
                    value
                })

                showSavedToast();
                updateSubmitButton();
            });

        $(".js-example-basic-single").select2();
        $(".js-example-basic-multiple").select2();

        $('.datepicker').each(function(){
            var date = new Date($(this).data('initialvalue'));

            $(this).datepicker({
                format: "mm/dd/yyyy",
                todayHighlight: true,
                autoclose: true
            });
            $(this).datepicker('setDate', date);
        });
    });
</script>
@endsection
