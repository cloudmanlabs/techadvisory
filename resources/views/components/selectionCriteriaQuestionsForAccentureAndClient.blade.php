{{--
    Contains the part of Selection criteria questions used in Accenture and Client
    Only shows question titles

    This is part of the subwizard
    --}}

@props(['vendorCorporateQuestions','vendorMarketQuestions','experienceQuestions','innovationDigitalEnablersQuestions','innovationAlliancesQuestions','innovationProductQuestions','innovationSustainabilityQuestions','implementationImplementationQuestions','implementationRunQuestions'])

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
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
    @endforeach

    <br><br>
    <h4>Market presence</h4>
    <p class="welcome_text extra-top-15px">
        Below is the questionnaire designed to know more about the vendor’s presence in the market.
    </p>
    <br>
    @foreach ($vendorMarketQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
    @endforeach
</div>

<h3>Experience</h3>
<div>
    <p class="welcome_text extra-top-15px">
        This section is designed to know more about the vendor’s previous experiences in the industry and with other clients.
    </p>
    <br>
    <h4>Questions</h4>
    <p class="welcome_text extra-top-15px">
        Below is the questionnaire designed to know more about the vendor’s previous experiences with other clients and within the industry.
    </p>
    <br>
    @foreach ($experienceQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
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
    @foreach ($innovationDigitalEnablersQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
    @endforeach
    <br><br>
    <h4>Alliances</h4>
    <p class="welcome_text extra-top-15px">
        Below is the questionnaire designed to know more about vendor alliances with other solution providers.
    </p>
    <br>
    @foreach ($innovationAlliancesQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
    @endforeach
    <br><br>
    <h4>Product</h4>
    <p class="welcome_text extra-top-15px">
        Below is the questionnaire designed to know more insights about vendor products.
    </p>
    <br>
    <br>
    @foreach ($innovationProductQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
    @endforeach
    <br><br>
    <h4>Sustainability</h4>
    <p class="welcome_text extra-top-15px">
        Below is the questionnaire designed to know more about vendor sustainability guidelines.
    </p>
    <br>
    <br>
    @foreach ($innovationSustainabilityQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
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
    @foreach ($implementationImplementationQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
    @endforeach
    <br><br>
    <h4>Run</h4>
    <p class="welcome_text extra-top-15px">
        Below are the details that will be required from vendors for the run phase.
    </p>
    <br>
    @foreach ($implementationRunQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
    @endforeach
</div>
