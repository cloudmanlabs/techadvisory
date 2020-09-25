{{--
    Contains the part of Selection criteria questions used in Accenture and Client
    Only shows question titles

    This is part of the subwizard
    --}}

@props(['project','vendorCorporateQuestions','vendorMarketQuestions','experienceQuestions','innovationDigitalEnablersQuestions','innovationAlliancesQuestions','innovationProductQuestions','innovationSustainabilityQuestions','implementationImplementationQuestions','implementationRunQuestions'])

<h3>Vendor</h3>
<div>
    <p class="welcome_text extra-top-15px">
        This section is designed to deep dive into the vendor company and its market presence.
    </p>
    <br>
    <h4>Corporate information</h4>
    <p class="welcome_text extra-top-15px">
        Below is the questionnaire designed to know more about the vendor company.
    </p>
    <br>
    @foreach ($vendorCorporateQuestions as $question)
        @if($question->practice_id == $project->practice_id || empty($question->practice_id))
            <h6 style="margin-bottom: 1rem">
                {{$question->label}}
            </h6>
        @endif
    @endforeach

    <br><br>
    <h4>Market presence</h4>
    <p class="welcome_text extra-top-15px">
        Below is the questionnaire designed to know more about the vendor’s presence in the market.
    </p>
    <br>
    @foreach ($vendorMarketQuestions as $question)
        @if($question->practice_id == $project->practice_id || empty($question->practice_id))
            <h6 style="margin-bottom: 1rem">
                {{$question->label}}
            </h6>
        @endif
    @endforeach
</div>

<h3>Experience</h3>
<div>
    <p class="welcome_text extra-top-15px">
        This section is designed to know more about the vendor’s previous experiences in the industry and with other
        clients.
    </p>
    <br>
    <h4>Questions</h4>
    <p class="welcome_text extra-top-15px">
        Below is the questionnaire designed to know more about the vendor’s previous experiences with other clients and
        within the industry.
    </p>
    <br>
    @foreach ($experienceQuestions as $question)
        @if($question->practice_id == $project->practice_id || empty($question->practice_id))
            <h6 style="margin-bottom: 1rem">
                {{$question->label}}
            </h6>
        @endif
    @endforeach
</div>

<h3>Innovation & Vision</h3>
<div>
    <p class="welcome_text extra-top-15px">
        This section includes different questionnaires intended to know more about the vendor on
        IT enablers used, existing alliances, product insights and sustainability guidelines.
    </p>
    <br>
    <h4>IT Enablers</h4>
    <p class="welcome_text extra-top-15px">
        Below is the questionnaire designed to know more about the IT enablers currently in use
        by vendor solutions.
    </p>
    <br>
    @foreach ($innovationDigitalEnablersQuestions as $question )
        @if($question->practice_id == $project->practice_id || empty($question->practice_id))
            <h6 style="margin-bottom: 1rem">
                {{$question->label}}
            </h6>
        @endif
    @endforeach
    <br><br>
    <h4>Alliances</h4>
    <p class="welcome_text extra-top-15px">
        Below is the questionnaire designed to know more about vendor alliances with other solution providers.
    </p>
    <br>
    @foreach ($innovationAlliancesQuestions as $question)
        @if($question->practice_id == $project->practice_id || empty($question->practice_id))
            <h6 style="margin-bottom: 1rem">
                {{$question->label}}
            </h6>
        @endif
    @endforeach
    <br><br>
    <h4>Product</h4>
    <p class="welcome_text extra-top-15px">
        Below is the questionnaire designed to know more insights about vendor products.
    </p>
    <br>
    <br>
    @foreach ($innovationProductQuestions as $question)
        @if($question->practice_id == $project->practice_id || empty($question->practice_id))
            <h6 style="margin-bottom: 1rem">
                {{$question->label}}
            </h6>
        @endif
    @endforeach
    <br><br>
    <h4>Sustainability</h4>
    <p class="welcome_text extra-top-15px">
        Below is the questionnaire designed to know more about vendor sustainability guidelines.
    </p>
    <br>
    <br>
    @foreach ($innovationSustainabilityQuestions as $question)
        @if($question->practice_id == $project->practice_id || empty($question->practice_id))
            <h6 style="margin-bottom: 1rem">
                {{$question->label}}
            </h6>
        @endif
    @endforeach
</div>

<h3>Implementation & Commercials</h3>
<div>
    <p class="welcome_text extra-top-15px">
        This section is focused on gathering relevant information about implementation project plan,
        main deliverables and RACI, as well as cost estimation for both implementation and run phases.
    </p>
    <br>
    <h4>Implementation</h4>
    <p class="welcome_text extra-top-15px">
        Below are the details that will be required from vendors for the implementation phase.
    </p>
    <br>

    <h6 style="margin-bottom: 1rem">
        Project plan
    </h6>
    <h6 style="margin-bottom: 1rem">
        Solutions Used
    </h6>
    <h6 style="margin-bottom: 1rem">
        Deliverables per phase
    </h6>
    <h6 style="margin-bottom: 1rem">
        RACI Matrix
    </h6>
    <h6 style="margin-bottom: 1rem">
        Overall Implementation cost
    </h6>
    <li style="margin-bottom: 1rem; font-size: .9375rem; font-weight: 600;">
        Staffing cost
    </li>
    <li style="margin-bottom: 1rem; font-size: .9375rem; font-weight: 600;">
        Travel cost
    </li>
    <li style="margin-bottom: 1rem; font-size: .9375rem; font-weight: 600;">
        Additional cost
    </li>


    <br><br>
    <h4>Run</h4>
    <p class="welcome_text extra-top-15px">
        Below are the details that will be required from vendors for the run phase.
    </p>
    <br>
    <h6 style="margin-bottom: 1rem">
        Pricing model
    </h6>
    <h6 style="margin-bottom: 1rem">
        Run cost
    </h6>
    <li style="margin-bottom: 1rem; font-size: .9375rem; font-weight: 600;">
        Estimate first 5 years billing plan
    </li>
    <li style="margin-bottom: 1rem; font-size: .9375rem; font-weight: 600;">
        Describe the breakdown of the first five years of the Run Billing Plan
    </li>
</div>
