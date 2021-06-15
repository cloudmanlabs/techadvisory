{{--
    Simple list of fields to edit the Project weights
    --}}

@props(['project', 'isClient'])

@php

    $weightValues = [
        isset($project->fitgapFunctionalWeight) ? $project->fitgapFunctionalWeight / 5 : 5,
        isset($project->fitgapTechnicalWeight) ? $project->fitgapTechnicalWeight / 5 : 5,
        isset($project->fitgapServiceWeight) ? $project->fitgapServiceWeight / 5 : 5,
        isset($project->fitgapOthersWeight) ? $project->fitgapOthersWeight / 5 : 5
    ];

    $weightDataId = 0;

    $implementationValues = [
        isset($project->implementationImplementationWeight) ? $project->implementationImplementationWeight / 5 : 10,
        isset($project->implementationRunWeight) ? $project->implementationRunWeight / 5 : 10
    ];

    $implementationDataId = 0;

    $isClient = $isClient ?? false;
@endphp

<div>
    <h3>FitGap weights</h3>
    <p class="welcome_text extra-top-15px">
        In case you want to apply a different weight in sections inside Fit Gap,
        please specify a percentage. To do so, drag and drop the building blocks.
    </p>
    <br>
    {{--<div class="form-area">
        <div class="row">
            @foreach($level1s as $el)
                <div class="col-6">
                    <label for="useCaseSolutionFit">{{ $el -> name }}*</label>
                    <br>
                </div>
                <div class="col-3">
                    <div class="input-group">
                        <input type="number" max="100" accuracy="2" min="0"
                               style="text-align:left;" class="form-control"
                               id="useCaseSolutionFit" placeholder="20"
                               required>
                        <div class="input-group-append simulateInputBox">
                            <span class="input-group-text simulateInput">%</span>
                        </div>
                    </div>
                    <br>
                </div>
            @endforeach
        </div>
    </div>--}}

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Selection Criteria</th>
                    <th>Year Cost Vendor</th>
                    <th>Total percentage</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>1. Functional*</td>
                    <td>
                        <ul id="functionalBricks" class="brickList">
                            @for ($i = 0; $i < $weightValues[0]; $i++)
                            <li data-id="{{$weightDataId++}}">
                                5%
                            </li>
                            @endfor
                        </ul>
                    </td>
                    <td id="functionalTotal">
                        {{$weightValues[0] * 5}}%
                    </td>
                </tr>

                <tr>
                    <td>2. Technical*</td>
                    <td>
                        <ul id="technicalBricks" class="brickList">
                            @for ($i = 0; $i < $weightValues[1]; $i++)
                            <li data-id="{{$weightDataId++}}">
                                5%
                            </li>
                            @endfor
                        </ul>
                    </td>
                    <td id="technicalTotal">
                        {{$weightValues[1] * 5}}%
                    </td>
                </tr>

                <tr>
                    <td>3. Service*</td>
                    <td>
                        <ul id="serviceBricks" class="brickList">
                            @for ($i = 0; $i < $weightValues[2]; $i++)
                            <li data-id="{{$weightDataId++}}">
                                5%
                            </li>
                            @endfor
                        </ul>
                    </td>
                    <td id="serviceTotal">
                        {{$weightValues[2] * 5}}%
                    </td>
                </tr>

                <tr>
                    <td>4. Others*</td>
                    <td>
                        <ul id="othersBricks" class="brickList">
                            @for ($i = 0; $i < $weightValues[3]; $i++)
                            <li data-id="{{$weightDataId++}}">
                                5%
                            </li>
                            @endfor
                        </ul>
                    </td>
                    <td id="othersTotal">
                        {{$weightValues[3] * 5}}%
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<div>
    <h3>Implementation & Commercials weights</h3>
    <p class="welcome_text extra-top-15px">
        In case you want to apply a different weight in sections inside Implementation & Commercials,
        please specify a percentage. To do so, drag and drop the building blocks.
    </p>
    <br>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Selection Criteria</th>
                    <th>Year Cost Vendor</th>
                    <th>Total percentage</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>1. Implementation*</td>
                    <td>
                        <ul id="detailImplementationBricks" class="brickList">
                            @for ($i = 0; $i < $implementationValues[0]; $i++)
                            <li data-id="{{$implementationDataId++}}">
                                5%
                            </li>
                            @endfor
                        </ul>
                    </td>
                    <td id="detailImplementationTotal">
                        {{$implementationValues[0] * 5}}%
                    </td>
                </tr>

                <tr>
                    <td>2. Run*</td>
                    <td>
                        <ul id="runBricks" class="brickList">
                            @for ($i = 0; $i < $implementationValues[1]; $i++)
                            <li data-id="{{$implementationDataId++}}">
                                5%
                            </li>
                            @endfor
                        </ul>
                    </td>
                    <td id="runTotal">
                        {{$implementationValues[1] * 5}}%
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    // Timeout cause otherwise the steps thingy messes it up
    setTimeout(function(){
        weightSetUp();
        updateFitGapWeights(false);
        updateImplementationWeights(false);
    }, 3000);

    function weightSetUp() {
        var functionalBricks = document.getElementById("functionalBricks");
        var technicalBricks = document.getElementById("technicalBricks");
        var serviceBricks = document.getElementById("serviceBricks");
        var othersBricks = document.getElementById("othersBricks");

        var detailImplementationBricks = document.getElementById("detailImplementationBricks");
        var runBricks = document.getElementById("runBricks");

        sortableFunctional = new Sortable(functionalBricks, {
            group: {
                name: "shared"
            },
            animation: 150,
            ghostClass: "sortable-ghost",
            onEnd: function() {
                updateFitGapWeights(true);
            }
        });
        sortableTechnical = new Sortable(technicalBricks, {
            group: {
                name: "shared"
            },
            animation: 150,
            ghostClass: "sortable-ghost",
            onEnd: function() {
                updateFitGapWeights(true);
            }
        });
        sortableService = new Sortable(serviceBricks, {
            group: {
                name: "shared"
            },
            animation: 150,
            ghostClass: "sortable-ghost",
            onEnd: function() {
                updateFitGapWeights(true);
            }
        });
        sortableOthers = new Sortable(othersBricks, {
            group: {
                name: "shared"
            },
            animation: 150,
            ghostClass: "sortable-ghost",
            onEnd: function() {
                updateFitGapWeights(true);
            }
        });

        sortableDetailImplementation = new Sortable(detailImplementationBricks, {
            group: {
                name: "shared"
            },
            animation: 150,
            ghostClass: "sortable-ghost",
            onEnd: function() {
                updateImplementationWeights(true);
            }
        });

        sortableRun = new Sortable(runBricks, {
            group: {
                name: "shared"
            },
            animation: 150,
            ghostClass: "sortable-ghost",
            onEnd: function() {
                updateImplementationWeights(true);
            }
        });
    }

    function updateFitGapWeights(showToast){
        var functionalBricks = document.getElementById("functionalBricks");
        var technicalBricks = document.getElementById("technicalBricks");
        var serviceBricks = document.getElementById("serviceBricks");
        var othersBricks = document.getElementById("othersBricks");
        document.getElementById("functionalTotal").innerHTML =
            functionalBricks.childElementCount * 5 + "%";
        document.getElementById("technicalTotal").innerHTML =
            technicalBricks.childElementCount * 5 + "%";
        document.getElementById("serviceTotal").innerHTML =
            serviceBricks.childElementCount * 5 + "%";
        document.getElementById("othersTotal").innerHTML =
            othersBricks.childElementCount * 5 + "%";
        updateWeight('fitgapFunctionalWeight', functionalBricks.childElementCount * 5);
        updateWeight('fitgapTechnicalWeight', technicalBricks.childElementCount * 5);
        updateWeight('fitgapServiceWeight', serviceBricks.childElementCount * 5);
        updateWeight('fitgapOthersWeight', othersBricks.childElementCount * 5);

        if(showToast){
            $.toast({
                heading: 'Saved!',
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 1000,
                position: 'bottom-right'
            })
        }
    }

    function updateImplementationWeights(showToast){
        var detailImplementationBricks = document.getElementById("detailImplementationBricks");
        var runBricks = document.getElementById("runBricks");

        document.getElementById("detailImplementationTotal").innerHTML =
            detailImplementationBricks.childElementCount * 5 + "%";
        document.getElementById("runTotal").innerHTML =
            runBricks.childElementCount * 5 + "%";

        updateWeight('implementationImplementationWeight', detailImplementationBricks.childElementCount * 5);
        updateWeight('implementationRunWeight', runBricks.childElementCount * 5);

        if(showToast){
            $.toast({
                heading: 'Saved!',
                showHideTransition: 'slide',
                icon: 'success',
                hideAfter: 1000,
                position: 'bottom-right'
            })
        }
    }

    function updateWeight(changing, value) {
        $.post('/{{$isClient ? "client" : "accenture"}}/newProjectSetUp/changeWeights', {
            project_id: '{{$project->id}}',
            changing,
            value
        }).fail(handleAjaxError)
    }
</script>
@endsection
