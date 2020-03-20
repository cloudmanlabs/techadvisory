<p>
    Please distribute all Percentage Bricks depending on how much weight you want to give to each section.
</p>

<div>
    <ul id="simpleList" class="brickList">
        @for ($i = 0; $i < 15; $i++)
        <li data-id="{{$i}}">
            5%
        </li>
        @endfor
    </ul>
</div>

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
                        <li data-id="15">
                            5%
                        </li>
                    </ul>
                </td>
                <td id="fitgapTotal">
                    5%
                </td>
            </tr>

            <tr>
                <td>2. Vendor</td>
                <td>
                    <ul id="vendorBricks" class="brickList">
                        <li data-id="16">
                            5%
                        </li>
                    </ul>
                </td>
                <td id="vendorTotal">
                    5%
                </td>
            </tr>

            <tr>
                <td>3. Experience</td>
                <td>
                    <ul id="experienceBricks" class="brickList">
                        <li data-id="17">
                            5%
                        </li>
                    </ul>
                </td>
                <td id="experienceTotal">
                    5%
                </td>
            </tr>

            <tr>
                <td>4. Innovation & Vision</td>
                <td>
                    <ul id="innovationBricks" class="brickList">
                        <li data-id="18">
                            5%
                        </li>
                    </ul>
                </td>
                <td id="innovationTotal">
                    5%
                </td>
            </tr>

            <tr>
                <td>5. Implementation & Commercials</td>
                <td>
                    <ul id="implementationBricks" class="brickList">
                        <li data-id="19">
                            5%
                        </li>
                    </ul>
                </td>
                <td id="implementationTotal">
                    5%
                </td>
            </tr>
        </tbody>
    </table>
</div>
