{{--
    Shows all the fixed general info questions and the changable ones

    Has a lot of params to reuse it in all the different situations it has to be in

    disableSpecialQuestions - boolean - Whether questions like name and client should be editable
    firstTime - boolean - Whether to set the value field for name. This is so that they don't see the placeholder name that is set on create
    --}}

@props(['project', 'clients', 'disableSpecialQuestions', 'disabled', 'required', 'firstTime', 'projectEdit', 'hideQuestionsForVendor','allOwners'])

@php
    $firstTime = $firstTime ?? false;
    $projectEdit = $projectEdit ?? false;
    $projectEdit = $projectEdit ?? false;
    $hideQuestionsForVendor = $hideQuestionsForVendor ?? false;

    $allOwners = $allOwners ?? [];
    $currentOwner = 0;
    if($project->owner()){
        $currentOwner = $project->owner()->id;
    }

@endphp

<h4>1.1. Project Info</h4>
<br>

<div class="form-group">
    <label for="projectName">Project Name*</label>
    <input type="text" class="form-control"
           id="projectName"
           data-changing="name"
           placeholder="Project Name"
           value="{{$firstTime ? '' : $project->name}}"
           {{$disableSpecialQuestions ? 'disabled' : ''}}
           {{$disabled ? 'disabled' : ''}}
           required>
</div>

@if(auth()->user()->isAccenture())
    <div class="form-group">
        <label for="ownerSelect">Choose the owner of the project*</label>
        <select id="ownerSelect"
                class="form-control"
                data-changing="owner_id"
                {{$disabled ? 'disabled' : ''}}
                required>
            <option selected="selected" value="null">Please select the Owner name</option>
            @foreach ($allOwners as $owner)
                <option value="{{$owner->id}}"
                        @if($currentOwner == $owner->id) selected @endif
                >{{$owner->name}}
                </option>
            @endforeach
        </select>
    </div>
@endif

@if(!$hideQuestionsForVendor)
    <div class="form-group">
        <label for="chooseClientSelect">Client company name*</label>
        <select
            class="form-control"
            id="chooseClientSelect"
            required
            {{$disabled ? 'disabled' : ''}}
            {{$projectEdit ? 'disabled' : ''}}
            {{$disableSpecialQuestions ? 'disabled' : ''}}
        >
            <option selected="" disabled="">Please select the Client company name</option>
            @php
                $currentlySelected = $project->client->id ?? -1;
            @endphp
            @foreach ($clients as $client)
                <option
                    value="{{$client->id}}"
                    @if($currentlySelected == $client->id) selected @endif
                >{{$client->name}}</option>
            @endforeach
        </select>
    </div>
    @if(!$projectEdit && !$disableSpecialQuestions && !$disabled)
        <p style="font-weight: 300">Please refresh the page after making changes to autofill the responses by this
            Client</p>
        <br>
    @endif
@endif

@if(!$hideQuestionsForVendor)
    <div class="form-group">
        <label for="valueTargeting">Value Targeting*</label>
        <select class="form-control" id="valueTargeting" required
            {{$disableSpecialQuestions ? 'disabled' : ''}}
            {{$disabled ? 'disabled' : ''}}
        >
            <option disabled="">Please select an option</option>
            <option value="yes" @if($project->hasValueTargeting) selected @endif>Yes</option>
            <option value="no" @if(!$project->hasValueTargeting) selected @endif>No</option>
        </select>
    </div>
@endif

<div class="form-group">
    <label for="oralsSelect">Orals*</label>
    <select class="form-control" id="oralsSelect"
            required
        {{$disableSpecialQuestions ? 'disabled' : ''}}
        {{$disabled ? 'disabled' : ''}}
    >
        <option disabled="">Please select an option</option>
        <option value="yes" @if($project->hasOrals) selected @endif>Yes</option>
        <option value="no" @if(!$project->hasOrals) selected @endif>No</option>
    </select>
</div>

<div class="form-group">
    <label for="bindingOption">Binding/Non-binding*</label>
    <select class="form-control" id="bindingOption" required
        {{$disabled ? 'disabled' : ''}}
        {{$disableSpecialQuestions ? 'disabled' : ''}}
        {{$projectEdit ? 'disabled' : ''}}
    >
        <option disabled="">Please select an option</option>
        <option value="yes" @if($project->isBinding) selected @endif>Binding</option>
        <option value="no" @if(!$project->isBinding) selected @endif>Non-binding</option>
    </select>
