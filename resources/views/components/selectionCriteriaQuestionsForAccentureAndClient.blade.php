{{--
    Contains the part of Selection criteria questions used in Accenture and Client
    Only shows question titles

    This is part of the subwizard
    --}}

@props(['vendorCorporateQuestions','vendorMarketQuestions','experienceQuestions','innovationDigitalEnablersQuestions','innovationAlliancesQuestions','innovationProductQuestions','innovationSustainabilityQuestions','implementationImplementationQuestions','implementationRunQuestions'])

<h3>Vendor</h3>
<div>
    <h4>Corporate information</h4>
    <br>
    @foreach ($vendorCorporateQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
    @endforeach

    <br><br>
    <h4>Market presence</h4>
    <br>
    @foreach ($vendorMarketQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
    @endforeach
</div>

<h3>Experience</h3>
<div>
    <h4>Questions</h4>
    <br>
    @foreach ($experienceQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
    @endforeach
</div>

<h3>Innovation & Vision</h3>
<div>
    <h4>IT Enablers</h4>
    <br>
    @foreach ($innovationDigitalEnablersQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
    @endforeach
    <br><br>
    <h4>Alliances</h4>
    <br>
    @foreach ($innovationAlliancesQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
    @endforeach
    <br><br>
    <h4>Product</h4>
    <br>
    @foreach ($innovationProductQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
    @endforeach
    <br><br>
    <h4>Sustainability</h4>
    <br>
    @foreach ($innovationSustainabilityQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
    @endforeach
</div>

<h3>Implementation & Commercials</h3>
<div>
    <h4>Implementation</h4>
    <br>
    @foreach ($implementationImplementationQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
    @endforeach
    <br><br>
    <h4>Run</h4>
    <br>
    @foreach ($implementationRunQuestions as $question)
        <h6 style="margin-bottom: 1rem">
            {{$question->label}}
        </h6>
    @endforeach
</div>
