{{--
    To select the Scoring criteria values. Has some blocks that have to be dragged to select how much weight to give to each part
    --}}

@props(['project', 'isClient'])

@php
    $values = $project->scoringValues ?? [0, 0, 0, 0, 0];

    $dataId = 0;

    $isClient = $isClient ?? false;
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
                        <li data-id="{{$dataId++}}">
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
                        <li data-id="{{$dataId++}}">
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
                        <li data-id="{{$dataId++}}">
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
                        <li data-id="{{$dataId++}}">
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
                        <li data-id="{{$dataId++}}">
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

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    // Timeout cause otherwise the steps thingy messes it up
    setTimeout(() => {
        setUp();
        updateTotals(false);
    }, 3000);

    function setUp() {
        var fitgapBricks = document.getElementById("fitgapBricks");
        var vendorBricks = document.getElementById("vendorBricks");
        var experienceBricks = document.getElementById("experienceBricks");
        var innovationBricks = document.getElementById("innovationBricks");
        var implementationBricks = document.getElementById("implementationBricks");

        sortableFitgap = new Sortable(fitgapBricks, {
            group: {
                name: "shared"
            },
            animation: 150,
            ghostClass: "sortable-ghost",
            onEnd: function() {
                updateTotals();
            }
        });

        sortableVendor = new Sortable(vendorBricks, {
            group: {
                name: "shared"
            },
            animation: 150,
            ghostClass: "sortable-ghost",
            onEnd: function() {
                updateTotals();
            }
        });

        sortableExperience = new Sortable(experienceBricks, {
            group: {
                name: "shared"
            },
            animation: 150,
            ghostClass: "sortable-ghost",
            onEnd: function() {
                updateTotals();
            }
        });

        sortableInnovation = new Sortable(innovationBricks, {
            group: {
                name: "shared"
            },
            animation: 150,
            ghostClass: "sortable-ghost",
            onEnd: function() {
                updateTotals();
            }
        });

        sortableImplementation = new Sortable(implementationBricks, {
            group: {
                name: "shared"
            },
            animation: 150,
            ghostClass: "sortable-ghost",
            onEnd: function() {
                updateTotals();
            }
        });
    }

    function updateTotals(showToast = true) {
        var simpleList = document.getElementById("simpleList");
        var fitgapBricks = document.getElementById("fitgapBricks");
        var vendorBricks = document.getElementById("vendorBricks");
        var experienceBricks = document.getElementById("experienceBricks");
        var innovationBricks = document.getElementById("innovationBricks");
        var implementationBricks = document.getElementById("implementationBricks");

        document.getElementById("fitgapTotal").innerHTML =
            fitgapBricks.childElementCount * 5 + "%";
        document.getElementById("vendorTotal").innerHTML =
            vendorBricks.childElementCount * 5 + "%";
        document.getElementById("experienceTotal").innerHTML =
            experienceBricks.childElementCount * 5 + "%";
        document.getElementById("innovationTotal").innerHTML =
            innovationBricks.childElementCount * 5 + "%";
        document.getElementById("implementationTotal").innerHTML =
            implementationBricks.childElementCount * 5 + "%";


        $.post('/{{$isClient ? "client" : "accenture"}}/newProjectSetUp/updateScoringValues', {
            project_id: '{{$project->id}}',
            values: [
                fitgapBricks.childElementCount,
                vendorBricks.childElementCount,
                experienceBricks.childElementCount,
                innovationBricks.childElementCount,
                implementationBricks.childElementCount,
            ]
        })

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

</script>
@endsection