</div>

<div class="form-group">
    <label for="industrySelect">{{$required ? 'Industry*' : 'Industry'}}</label>
    <select class="form-control" id="industrySelect"
        {{$disabled ? 'disabled' : ''}}
        {{$required ? 'required' : ''}}
    >
        <x-options.industryExperience :selected="$project->industry ?? ''"/>
    </select>
</div>

@if(!$hideQuestionsForVendor)
    <div class="form-group">
        <label for="regionSelect">{{$required ? 'Regions*' : 'Regions'}}</label>
        <select class="js-example-basic-multiple w-100" id="regionSelect" multiple="multiple"
            {{$disabled ? 'disabled' : ''}}
            {{$required ? 'required' : ''}}
        >
            <x-options.geographies :selected="$project->regions ?? []"/>
        </select>
    </div>
@endif

<div class="form-group">
    <label for="projectType">Project Type*</label>
    <select class="form-control" id="projectType" required
        {{$disabled ? 'disabled' : ''}}
        {{$disableSpecialQuestions ? 'disabled' : ''}}
    >
        <x-options.projectType :selected="$project->projectType ?? ''"/>
    </select>
</div>

<div class="form-group">
    <label for="projectType">Currency*</label>
    <select class="form-control" id="currencySelect"
            required
        {{$disabled ? 'disabled' : ''}}
        {{$disableSpecialQuestions ? 'disabled' : ''}}
    >
        <x-options.currencies :selected="$project->currency ?? ''"/>
    </select>
</div>

<x-questionForeachWithOnlyView :questions="$project->generalInfoQuestionsInPage('project_info')"
                               :class="'generalQuestion'" :disabled="$disabled"
                               :required="$required" :skipQuestionsInVendor="$hideQuestionsForVendor"
                               :onlyView="$disableSpecialQuestions"/>

<h4>1.2. SC Capability (Practice)</h4>
<br>

<div class="form-group">
    <label for="practiceSelect">SC Capabilities (Practice)*</label>
    <select class="form-control" id="practiceSelect" required
        {{$disabled ? 'disabled' : ''}}
        {{$projectEdit ? 'disabled' : ''}}
        {{$disableSpecialQuestions ? 'disabled' : ''}}
    >
        <x-options.practices :selected="$project->practice->id ?? -1"/>
    </select>
</div>


<div class="form-group">
    <label for="subpracticeSelect">Subpractice*</label>
    <select
        class="js-example-basic-multiple w-100"
        id="subpracticeSelect"
        multiple="multiple"
        required
        {{$disabled ? 'disabled' : ''}}
    >
        @php
            $select = $project->subpractices()->pluck('subpractices.id')->toArray();
        @endphp
        <x-options.subpractices :selected="$select"/>
    </select>
</div>

<x-questionForeachWithOnlyView :questions="$project->generalInfoQuestionsInPage('practice')" :class="'generalQuestion'"
                               :disabled="$disabled" :required="$required" :onlyView="$disableSpecialQuestions"/>

<h4>1.3. Scope</h4>
<br>

<x-questionForeachWithOnlyView :questions="$project->generalInfoQuestionsInPage('scope')" :class="'generalQuestion'"
                               :disabled="$disabled" :required="$required" :onlyView="$disableSpecialQuestions"/>

<h4>1.4. Timeline</h4>
<br>

<div class="form-group">
    <label for="deadline">Tentative date for Vendor Response completion*</label>
    <div class="input-group date datepicker" data-initialValue="{{$firstTime ? '' : $project->deadline}}">
        <input required
               id="deadline"
               value="{{$firstTime ? '' : $project->deadline}}" type="text"
               {{$disabled ? 'disabled' : ''}}
               class="form-control">
        <span class="input-group-addon"><i data-feather="calendar"></i></span>
    </div>
</div>

<x-questionForeachWithOnlyView :questions="$project->generalInfoQuestionsInPage('timeline')" :class="'generalQuestion'"
                               :disabled="$disabled" :required="$required" :onlyView="$disableSpecialQuestions"/>
