@props(['project'])

@php

    $level1s = $project->fitgapLevelWeights()->get();
    $weightValues = [];
    if ($project->fitgapLevelWeights()->sum('weight') == 0) {
      foreach ($level1s as $key => $level) {
        if ($key == 0) {
          array_push($weightValues, 20);
        } else {
          array_push($weightValues, 0);
        }
      }
    } else {
      foreach ($level1s as $key => $level) {
        array_push($weightValues, $level->weight / 5);
      }
    }

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
                @foreach($level1s as $key => $el)
                  <tr>
                      <td>{{$key+1}}. {{$el->name}}*</td>
                      <td>
                          <ul id="{{$el->name}}Bricks" class="brickList">
                              @for ($i = 0; $i < $weightValues[$key]; $i++)
                              <li data-id="{{$weightDataId++}}">
                                  5%
                              </li>
                              @endfor
                          </ul>
                      </td>
                      <td id="{{$el->name}}Total">
                          {{$weightValues[$key] * 5}}%
                      </td>
                  </tr>
                @endforeach
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
