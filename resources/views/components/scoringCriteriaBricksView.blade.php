@props(['project'])

@php
$values = $project->scoringValues ?? [0, 0, 0, 0, 0];

$dataId = 0;
@endphp

<h3>Overall weights</h3>
<br>
<p class="welcome_text extra-top-15px">
    In case you want to apply a different weight in sections inside Fit Gap,
    please specify a percentage. To do so, drag and drop the building blocks.
</p>

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
                <td>1. Fitgap</td>
                <td>
                    <ul id="fitgapBricks" class="brickList">
                        @for ($i = 0; $i < $values[0]; $i++)
                        <li data-id="{{$dataId++}}" style="cursor: default">
                            5%
                        </li>
                        @endfor
                    </ul>
                </td>
                <td id="fitgapTotal">
                    {{$values[0] * 5}}%
                </td>
            </tr>

            <tr>
                <td>2. Vendor</td>
                <td>
                    <ul id="vendorBricks" class="brickList">
                        @for ($i = 0; $i < $values[1]; $i++)
                        <li data-id="{{$dataId++}}" style="cursor: default">
                            5%
                        </li>
                        @endfor
                    </ul>
                </td>
                <td id="vendorTotal">
                    {{$values[1] * 5}}%
                </td>
            </tr>

            <tr>
                <td>3. Experience</td>
                <td>
                    <ul id="experienceBricks" class="brickList">
                        @for ($i = 0; $i < $values[2]; $i++)
                        <li data-id="{{$dataId++}}" style="cursor: default">
                            5%
                        </li>
                        @endfor
                    </ul>
                </td>
                <td id="experienceTotal">
                    {{$values[2] * 5}}%
                </td>
            </tr>

            <tr>
                <td>4. Innovation & Vision</td>
                <td>
                    <ul id="innovationBricks" class="brickList">
                        @for ($i = 0; $i < $values[3]; $i++)
                        <li data-id="{{$dataId++}}" style="cursor: default">
                            5%
                        </li>
                        @endfor
                    </ul>
                </td>
                <td id="innovationTotal">
                    {{$values[3] * 5}}%
                </td>
            </tr>

            <tr>
                <td>5. Implementation & Commercials</td>
                <td>
                    <ul id="implementationBricks" class="brickList">
                        @for ($i = 0; $i < $values[4]; $i++)
                        <li data-id="{{$dataId++}}" style="cursor: default">
                            5%
                        </li>
                        @endfor
                    </ul>
                </td>
                <td id="implementationTotal">
                    {{$values[4] * 5}}%
                </td>
            </tr>
        </tbody>
    </table>
</div>
