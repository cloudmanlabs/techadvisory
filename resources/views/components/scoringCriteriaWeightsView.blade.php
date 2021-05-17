@props(['project'])

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

@endphp

<div>
    <h3>FitGap weights</h3>
    <p class="welcome_text extra-top-15px">
        In case you want to apply a different weight in sections inside Fit Gap,
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
                    <td>1. Functional*</td>
                    <td>
                        <ul id="functionalBricks" class="brickList">
                            @for ($i = 0; $i < $weightValues[0]; $i++)
                            <li data-id="{{$weightDataId++}}" style="cursor: default">
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
                            <li data-id="{{$weightDataId++}}" style="cursor: default">
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
                            <li data-id="{{$weightDataId++}}" style="cursor: default">
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
                            <li data-id="{{$weightDataId++}}" style="cursor: default">
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
                            <li data-id="{{$implementationDataId++}}" style="cursor: default">
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
                            <li data-id="{{$implementationDataId++}}" style="cursor: default">
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
