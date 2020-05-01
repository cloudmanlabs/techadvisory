<?php

namespace App\Http\Controllers\Accenture;

use App\GeneralInfoQuestionResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Practice;
use App\Project;
use App\SelectionCriteriaQuestion;
use App\SelectionCriteriaQuestionResponse;
use App\Subpractice;
use App\User;
use App\VendorApplication;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function createPost(Request $request)
    {
        $project = new Project();
        $project->save();

        return redirect()->route('accenture.newProjectSetUp', ['project' => $project]);
    }

    public function newProjectSetUp(Project $project)
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

        return view('accentureViews.newProjectSetUp', [
            'project' => $project,
            'clients' => $clients,

            'generalInfoQuestions' => $project->generalInfoQuestions,
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
            if($application != null){
                $application->delete();
            }
        }

        $addedVendors = array_diff($request->vendorList, $currentVendors);
        foreach ($addedVendors as $key => $vendor_id) {
            $vendor = User::find($vendor_id);
            if($vendor == null || ! $vendor->isVendor() || ! $vendor->hasFinishedSetup) continue;

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




    public function home(Project $project)
    {
        $invitedVendors = $project->vendorsApplied(['invitation'])->get();
        $applicatingVendors = $project->vendorsApplied(['applicating'])->get();
        $pendingEvaluationVendors = $project->vendorsApplied(['pendingEvaluation'])->get();
        $evaluatedVendors = $project->vendorsApplied(['evaluated'])->get();
        $submittedVendors = $project->vendorsApplied(['submitted'])->get();
        $disqualifiedVendors = $project->vendorsApplied(['disqualified'])->get();
        $rejectedVendors = $project->vendorsApplied(['rejected'])->get();

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

        return view('accentureViews.projectView', [
            'project' => $project,
            'clients' => $clients,

            'generalInfoQuestions' => $project->generalInfoQuestions,
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

    public function edit(Project $project)
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

        return view('accentureViews.projectEdit', [
            'project' => $project,
            'clients' => $clients,

            'generalInfoQuestions' => $project->generalInfoQuestions,
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

    public function valueTargeting(Project $project)
    {
        if (!$project->hasValueTargeting) {
            abort(404);
        }

        return view('accentureViews.projectValueTargeting', [
            'project' => $project
        ]);
    }

    public function orals(Project $project)
    {
        if(! $project->hasOrals){
            abort(404);
        }

        return view('accentureViews.projectOrals', [
            'project' => $project
        ]);
    }

    public function conclusions(Project $project)
    {
        return view('accentureViews.projectConclusions', [
            'project' => $project
        ]);
    }



    public function benchmark(Project $project)
    {
        return view('accentureViews.projectBenchmark', [
            'project' => $project,
            'applications' => $project->vendorApplications,
        ]);
    }

    public function benchmarkFitgap(Project $project)
    {
        return view('accentureViews.projectBenchmarkFitgap', [
            'project' => $project,
            'applications' => $project->vendorApplications,
        ]);
    }

    public function benchmarkVendor(Project $project)
    {
        return view('accentureViews.projectBenchmarkVendor', [
            'project' => $project,
            'applications' => $project->vendorApplications,
        ]);
    }

    public function benchmarkExperience(Project $project)
    {
        return view('accentureViews.projectBenchmarkExperience', [
            'project' => $project,
            'applications' => $project->vendorApplications,
        ]);
    }

    public function benchmarkInnovation(Project $project)
    {
        return view('accentureViews.projectBenchmarkInnovation', [
            'project' => $project,
            'applications' => $project->vendorApplications,
        ]);
    }

    public function benchmarkImplementation(Project $project)
    {
        return view('accentureViews.projectBenchmarkImplementation', [
            'project' => $project,
            'applications' => $project->vendorApplications,
        ]);
    }







    function arrayOfSelectionCriteriaQuestions(Project $project, User $vendor){
        $fitgapQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->original->page == 'fitgap';
        });
        $vendorCorporateQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->original->page == 'vendor_corporate';
        });
        $vendorMarketQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->original->page == 'vendor_market';
        });
        $experienceQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->original->page == 'experience';
        });
        $innovationDigitalEnablersQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->original->page == 'innovation_digitalEnablers';
        });
        $innovationAlliancesQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->original->page == 'innovation_alliances';
        });
        $innovationProductQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->original->page == 'innovation_product';
        });
        $innovationSustainabilityQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->original->page == 'innovation_sustainability';
        });

        $implementationImplementationQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->original->page == 'implementation_implementation';
        });
        $implementationRunQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->original->page == 'implementation_run';
        });

        return [
            'project' => $project,
            'vendor' => $vendor,

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

        return view('accentureViews.viewVendorProposal', $this->arrayOfSelectionCriteriaQuestions($project, $vendor));
    }

    public function vendorProposalEdit(Project $project, User $vendor)
    {
        $application = VendorApplication::where('vendor_id', $vendor->id)
            ->where('project_id', $project->id)
            ->first();
        if ($application == null) {
            abort(404);
        }


        return view('accentureViews.editVendorProposal', $this->arrayOfSelectionCriteriaQuestions($project, $vendor));
    }

    public function vendorProposalEvaluation(Project $project, User $vendor)
    {
        $application = VendorApplication::where('vendor_id', $vendor->id)
            ->where('project_id', $project->id)
            ->first();
        if ($application == null) {
            abort(404);
        }

        return view('accentureViews.viewVendorProposalEvaluation', $this->arrayOfSelectionCriteriaQuestions($project, $vendor));
    }
}
