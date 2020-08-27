<?php

namespace App\Http\Controllers\Accenture;

use App\Exports\AnalyticsExport;
use App\Exports\VendorResponsesExport;
use App\GeneralInfoQuestionResponse;
use App\Http\Controllers\Controller;
use App\Mail\ProjectInvitationEmail;
use App\Practice;
use App\Project;
use App\SecurityLog;
use App\SelectionCriteriaQuestion;
use App\SelectionCriteriaQuestionResponse;
use App\Subpractice;
use App\User;
use App\VendorApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    public function createPost(Request $request)
    {
        $project = new Project();
        $project->save();

        SecurityLog::createLog('User created project with ID ' . $project->id);
        return redirect()->route('accenture.newProjectSetUp', ['project' => $project, 'firstTime' => true]);
    }

    public function newProjectSetUp(Request $request, Project $project)
    {
        $clients = User::clientUsers()->get();

        $fitgapQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'fitgap');

        $vendorCorporateQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'vendor_corporate');
        $vendorMarketQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'vendor_market');

        $experienceQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'experience');

        $innovationDigitalEnablersQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_digitalEnablers');
        $innovationAlliancesQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_alliances');
        $innovationProductQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_product');
        $innovationSustainabilityQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_sustainability');

        $implementationImplementationQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'implementation_implementation');
        $implementationRunQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'implementation_run');

        SecurityLog::createLog('User accessed project with ID ' . $project->id);

        return view('accentureViews.newProjectSetUp', [
            'firstTime' => $request->firstTime ?? false,

            'project' => $project,
            'clients' => $clients,

            'sizingQuestions' => $project->sizingQuestions,

            'fitgapQuestions' => $fitgapQuestions,
            'vendorCorporateQuestions' => $vendorCorporateQuestions,
            'vendorMarketQuestions' => $vendorMarketQuestions,
            'experienceQuestions' => $experienceQuestions,
            'innovationDigitalEnablersQuestions' => $innovationDigitalEnablersQuestions,
            'innovationAlliancesQuestions' => $innovationAlliancesQuestions,
            'innovationProductQuestions' => $innovationProductQuestions,
            'innovationSustainabilityQuestions' => $innovationSustainabilityQuestions,
            'implementationImplementationQuestions' => $implementationImplementationQuestions,
            'implementationRunQuestions' => $implementationRunQuestions,
        ]);
    }

    public function changeProjectName(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'newName' => 'required|string'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->name = $request->newName;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function changeProjectClient(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'client_id' => 'required|numeric'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->client_id = $request->client_id;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function changeProjectHasValueTargeting(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->hasValueTargeting = $request->value === 'yes';
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function changeProjectHasOrals(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->hasOrals = $request->value === 'yes';
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function changeProjectIsBinding(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->isBinding = $request->value === 'yes';
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function changePractice(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'practice_id' => 'required|numeric'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $practice = Practice::find($request->practice_id);
        if ($practice == null) {
            abort(404);
        }

        $project->practice_id = $request->practice_id;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function changeSubpractice(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'subpractices' => 'required|array'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->subpractices()->sync($request->subpractices);
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function changeIndustry(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->industry = $request->value;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function changeRegions(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|array'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->regions = $request->value;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function changeProjectType(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->projectType = $request->value;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function changeCurrency(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->currency = $request->value;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function changeDeadline(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->deadline = Carbon::createFromFormat('m/d/Y', $request->value)->toDateTimeString();
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function changeRFPOtherInfo(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->rfpOtherInfo = $request->value;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function setStep3Submitted(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->step3SubmittedAccenture = true;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function setStep4Submitted(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->step4SubmittedAccenture = true;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function publishProject(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->publish();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function markCompleted(Request $request, Project $project)
    {
        $project->markCompleted();

        return redirect()->route('accenture.home');
    }

    public function publishProjectAnalytics(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->publishedAnalytics = true;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function updateVendors(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'vendorList' => 'required|array'
        ]);

        /** @var Project $project */
        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $currentVendors = $project->vendorsApplied()->pluck('id')->toArray();

        $removedVendors = array_diff($currentVendors, $request->vendorList);
        foreach ($removedVendors as $key => $vendor_id) {
            $vendor = User::find($vendor_id);
            if ($vendor == null) continue;

            $application = VendorApplication::where([
                'project_id' => $project->id,
                'vendor_id' => $vendor->id
            ])->first();
            if ($application != null) {
                $application->delete();
            }
        }

        $addedVendors = array_diff($request->vendorList, $currentVendors);
        foreach ($addedVendors as $key => $vendor_id) {
            $vendor = User::find($vendor_id);
            if ($vendor == null || !$vendor->isVendor() || !$vendor->hasFinishedSetup) continue;

            $vendor->applyToProject($project);
        }

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function updateScoringValues(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'values' => 'required|array'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $values = [];
        foreach ($request->values as $key => $value) {
            $values[] = intval($value);
        }

        $project->scoringValues = $values;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function changeWeights(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'changing' => [
                'required',
                'string',
                Rule::in([
                    'fitgapWeightMust',
                    'fitgapWeightRequired',
                    'fitgapWeightNiceToHave',
                    'fitgapWeightFullySupports',
                    'fitgapWeightPartiallySupports',
                    'fitgapWeightPlanned',
                    'fitgapWeightNotSupported',
                    'fitgapFunctionalWeight',
                    'fitgapTechnicalWeight',
                    'fitgapServiceWeight',
                    'fitgapOthersWeight',
                    'implementationImplementationWeight',
                    'implementationRunWeight',
                ])
            ],
            'value' => 'required|numeric'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->{$request->changing} = $request->value;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }


    public function changeOralsLocation(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'location' => 'required|string'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->oralsLocation = $request->location;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function changeOralsFromDate(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->oralsFromDate = Carbon::createFromFormat('m/d/Y', $request->value)->toDateTimeString();
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function changeOralsToDate(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->oralsToDate = Carbon::createFromFormat('m/d/Y', $request->value)->toDateTimeString();
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function home(Project $project)
    {
        $invitedVendors = $project->vendorsApplied(['invitation'])->get();
        $applicatingVendors = $project->vendorsApplied(['applicating'])->get();
        $pendingEvaluationVendors = $project->vendorsApplied(['pendingEvaluation'])->get();
        $evaluatedVendors = $project->vendorsApplied(['evaluated'])->get();
        $submittedVendors = $project->vendorsApplied(['submitted'])->get();
        $disqualifiedVendors = $project->vendorsApplied(['disqualified'])->get();
        $rejectedVendors = $project->vendorsApplied(['rejected'])->get();

        SecurityLog::createLog('User accessed project with ID ' . $project->id);

        return view('accentureViews.projectHome', [
            'project' => $project,
            'invitedVendors' => $invitedVendors,
            'applicatingVendors' => $applicatingVendors,
            'pendingEvaluationVendors' => $pendingEvaluationVendors,
            'evaluatedVendors' => $evaluatedVendors,
            'submittedVendors' => $submittedVendors,
            'disqualifiedVendors' => $disqualifiedVendors,
            'rejectedVendors' => $rejectedVendors,
        ]);
    }

    public function disqualifyVendor(Request $request, Project $project, User $vendor)
    {
        $application = VendorApplication::where('vendor_id', $vendor->id)
            ->where('project_id', $project->id)
            ->first();
        if ($application == null) {
            abort(404);
        }

        $application->setDisqualified();

        return redirect()->route('accenture.projectHome', ['project' => $project]);
    }

    public function releaseResponse(Request $request, Project $project, User $vendor)
    {
        $application = VendorApplication::where('vendor_id', $vendor->id)
            ->where('project_id', $project->id)
            ->first();
        if ($application == null) {
            abort(404);
        }

        $application->setSubmitted();

        return redirect()->route('accenture.projectHome', ['project' => $project]);
    }

    public function submitEvaluation(Request $request, Project $project, User $vendor)
    {
        $application = VendorApplication::where('vendor_id', $vendor->id)
            ->where('project_id', $project->id)
            ->first();
        if ($application == null) {
            abort(404);
        }

        $application->setEvaluated();

        return redirect()->route('accenture.projectHome', ['project' => $project]);
    }

    public function view(Project $project)
    {
        $clients = User::clientUsers()->get();

        $sizingQuestions = $project->sizingQuestions->filter(function ($el) {
            return $el->shouldShow;
        });

        $fitgapQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'fitgap');

        $vendorCorporateQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'vendor_corporate');
        $vendorMarketQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'vendor_market');

        $experienceQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'experience');

        $innovationDigitalEnablersQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_digitalEnablers');
        $innovationAlliancesQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_alliances');
        $innovationProductQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_product');
        $innovationSustainabilityQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_sustainability');

        $implementationImplementationQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'implementation_implementation');
        $implementationRunQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'implementation_run');

        SecurityLog::createLog('User accessed project with ID ' . $project->id);

        return view('accentureViews.projectView', [
            'project' => $project,
            'clients' => $clients,

            'generalInfoQuestions' => $project->generalInfoQuestions,
            'sizingQuestions' => $sizingQuestions,

            'fitgapQuestions' => $fitgapQuestions,
            'vendorCorporateQuestions' => $vendorCorporateQuestions,
            'vendorMarketQuestions' => $vendorMarketQuestions,
            'experienceQuestions' => $experienceQuestions,
            'innovationDigitalEnablersQuestions' => $innovationDigitalEnablersQuestions,
            'innovationAlliancesQuestions' => $innovationAlliancesQuestions,
            'innovationProductQuestions' => $innovationProductQuestions,
            'innovationSustainabilityQuestions' => $innovationSustainabilityQuestions,
            'implementationImplementationQuestions' => $implementationImplementationQuestions,
            'implementationRunQuestions' => $implementationRunQuestions,
        ]);
    }

    public function edit(Project $project)
    {
        $clients = User::clientUsers()->get();

        $sizingQuestions = $project->sizingQuestions->filter(function ($el) {
            return $el->shouldShow;
        });

        $fitgapQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'fitgap');

        $vendorCorporateQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'vendor_corporate');
        $vendorMarketQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'vendor_market');

        $experienceQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'experience');

        $innovationDigitalEnablersQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_digitalEnablers');
        $innovationAlliancesQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_alliances');
        $innovationProductQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_product');
        $innovationSustainabilityQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_sustainability');

        $implementationImplementationQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'implementation_implementation');
        $implementationRunQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'implementation_run');

        SecurityLog::createLog('User accessed project with ID ' . $project->id);

        return view('accentureViews.projectEdit', [
            'project' => $project,
            'clients' => $clients,

            'generalInfoQuestions' => $project->generalInfoQuestions,
            'sizingQuestions' => $sizingQuestions,

            'fitgapQuestions' => $fitgapQuestions,
            'vendorCorporateQuestions' => $vendorCorporateQuestions,
            'vendorMarketQuestions' => $vendorMarketQuestions,
            'experienceQuestions' => $experienceQuestions,
            'innovationDigitalEnablersQuestions' => $innovationDigitalEnablersQuestions,
            'innovationAlliancesQuestions' => $innovationAlliancesQuestions,
            'innovationProductQuestions' => $innovationProductQuestions,
            'innovationSustainabilityQuestions' => $innovationSustainabilityQuestions,
            'implementationImplementationQuestions' => $implementationImplementationQuestions,
            'implementationRunQuestions' => $implementationRunQuestions,
        ]);
    }

    public function valueTargeting(Project $project)
    {
        if (!$project->hasValueTargeting) {
            abort(404);
        }

        SecurityLog::createLog('User accessed project with ID ' . $project->id);

        return view('accentureViews.projectValueTargeting', [
            'project' => $project
        ]);
    }

    public function orals(Project $project)
    {
        if (!$project->hasOrals) {
            abort(404);
        }

        SecurityLog::createLog('User accessed project with ID ' . $project->id);

        return view('accentureViews.projectOrals', [
            'project' => $project,
            'applications' => $project->vendorApplications,
        ]);
    }

    public function conclusions(Project $project)
    {
        SecurityLog::createLog('User accessed project with ID ' . $project->id);

        return view('accentureViews.projectConclusions', [
            'project' => $project
        ]);
    }

    public function benchmark(Project $project)
    {
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id);

        return view('accentureViews.projectBenchmark', [
            'project' => $project,
            'applications' => $project
                ->vendorApplications
                ->filter(function (VendorApplication $application) {
                    return $application->phase == 'submitted';
                })
                ->sortByDesc(function (VendorApplication $application) {
                    return $application->totalScore();
                }),
        ]);
    }

    public function benchmarkFitgap(Project $project)
    {
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id);

        return view('accentureViews.projectBenchmarkFitgap', [
            'project' => $project,
            'applications' => $project->vendorApplications
                ->filter(function (VendorApplication $application) {
                    return $application->phase == 'submitted';
                }),
        ]);
    }

    public function benchmarkVendor(Project $project)
    {
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id);

        return view('accentureViews.projectBenchmarkVendor', [
            'project' => $project,
            'applications' => $project->vendorApplications
                ->filter(function (VendorApplication $application) {
                    return $application->phase == 'submitted';
                }),
        ]);
    }

    public function benchmarkExperience(Project $project)
    {
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id);

        return view('accentureViews.projectBenchmarkExperience', [
            'project' => $project,
            'applications' => $project->vendorApplications
                ->filter(function (VendorApplication $application) {
                    return $application->phase == 'submitted';
                }),
        ]);
    }

    public function benchmarkInnovation(Project $project)
    {
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id);

        return view('accentureViews.projectBenchmarkInnovation', [
            'project' => $project,
            'applications' => $project->vendorApplications
                ->filter(function (VendorApplication $application) {
                    return $application->phase == 'submitted';
                }),
        ]);
    }

    public function benchmarkImplementation(Project $project)
    {
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id);

        return view('accentureViews.projectBenchmarkImplementation', [
            'project' => $project,
            'applications' => $project->vendorApplications
                ->filter(function (VendorApplication $application) {
                    return $application->phase == 'submitted';
                }),
        ]);
    }

    // feature 1.2: new view for graphics about vendor comparison
    public function benchmarkVendorComparison(Project $project)
    {
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id);

        return view('accentureViews.projectBenchmarkVendorComparison', [
            'project' => $project,
            'applications' => $project->vendorApplications
                ->filter(function (VendorApplication $application) {
                    return $application->phase == 'submitted';
                }),
        ]);
    }

    function arrayOfSelectionCriteriaQuestions(Project $project, User $vendor, VendorApplication $application = null)
    {
        $fitgapQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->originalQuestion->page == 'fitgap';
        });
        $vendorCorporateQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->originalQuestion->page == 'vendor_corporate';
        });
        $vendorMarketQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->originalQuestion->page == 'vendor_market';
        });
        $experienceQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->originalQuestion->page == 'experience';
        });
        $innovationDigitalEnablersQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->originalQuestion->page == 'innovation_digitalEnablers';
        });
        $innovationAlliancesQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->originalQuestion->page == 'innovation_alliances';
        });
        $innovationProductQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->originalQuestion->page == 'innovation_product';
        });
        $innovationSustainabilityQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->originalQuestion->page == 'innovation_sustainability';
        });

        $implementationImplementationQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->originalQuestion->page == 'implementation_implementation';
        });
        $implementationRunQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->originalQuestion->page == 'implementation_run';
        });

        return [
            'project' => $project,
            'vendor' => $vendor,
            'vendorApplication' => $application,

            'fitgapQuestions' => $fitgapQuestions,
            'vendorCorporateQuestions' => $vendorCorporateQuestions,
            'vendorMarketQuestions' => $vendorMarketQuestions,
            'experienceQuestions' => $experienceQuestions,
            'innovationDigitalEnablersQuestions' => $innovationDigitalEnablersQuestions,
            'innovationAlliancesQuestions' => $innovationAlliancesQuestions,
            'innovationProductQuestions' => $innovationProductQuestions,
            'innovationSustainabilityQuestions' => $innovationSustainabilityQuestions,
            'implementationImplementationQuestions' => $implementationImplementationQuestions,
            'implementationRunQuestions' => $implementationRunQuestions,
        ];
    }

    public function vendorProposalView(Project $project, User $vendor)
    {
        $application = VendorApplication::where('vendor_id', $vendor->id)
            ->where('project_id', $project->id)
            ->first();
        if ($application == null) {
            abort(404);
        }

        SecurityLog::createLog('User viewed vendor proposal for vendor with ID ' . $vendor->id . ' in project with ID ' . $project->id);

        return view('accentureViews.viewVendorProposal', $this->arrayOfSelectionCriteriaQuestions($project, $vendor, $application));
    }

    public function vendorProposalEdit(Project $project, User $vendor)
    {
        $application = VendorApplication::where('vendor_id', $vendor->id)
            ->where('project_id', $project->id)
            ->first();
        if ($application == null) {
            abort(404);
        }

        SecurityLog::createLog('User viewed vendor proposal for vendor with ID ' . $vendor->id . ' in project with ID ' . $project->id);

        return view('accentureViews.editVendorProposal', $this->arrayOfSelectionCriteriaQuestions($project, $vendor, $application));
    }

    public function vendorProposalEvaluation(Project $project, User $vendor)
    {
        $application = VendorApplication::where('vendor_id', $vendor->id)
            ->where('project_id', $project->id)
            ->first();
        if ($application == null) {
            abort(404);
        }

        SecurityLog::createLog('User viewed vendor proposal for vendor with ID ' . $vendor->id . ' in project with ID ' . $project->id);

        return view('accentureViews.viewVendorProposalEvaluation', $this->arrayOfSelectionCriteriaQuestions($project, $vendor, $application));
    }

    public function resendInvitation(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|numeric',
            'project_id' => 'required|numeric',
            'text' => 'required',
            'email' => 'required|string',
        ]);

        $vendor = User::find($request->vendor_id);
        if ($vendor == null) {
            abort(404);
        }

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $text = preg_replace('/&#10;/', '<br>', $request->text);
        $text = preg_replace('/\n/', '<br>', $text);

        Mail::to($request->email)->send(new ProjectInvitationEmail($vendor, $project, $text));
    }

    public function downloadVendorProposal(Project $project, User $vendor)
    {
        $application = VendorApplication::where('vendor_id', $vendor->id)
            ->where('project_id', $project->id)
            ->first();
        if ($application == null) {
            abort(404);
        }

        $export = new VendorResponsesExport($application);

        SecurityLog::createLog('User downloaded vendor proposal for vendor with ID ' . $vendor->id . ' in project with ID ' . $project->id);

        return Excel::download($export, 'responses.xlsx');
    }

    public function exportAnalytics(Request $request, Project $project)
    {
        $allVendors = $project
            ->vendorApplications
            ->filter(function (VendorApplication $application) {
                return $application->phase == 'submitted';
            })
            ->pluck('vendor.id')
            ->toArray();

        $export = new AnalyticsExport($project, json_decode($request->vendors) ?? $allVendors);

        SecurityLog::createLog('User exported analytics for project with ID ' . $project->id);

        return Excel::download($export, 'responses.xlsx');
    }

    /* Feature 2.8: Rollbacks ************************************************************************************** */

    // Rollback from Accenture step 3 to initial state
    public function setStep1Rollback(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->step3SubmittedAccenture = false;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    // Rollback from Client step 3 to Accenture step 3
    public function setStep2Rollback(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->step3SubmittedClient = false;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    // Rollback from Accenture step 4 to Client step 3
    public function setStep3Rollback(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->step4SubmittedAccenture = false;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    // Rollback from Client step 4 to Accenture step 4
    public function setStep4Rollback(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->step4SubmittedClient = false;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    // feature 2.8: vendor Rollback
    public function vendorApplyRollback(Request $request, Project $project, User $vendor)
    {
        $application = VendorApplication::where('vendor_id', $vendor->id)
            ->where('project_id', $project->id)
            ->first();

        $application->doRollback()->save();

        return redirect()->route('accenture.projectHome', ['project' => $project]);
    }

    /* ************************************************************************************************************* */
}
