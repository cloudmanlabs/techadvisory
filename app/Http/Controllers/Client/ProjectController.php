<?php

namespace App\Http\Controllers\Client;

use App\Exports\AnalyticsExport;
use App\Exports\VendorResponsesExport;
use App\Project;
use App\UseCaseQuestion;
use App\UseCaseQuestionResponse;
use App\UseCaseTemplate;
use App\UseCaseTemplateQuestionResponse;
use App\VendorUseCasesEvaluation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Practice;
use App\SecurityLog;
use App\User;
use App\UseCase;
use App\VendorApplication;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    public function home(Project $project)
    {
        $startedVendors = $project->vendorsApplied(['applicating', 'pendingEvaluation', 'evaluated'])->get();
        $submittedVendors = $project->vendorsApplied(['submitted'])->get();
        $disqualifiedVendors = $project->vendorsApplied(['disqualified'])->get();

        SecurityLog::createLog('User accessed project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('clientViews.projectHome', [
            'project' => $project,

            'startedVendors' => $startedVendors,
            'submittedVendors' => $submittedVendors,
            'disqualifiedVendors' => $disqualifiedVendors,
        ]);
    }

    // public function edit(Project $project)
    // {
    //     return view('clientViews.projectEdit', [
    //         'project' => $project
    //     ]);
    // }


    public function newProjectSetUp(Project $project)
    {
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

        SecurityLog::createLog('User accessed project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('clientViews.newProjectSetUp', [
            'project' => $project,
            'clients' => User::clientUsers()->get()->filter(function ($user) use ($project) {
                // We only return the selected one, this way we don't let the client see all the client names in the html
                return $user->is($project->client);
            }),

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

    private function getQuestionsWithTypeFieldFilled($questions, $responses)
    {
        foreach($questions as $questionKey => $questionValue) {
            if ($questionValue->type === 'file') {
                foreach ($responses as $responseKey => $responseValue) {
                    if ($responseValue->use_case_questions_id === $questionValue->id) {
                        $questions[$questionKey]['response'] = $responseValue->response;
                    }
                }
            }
        }

        return $questions;
    }

    private function createBaseUseCase($projectId, $useCaseTemplateId)
    {
        $useCase = new UseCase();
        if (!$useCaseTemplateId) {
            $useCase->project_id = $projectId;
            $useCase->save();
        } else {
            $useCaseTemplate = UseCaseTemplate::find($useCaseTemplateId);
            $useCase->name = $useCaseTemplate->name;
            $useCase->description = $useCaseTemplate->description;
            $useCase->project_id = $projectId;
            $useCase->save();

            $useCaseTemplateResponses = UseCaseTemplateQuestionResponse::getResponsesFromUseCaseTemplate($useCaseTemplate);
            foreach ($useCaseTemplateResponses as $useCaseTemplateResponse) {
                $answer = new UseCaseQuestionResponse();
                $answer->use_case_questions_id = $useCaseTemplateResponse->use_case_questions_id;
                $answer->use_case_id = $useCase->id;
                $answer->response = $useCaseTemplateResponse->response;
                $answer->save();
            }
        }

        return UseCase::find($useCase->id) ;
    }

    public function useCasesSetUp(Request $request, Project $project)
    {
        $client = $project->client;
        $clients = $client->credentials()->get();

        $projectOwner = $project->owner_id;
        $accentureUsers = User::accentureUsers()->get()->filter(function($vendor) use ($projectOwner) {
            return $vendor->owner_id == $projectOwner || $vendor->owner_id == 0 || $vendor->owner_id == null;
        });

        $appliedVendors = $project->vendorsApplied()->get();

//        $useCases = UseCases::findByProject($project->id);
        $useCases = $project->useCases()->get();

        $projectPractice = $project->practice_id;
        $useCaseTemplates = UseCaseTemplate::all()->filter(function($useCaseTemplate) use ($projectPractice) {
            return $useCaseTemplate->practice_id == $projectPractice;
        });

        $useCaseQuestions = UseCaseQuestion::all();
        $accessingClientCredentialsId = session('credential_id');
        $canEvaluateVendors = false;

        $selectedVendors = array();
        SecurityLog::createLog('User accessed project Use Cases setup with ID ' . $project->id  . ' and name ' . $project->name);

        $view = [
            'project' => $project,

            'clients' => $clients,

            'accentureUsers' => $accentureUsers,

            'appliedVendors' => $appliedVendors,

            'useCaseTemplates' => $useCaseTemplates,

            'client_id' => $accessingClientCredentialsId
        ];

        if ($request->input('createUseCase')) {
            $useCaseTemplateId = $request->input('useCaseTemplate');
            $useCase = $this->createBaseUseCase($project->id, $useCaseTemplateId);
            $view['currentUseCase'] = $useCase;
            $useCaseResponses = UseCaseQuestionResponse::getResponsesFromUseCase($useCase);
            $view['useCaseResponses'] = $useCaseResponses;
            $useCaseQuestions = $this->getQuestionsWithTypeFieldFilled($useCaseQuestions, $useCaseResponses);
            $useCases = $project->useCases()->get();
        } else {
            $useCaseNumber = $request->input('useCase');
            error_log($useCaseNumber);
            $useCase = $useCaseNumber ? UseCase::find($useCaseNumber) : UseCase::findByProject($project->id)->first();
            if($useCase) {
                if($useCaseNumber) {
                    $view['currentUseCase'] = $useCase;
                    $useCaseResponses = UseCaseQuestionResponse::getResponsesFromUseCase($useCase);
                    error_log(json_encode($useCaseResponses));
                    $view['useCaseResponses'] = $useCaseResponses;
                    $useCaseQuestions = $this->getQuestionsWithTypeFieldFilled($useCaseQuestions, $useCaseResponses);
                    error_log(json_encode($useCaseQuestions));
                } else {
                    $view['currentUseCase'] = $useCase;
                    $useCaseResponses = UseCaseQuestionResponse::getResponsesFromUseCase($useCase);
                    $view['useCaseResponses'] = $useCaseResponses;
                    $useCaseQuestions = $this->getQuestionsWithTypeFieldFilled($useCaseQuestions, $useCaseResponses);
                }

                if ($project->useCasesPhase === 'evaluation') {
                    $selectedClients = explode(',', urldecode($useCase->clientUsers));
                    $canEvaluateVendors = (array_search($accessingClientCredentialsId, $selectedClients) !== false) && $request->user()->isClient();
                    $invitedVendors = explode(',', urldecode($project->use_case_invited_vendors));
                    $selectedVendors = $project->vendorsApplied()->whereIn('id', $invitedVendors)->get();
                    $view['canEvaluateVendors'] = $canEvaluateVendors;
                    $view['selectedVendors'] = $selectedVendors;
                }
            }
        }

        $view['useCases'] = $useCases;
        $view['useCaseQuestions'] = $useCaseQuestions;

        return view('clientViews.useCasesSetUp', $view);
    }

    public function saveProjectScoringCriteria(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id|numeric',
            'rfp' => 'required|numeric',
            'solutionFit' => 'required|numeric',
            'usability' => 'required|numeric',
            'performance' => 'required|numeric',
            'lookFeel' => 'required|numeric',
            'others' => 'required|numeric'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->use_case_rfp = $request->rfp;
        $project->use_case_solution_fit = $request->solutionFit;
        $project->use_case_usability = $request->usability;
        $project->use_case_performance = $request->performance;
        $project->use_case_look_feel = $request->lookFeel;
        $project->use_case_others = $request->others;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function saveUseCaseScoringCriteria(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'scoringCriteria' => 'required|numeric'
        ]);

        $useCase = UseCase::find($request->useCaseId);
        if ($useCase == null) {
            abort(404);
        }

        $useCase->scoring_criteria = (float) $request->scoringCriteria;
        $useCase->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function saveVendorEvaluation(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userCredential' => 'required|numeric',
            'vendorId' => 'required|exists:users,id|numeric',
            'solutionFit' => 'numeric',
            'usability' => 'numeric',
            'performance' => 'numeric',
            'lookFeel' => 'numeric',
            'others' => 'numeric',
            'comments' => 'nullable|string'
        ]);

        $vendorEvaluation = VendorUseCasesEvaluation::findByIdsAndType($request->useCaseId, $request->userCredential, $request->vendorId, 'client');
        if ($vendorEvaluation == null) {
            $vendorEvaluation = new VendorUseCasesEvaluation();
            $vendorEvaluation->use_case_id = $request->useCaseId;
            $vendorEvaluation->user_credential = $request->userCredential;
            $vendorEvaluation->vendor_id = $request->vendorId;
        }


        $vendorEvaluation->solution_fit = $request->solutionFit != -1 ? $request->solutionFit : null;
        $vendorEvaluation->usability = $request->usability != -1 ? $request->usability : null;
        $vendorEvaluation->performance = $request->performance != -1 ? $request->performance : null;
        $vendorEvaluation->look_feel = $request->lookFeel != -1 ? $request->lookFeel : null;
        $vendorEvaluation->others = $request->others != -1 ? $request->others : null;
        $vendorEvaluation->comments = $request->comments;
        $vendorEvaluation->evaluation_type = 'client';
        $vendorEvaluation->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function upsertUseCaseAccentureUsers(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userList.*' => 'required|exists:users,id|numeric'
        ]);

        $useCase = UseCase::find($request->useCaseId);
        if ($useCase == null) {
            abort(404);
        }

        $useCase->accentureUsers = $request->userList;
        $useCase->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function upsertUseCaseClientUsers(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'clientList.*' => 'required|exists:users,id|numeric'
        ]);

        $useCase = UseCase::find($request->useCaseId);
        if ($useCase == null) {
            abort(404);
        }

        $useCase->clientUsers = $request->clientList;
        $useCase->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function upsertUseCaseName(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'newName' => 'required|string'
        ]);

        $useCase = UseCase::find($request->useCaseId);
        if ($useCase == null) {
            abort(404);
        }

        $useCase->name = $request->newName;
        $useCase->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function upsertUseCaseDescription(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'newDescription' => 'required|string'
        ]);

        $useCase = UseCase::find($request->useCaseId);
        if ($useCase == null) {
            abort(404);
        }

        $useCase->description = $request->newDescription;
        $useCase->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function updateInvitedVendors(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'vendorList.*' => 'required|exists:users,id|numeric'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->use_case_invited_vendors = $request->vendorList;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
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

        $project->step3SubmittedClient = true;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function setStep3Rollback(Request $request)
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
            'message' => 'rollback client completed'
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

        $project->step4SubmittedClient = true;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

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

    public function publishUseCases(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->setInEvaluationPhase();

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

        SecurityLog::createLog('User accessed project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('clientViews.projectView', [
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

        SecurityLog::createLog('User accessed project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('clientViews.projectValueTargeting', [
            'project' => $project
        ]);
    }

    public function orals(Project $project)
    {
        if (!$project->hasOrals) {
            abort(404);
        }

        SecurityLog::createLog('User accessed project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('clientViews.projectOrals', [
            'project' => $project,
            'applications' => $project->vendorApplications
        ]);
    }

    public function conclusions(Project $project)
    {
        SecurityLog::createLog('User accessed project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('clientViews.projectConclusions', [
            'project' => $project
        ]);
    }

    public function benchmark(Project $project)
    {
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('clientViews.projectBenchmark', [
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
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('clientViews.projectBenchmarkFitgap', [
            'project' => $project,
            'applications' => $project->vendorApplications
                ->filter(function (VendorApplication $application) {
                    return $application->phase == 'submitted';
                }),
        ]);
    }

    public function benchmarkVendor(Project $project)
    {
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('clientViews.projectBenchmarkVendor', [
            'project' => $project,
            'applications' => $project->vendorApplications
                ->filter(function (VendorApplication $application) {
                    return $application->phase == 'submitted';
                }),
        ]);
    }

    public function benchmarkExperience(Project $project)
    {
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('clientViews.projectBenchmarkExperience', [
            'project' => $project,
            'applications' => $project->vendorApplications
                ->filter(function (VendorApplication $application) {
                    return $application->phase == 'submitted';
                }),
        ]);
    }

    public function benchmarkInnovation(Project $project)
    {
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('clientViews.projectBenchmarkInnovation', [
            'project' => $project,
            'applications' => $project->vendorApplications
                ->filter(function (VendorApplication $application) {
                    return $application->phase == 'submitted';
                }),
        ]);
    }

    public function benchmarkImplementation(Project $project)
    {
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('clientViews.projectBenchmarkImplementation', [
            'project' => $project,
            'applications' => $project->vendorApplications
                ->filter(function (VendorApplication $application) {
                    return $application->phase == 'submitted';
                }),
        ]);
    }

    public function benchmarkVendorComparison(Request $request, Project $project)
    {
        $vendor = $request->input('vendor');
        $vendorName = 'Selected vendor';
        if (!empty($vendor)) {
            $vendorName = User::find($vendor)->name;
        }
        return view('clientViews.projectBenchmarkVendorComparison', [
            'project' => $project,
            'applications' => $project->vendorApplications
                ->filter(function (VendorApplication $application) {
                    return $application->phase == 'submitted';
                }),
            'vendor' => $vendor,
            'vendorName' => $vendorName,
        ]);
    }

    public function vendorProposalView(Project $project, User $vendor)
    {
        $application = VendorApplication::where('vendor_id', $vendor->id)
            ->where('project_id', $project->id)
            ->first();
        if ($application == null) {
            abort(404);
        }


        $fitgapQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->originalQuestion->page == 'fitgap';
        });

        $practiceOfTheProject = $project->practice_id;

        $vendorCorporateQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id','=',null);
            })->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'vendor_corporate';
            });

        $vendorMarketQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id','=',null);
            })->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'vendor_market';
            });

        $experienceQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id','=',null);
            })->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'experience';
            });

        $innovationDigitalEnablersQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id','=',null);
            })->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'innovation_digitalEnablers';
            });

        $innovationAlliancesQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id','=',null);
            })->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'innovation_alliances';
            });

        $innovationProductQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id','=',null);
            })->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'innovation_product';
            });

        $innovationSustainabilityQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id','=',null);
            })->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'innovation_sustainability';
            });

        $implementationImplementationQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->originalQuestion->page == 'implementation_implementation';
        });
        $implementationRunQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function ($question) {
            return $question->originalQuestion->page == 'implementation_run';
        });

        SecurityLog::createLog('User viewed vendor proposal for vendor with ID ' . $vendor->id . ' in project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('clientViews.viewVendorProposal', [
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
        ]);
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

        SecurityLog::createLog('User downloaded vendor proposal for vendor with ID ' . $vendor->id . ' in project with ID ' . $project->id  . ' and name ' . $project->name);

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

        SecurityLog::createLog('User exported analytics for project with ID ' . $project->id  . ' and name ' . $project->name);

        return Excel::download($export, 'responses.xlsx');
    }
}
