@props(['project', 'clients', 'disableSpecialQuestions', 'disabled', 'required'])

<h4>1.1. Project Info</h4>
<br>

<div class="form-group">
    <label for="projectName">Project Name*</label>
    <input type="text" class="form-control"
        id="projectName"
        data-changing="name"
        placeholder="Project Name"
        value="{{$project->name}}"
        {{$disableSpecialQuestions ? 'disabled' : ''}}
        {{$disabled ? 'disabled' : ''}}
        required>
</div>

@if(!$disableSpecialQuestions && !$disabled)
<div class="form-group">
    <label for="chooseClientSelect">Client name*</label>
    <select
        class="form-control"
        id="chooseClientSelect"
        required
    >
        <option selected="" disabled="">Please select the Client Name</option>
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
@endif

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
    >
        <option disabled="">Please select an option</option>
        <option value="yes" @if($project->isBinding) selected @endif>Binding</option>
        <option value="no" @if(!$project->isBinding) selected @endif>Non-binding</option>
    </select>
</div>

<div class="form-group">
    <label for="industrySelect">Industry*</label>
    <select class="form-control" id="industrySelect" required
        {{$disabled ? 'disabled' : ''}}
    >
        <x-options.industryExperience :selected="$project->industry ?? ''" />
    </select>
</div>

<div class="form-group">
    <label for="regionSelect">Regions*</label>
    <select class="js-example-basic-multiple w-100" id="regionSelect" multiple="multiple" required
        {{$disabled ? 'disabled' : ''}}
    >
        <x-options.geographies :selected="$project->regions ?? []" />
    </select>
</div>

<div class="form-group">
    <label for="projectType">Project Type*</label>
    <select class="form-control" id="projectType" required
        {{$disabled ? 'disabled' : ''}}
    >
        <x-options.projectType :selected="$project->projectType ?? ''" />
    </select>
</div>

<x-questionForeach :questions="$project->generalInfoQuestionsInPage('project_info')" :class="'generalQuestion'" :disabled="$disabled"
    :required="$required" />

<h4>1.2. Practice</h4>
<br>

<div class="form-group">
    <label for="practiceSelect">Practice*</label>
    <select class="form-control" id="practiceSelect" required
        {{$disabled ? 'disabled' : ''}}
    >
        <x-options.practices :selected="$project->practice->id ?? -1" />
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
        <x-options.subpractices :selected="$select" />
    </select>
</div>

<x-questionForeach :questions="$project->generalInfoQuestionsInPage('practice')" :class="'generalQuestion'"
    :disabled="$disabled" :required="$required" />

<h4>1.3. Scope</h4>
<br>

<x-questionForeach :questions="$project->generalInfoQuestionsInPage('scope')" :class="'generalQuestion'"
    :disabled="$disabled" :required="$required" />

<h4>1.4. Timeline</h4>
<br>

<div class="form-group">
    <label for="deadline">Tentative date for Value Enablers completion*</label>
    <div class="input-group date datepicker" data-initialValue="{{$project->deadline}}">
        <input required
            id="deadline"
            value="{{$project->deadline}}" type="text"
            {{$disabled ? 'disabled' : ''}}
            class="form-control">
        <span class="input-group-addon"><i data-feather="calendar"></i></span>
    </div>
</div>

<x-questionForeach :questions="$project->generalInfoQuestionsInPage('timeline')" :class="'generalQuestion'"
    :disabled="$disabled" :required="$required" />
