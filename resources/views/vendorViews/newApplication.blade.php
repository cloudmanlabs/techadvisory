@extends('vendorViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="projects" />

        <div class="page-wrapper">
            <div class="page-content">

                <x-vendor.projectNavbar section="info" :project="$project" />

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3>View project information</h3>
                                <p calss="welcome_text extra-top-15px">
                                    {{nova_get_setting('vendor_project_information') ?? ''}}
                                </p>
                                <br>
                                <div id="projectViewWizard">
                                    <h2>General Info</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            This section contains all relevant information concerning project type, scope and timelines.
                                        </P>
                                        <br>
                                        <x-generalInfoQuestions
                                            :project="$project"
                                            :clients="$clients"
                                            :disableSpecialQuestions="true"
                                            :disabled="true"
                                            :required="false" />
                                    </section>

                                    <h2>RFP Upload</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            This section contains the physical RFP document provided by the client.
                                        </p>
                                        <br>
                                        <h4>2.1 RFP</h4>
                                        <br>
                                        <x-folderFileUploader :folder="$project->rfpFolder" label="Upload your RFP" :disabled="true" :timeout="1000" />

                                        <div class="form-group">
                                            <label for="rfpOtherInfo">Other information</label>
                                            <textarea class="form-control" id="rfpOtherInfo" rows="14" disabled>{{$project->rfpOtherInfo}}</textarea>
                                        </div>
                                    </section>

                                    <h2>Sizing Info</h2>
                                    <section>
                                        <p class="welcome_text extra-top-15px">
                                            This section contains useful information for you to consider in the sizing of your proposal.
                                        </p>
                                        <br>
                                        <x-questionForeach :questions="$sizingQuestions" :class="'sizingQuestion'" :disabled="true"
                                            :required="false" />
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <x-deadline :project="$project" />
            </div>

            <x-footer />
        </div>
    </div>
@endsection

@section('scripts')
@parent
<script>
    $(document).ready(function() {
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
