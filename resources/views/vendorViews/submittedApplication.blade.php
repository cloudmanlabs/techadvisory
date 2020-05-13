@extends('vendorViews.layouts.forms')

@section('content')
    <div class="main-wrapper">
        <x-vendor.navbar activeSection="projects" />


        <div class="page-wrapper">
            <div class="page-content">
                <x-vendor.projectNavbar section="apply" :project="$project"/>

                <x-video :src="nova_get_setting('video_application')" />

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

                                        <x-fitgapVendorModal :vendor="auth()->user()" :project="$project" :disabled="true" />

                                        <br><br>
                                        <h4>Questions</h4>
                                        <br>
                                        <x-questionForeach :questions="$fitgapQuestions" :class="'selectionCriteriaQuestion'" :disabled="true"
                                            :required="false" />
                                    </section>

                                    <h2>Vendor</h2>
                                    <section>
                                        <h4>Corporate information</h4>
                                        <br>
                                        <x-questionForeach :questions="$vendorCorporateQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :required="false" />

                                        <br><br>
                                        <h4>Market presence</h4>
                                        <x-questionForeach :questions="$vendorMarketQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :required="false" />
                                    </section>

                                    <h2>Experience</h2>
                                    <section>
                                        <h4>Questions</h4>
                                        <br>
                                        <x-questionForeach :questions="$experienceQuestions" :class="'selectionCriteriaQuestion'" :disabled="true"
                                            :required="false" />
                                    </section>

                                    <h2>Innovation & Vision</h2>
                                    <section>
                                        <h4>IT Enablers</h4>
                                        <br>
                                        <x-questionForeach :questions="$innovationDigitalEnablersQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :required="false" />

                                        <h4>Alliances</h4>
                                        <br>
                                        <x-questionForeach :questions="$innovationAlliancesQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :required="false" />

                                        <h4>Product</h4>
                                        <br>
                                        <x-questionForeach :questions="$innovationProductQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :required="false" />

                                        <h4>Sustainability</h4>
                                        <br>
                                        <x-questionForeach :questions="$innovationSustainabilityQuestions" :class="'selectionCriteriaQuestion'" :disabled="true" :required="false" />
                                    </section>

                                    <h2>Implementation & Commercials</h2>
                                    <section>
                                        <h4>Implementation</h4>
                                        <br>
                                        <x-questionForeach :questions="$implementationImplementationQuestions" :class="'selectionCriteriaQuestion'"
                                            :disabled="true" :required="false" />

                                        <h4>Deliverables per phase</h4>
                                        <x-questionForeach :questions="$implementationRunQuestions" :class="'selectionCriteriaQuestion'"
                                            :disabled="true" :required="false" />
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
