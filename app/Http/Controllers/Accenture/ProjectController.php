<?php

namespace App\Http\Controllers\Accenture;

use App\Exports\AnalyticsExport;
use App\Exports\VendorResponsesExport;
use App\FitgapQuestion;
use App\Http\Controllers\Controller;
use App\Mail\ProjectInvitationEmail;
use App\Owner;
use App\Practice;
use App\Project;
use App\SecurityLog;
use App\SelectionCriteriaQuestion;
use App\SelectionCriteriaQuestionResponse;
use App\Subpractice;
use App\UseCase;
use App\UseCaseQuestion;
use App\UseCaseQuestionResponse;
use App\UseCaseTemplate;
use App\UseCaseTemplateQuestionResponse;
use App\User;
use App\UserCredential;
use App\VendorApplication;
use App\VendorUseCasesEvaluation;
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

        SecurityLog::createLog('User created project with ID ' . $project->id . ' and name ' . $project->name);
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

        $allOwners = Owner::get();

        SecurityLog::createLog('User accessed project with ID ' . $project->id . ' and name ' . $project->name);

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
            'allOwners' => $allOwners,
        ]);
    }

    public function useCasesSetUpRollback(Request $request, Project $project)
    {
        $project->useCasesPhase = 'setup';
        $project->save();

        SecurityLog::createLog('User with ID '. $request->user()->id .' rolled back evaluation of use cases of project ' . $project->id . ' with name: ' . $project->name);
        return redirect()->route('accenture.projectUseCasesSetUp', ['project' => $project]);
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

        return UseCase::find($useCase->id);
    }

    private function createVendorEvaluationsIfNeeded($userCredentials, $useCaseId, $selectedVendors, $userType)
    {
        foreach ($userCredentials as $userCredential) {
            foreach ($selectedVendors as $selectedVendor) {
                $vendorEvaluation = VendorUseCasesEvaluation::findByIdsAndType($useCaseId, $userCredential, $selectedVendor->id, $userType);
                if ($vendorEvaluation == null) {
                    $vendorEvaluation = new VendorUseCasesEvaluation();
                    $vendorEvaluation->use_case_id = $useCaseId;
                    $vendorEvaluation->user_credential = $userCredential;
                    $vendorEvaluation->vendor_id = $selectedVendor->id;
                    $vendorEvaluation->evaluation_type = $userType;
                    $vendorEvaluation->save();
                }
            }
        }
    }

    public function useCasesSetUp(Request $request, Project $project)
    {
        $client = $project->client;
        $clients = $client->credentials()->get();

        $projectOwner = $project->owner_id;
        $accentureUsers = User::accentureUsers()->get()->filter(function($user) use ($projectOwner) {
            return $user->owner_id == $projectOwner || $user->owner_id == 0 || $user->owner_id == null;
        });

        $appliedVendors = $project->vendorsApplied()->get();

//        $useCases = UseCases::findByProject($project->id);
        $useCases = $project->useCases()->get();

        $projectPractice = $project->practice_id;
        $useCaseTemplates = UseCaseTemplate::all()->filter(function($useCaseTemplate) use ($projectPractice) {
            return $useCaseTemplate->practice_id == $projectPractice;
        });

        $useCaseQuestions = UseCaseQuestion::all();
        $accessingAccentureUserId = $request->user()->id;
        $canEvaluateVendors = false;

        $selectedVendors = array();
        SecurityLog::createLog('User accessed project Use Cases setup with ID ' . $project->id  . ' and name ' . $project->name);

        $view = [
            'project' => $project,

            'clients' => $clients,

            'accentureUsers' => $accentureUsers,

            'appliedVendors' => $appliedVendors,

            'useCaseTemplates' => $useCaseTemplates,

            'user_id' => $accessingAccentureUserId
        ];

        if ($request->input('createUseCase') || $useCases->count() === 0) {
            $useCaseTemplateId = $request->input('useCaseTemplate');
            $useCase = $this->createBaseUseCase($project->id, $useCaseTemplateId);
            $view['currentUseCase'] = $useCase;
            $useCases = $project->useCases()->get();
        } else {
            $useCaseNumber = $request->input('useCase');
            $useCase = $useCaseNumber ? UseCase::find($useCaseNumber) : UseCase::findByProject($project->id)->first();
            $view['currentUseCase'] = $useCase;


            if ($project->useCasesPhase === 'evaluation') {
                $selectedUsers = explode(',', urldecode($useCase->accentureUsers));
                $canEvaluateVendors = (array_search($accessingAccentureUserId, $selectedUsers) !== false) && $request->user()->isAccenture();
                $view['canEvaluateVendors'] = $canEvaluateVendors;
                $invitedVendors = explode(',', urldecode($project->use_case_invited_vendors));
                $selectedVendors = $project->vendorsApplied()->whereIn('id', $invitedVendors)->get();
                $view['selectedVendors'] = $selectedVendors;
                $this->createVendorEvaluationsIfNeeded(array_map('intval', explode(',', urldecode($useCase->accentureUsers))), $useCase->id, $selectedVendors, 'accenture');
                $this->createVendorEvaluationsIfNeeded(array_map('intval', explode(',', urldecode($useCase->clientUsers))), $useCase->id, $selectedVendors, 'client');

                if ($canEvaluateVendors) {
                    $view['evaluationsSubmitted'] = VendorUseCasesEvaluation::evaluationsSubmitted($accessingAccentureUserId, $useCase->id, $selectedVendors, 'accenture');
                }

                $evaluationSubmittedClients = VendorUseCasesEvaluation::getUserCredentialsByUseCaseAndSubmittingState($useCase->id, 'client', true);
                foreach ($evaluationSubmittedClients as $key => $evaluationSubmittedClient) {
                    $evaluationSubmittedClients[$key] = UserCredential::where('id', '=', $evaluationSubmittedClient->user_credential)->first();
                }
                $evaluationNonSubmittedClients = VendorUseCasesEvaluation::getUserCredentialsByUseCaseAndSubmittingState($useCase->id, 'client', false);
                foreach ($evaluationNonSubmittedClients as $key => $evaluationNonSubmittedClient) {
                    $evaluationNonSubmittedClients[$key] = UserCredential::where('id', '=', $evaluationNonSubmittedClient->user_credential)->first();
                }
                $view['evaluationSubmittedClients'] = $evaluationSubmittedClients;
                $view['evaluationNonSubmittedClients'] = $evaluationNonSubmittedClients;

                $evaluationSubmittedUsers = VendorUseCasesEvaluation::getUserCredentialsByUseCaseAndSubmittingState($useCase->id, 'accenture', true);
                foreach ($evaluationSubmittedUsers as $key => $evaluationSubmittedUser) {
                    $evaluationSubmittedUsers[$key] = User::where('id', '=', $evaluationSubmittedUser->user_credential)->first();
                }
                $evaluationNonSubmittedUsers = VendorUseCasesEvaluation::getUserCredentialsByUseCaseAndSubmittingState($useCase->id, 'accenture', false);
                foreach ($evaluationNonSubmittedUsers as $key => $evaluationNonSubmittedUser) {
                    $evaluationNonSubmittedUsers[$key] = User::where('id', '=', $evaluationNonSubmittedUser->user_credential)->first();
                }
                $view['evaluationSubmittedUsers'] = $evaluationSubmittedUsers;
                $view['evaluationNonSubmittedUsers'] = $evaluationNonSubmittedUsers;
            }
        }

        $useCaseResponses = UseCaseQuestionResponse::getResponsesFromUseCase($useCase);
        $view['useCaseResponses'] = $useCaseResponses;
        $useCaseQuestions = $this->getQuestionsWithTypeFieldFilled($useCaseQuestions, $useCaseResponses);

        $view['useCases'] = $useCases;
        $view['useCaseQuestions'] = $useCaseQuestions;

        return view('accentureViews.useCasesSetUp', $view);
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

    public function rollbackSubmitUseCaseVendorEvaluation(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userCredential' => 'required|exists:users,id|numeric'
        ]);

        $evaluations = VendorUseCasesEvaluation::where('use_case_id', '=', $request->useCaseId)
            ->where('user_credential', '=', $request->userCredential)
            ->where('evaluation_type', '=', 'accenture')
            ->get();
        if ($evaluations == null) {
            abort(404);
        }

        foreach($evaluations as $evaluation) {
            $evaluation->submitted = 'no';
            $evaluation->save();
        }

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function submitUseCaseVendorEvaluation(Request $request)
    {
        $request->validate([
            'evaluationId' => 'required|exists:vendor_use_cases_evaluation,id|numeric'
        ]);

        $evaluation = VendorUseCasesEvaluation::find($request->evaluationId);
        if ($evaluation == null) {
            abort(404);
        }

        $evaluation->submitted = 'yes';
        $evaluation->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function upsertEvaluationSolutionFit(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userCredential' => 'required|exists:users,id|numeric',
            'vendorId' => 'required|exists:users,id|numeric',
            'value' => 'required|string'
        ]);

        $vendorEvaluation = VendorUseCasesEvaluation::findByIdsAndType($request->useCaseId, $request->userCredential, $request->vendorId, 'accenture');
        if ($vendorEvaluation == null) {
            abort(404);
        }

        $vendorEvaluation->solution_fit = $request->value != -1 ? $request->value : null;
        $vendorEvaluation->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function upsertEvaluationUsability(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userCredential' => 'required|exists:users,id|numeric',
            'vendorId' => 'required|exists:users,id|numeric',
            'value' => 'required|string'
        ]);

        $vendorEvaluation = VendorUseCasesEvaluation::findByIdsAndType($request->useCaseId, $request->userCredential, $request->vendorId, 'accenture');
        if ($vendorEvaluation == null) {
            abort(404);
        }

        $vendorEvaluation->usability = $request->value != -1 ? $request->value : null;
        $vendorEvaluation->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function upsertEvaluationPerformance(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userCredential' => 'required|exists:users,id|numeric',
            'vendorId' => 'required|exists:users,id|numeric',
            'value' => 'required|string'
        ]);

        $vendorEvaluation = VendorUseCasesEvaluation::findByIdsAndType($request->useCaseId, $request->userCredential, $request->vendorId, 'accenture');
        if ($vendorEvaluation == null) {
            abort(404);
        }

        $vendorEvaluation->performance = $request->value != -1 ? $request->value : null;
        $vendorEvaluation->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function upsertEvaluationLookFeel(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userCredential' => 'required|exists:users,id|numeric',
            'vendorId' => 'required|exists:users,id|numeric',
            'value' => 'required|string'
        ]);

        $vendorEvaluation = VendorUseCasesEvaluation::findByIdsAndType($request->useCaseId, $request->userCredential, $request->vendorId, 'accenture');
        if ($vendorEvaluation == null) {
            abort(404);
        }

        $vendorEvaluation->look_feel = $request->value != -1 ? $request->value : null;
        $vendorEvaluation->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function upsertEvaluationOthers(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userCredential' => 'required|exists:users,id|numeric',
            'vendorId' => 'required|exists:users,id|numeric',
            'value' => 'required|string'
        ]);

        $vendorEvaluation = VendorUseCasesEvaluation::findByIdsAndType($request->useCaseId, $request->userCredential, $request->vendorId, 'accenture');
        if ($vendorEvaluation == null) {
            abort(404);
        }

        $vendorEvaluation->others = $request->value != -1 ? $request->value : null;
        $vendorEvaluation->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function upsertEvaluationComments(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userCredential' => 'required|exists:users,id|numeric',
            'vendorId' => 'required|exists:users,id|numeric',
            'value' => 'nullable|string'
        ]);

        $vendorEvaluation = VendorUseCasesEvaluation::findByIdsAndType($request->useCaseId, $request->userCredential, $request->vendorId, 'accenture');
        if ($vendorEvaluation == null) {
            abort(404);
        }

        $vendorEvaluation->comments = $request->value;
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

    public function changeProjectOwner(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'owner_id' => 'required|string'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->owner_id = $request->owner_id;
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

    public function changeProjectUseCases(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->useCases = $request->value;
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

    public function markCompleted(Request $request, Project $project)
    {
        $project->markCompleted();

        return redirect()->route('accenture.home');
    }

    public function moveToOpen(Project $project)
    {
        $project->publish();

        return redirect()->route('accenture.home');
    }

    public function togglePublishProjectAnalytics(Request $request)
    {
        $request->validate(['project_id' => 'required|numeric',]);

        $project = Project::find($request->project_id);

        if ($project == null) {
            abort(404);
        }

        $project->publishedAnalytics = !$project->publishedAnalytics;
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

        SecurityLog::createLog('User accessed project with ID ' . $project->id  . ' and name ' . $project->name);

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

        $fitgapQuestions = FitgapQuestion::findByProject($project->id);
        $useCases = $project->useCases()->where('page', 'usecase');


        $vendorCorporateQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'vendor_corporate');
        $vendorMarketQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'vendor_market');

        $experienceQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'experience');

        $innovationDigitalEnablersQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_digitalEnablers');
        $innovationAlliancesQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_alliances');
        $innovationProductQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_product');
        $innovationSustainabilityQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_sustainability');

        $implementationImplementationQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'implementation_implementation');
        $implementationRunQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'implementation_run');

        $allOwners = Owner::get();

        SecurityLog::createLog('User accessed project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('accentureViews.projectView', [
            'project' => $project,
            'clients' => $clients,

            'generalInfoQuestions' => $project->generalInfoQuestions,
            'sizingQuestions' => $sizingQuestions,

            'fitgapQuestions' => $fitgapQuestions,
            'useCases' => $useCases,
            'vendorCorporateQuestions' => $vendorCorporateQuestions,
            'vendorMarketQuestions' => $vendorMarketQuestions,
            'experienceQuestions' => $experienceQuestions,
            'innovationDigitalEnablersQuestions' => $innovationDigitalEnablersQuestions,
            'innovationAlliancesQuestions' => $innovationAlliancesQuestions,
            'innovationProductQuestions' => $innovationProductQuestions,
            'innovationSustainabilityQuestions' => $innovationSustainabilityQuestions,
            'implementationImplementationQuestions' => $implementationImplementationQuestions,
            'implementationRunQuestions' => $implementationRunQuestions,

            'allOwners' => $allOwners,
        ]);
    }

    public function edit(Project $project)
    {
        $clients = User::clientUsers()->get();

        $sizingQuestions = $project->sizingQuestions->filter(function ($el) {
            return $el->shouldShow;
        });

        $fitgapQuestions = $fitgapQuestions = FitgapQuestion::findByProject($project->id);
        $useCases = $project->useCases()->where('page', 'usecase');

        $vendorCorporateQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'vendor_corporate');
        $vendorMarketQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'vendor_market');

        $experienceQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'experience');

        $innovationDigitalEnablersQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_digitalEnablers');
        $innovationAlliancesQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_alliances');
        $innovationProductQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_product');
        $innovationSustainabilityQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'innovation_sustainability');

        $implementationImplementationQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'implementation_implementation');
        $implementationRunQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'implementation_run');

        $allOwners = Owner::get();

        SecurityLog::createLog('User accessed project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('accentureViews.projectEdit', [
            'project' => $project,
            'clients' => $clients,

            'generalInfoQuestions' => $project->generalInfoQuestions,
            'sizingQuestions' => $sizingQuestions,

            'fitgapQuestions' => $fitgapQuestions,
            'useCases' => $useCases,
            'vendorCorporateQuestions' => $vendorCorporateQuestions,
            'vendorMarketQuestions' => $vendorMarketQuestions,
            'experienceQuestions' => $experienceQuestions,
            'innovationDigitalEnablersQuestions' => $innovationDigitalEnablersQuestions,
            'innovationAlliancesQuestions' => $innovationAlliancesQuestions,
            'innovationProductQuestions' => $innovationProductQuestions,
            'innovationSustainabilityQuestions' => $innovationSustainabilityQuestions,
            'implementationImplementationQuestions' => $implementationImplementationQuestions,
            'implementationRunQuestions' => $implementationRunQuestions,

            'allOwners' => $allOwners,
        ]);
    }

    public function valueTargeting(Project $project)
    {
        if (!$project->hasValueTargeting) {
            abort(404);
        }

        SecurityLog::createLog('User accessed project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('accentureViews.projectValueTargeting', [
            'project' => $project
        ]);
    }

    public function orals(Project $project)
    {
        if (!$project->hasOrals) {
            abort(404);
        }

        SecurityLog::createLog('User accessed project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('accentureViews.projectOrals', [
            'project' => $project,
            'applications' => $project->vendorApplications,
        ]);
    }

    public function conclusions(Project $project)
    {
        SecurityLog::createLog('User accessed project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('accentureViews.projectConclusions', [
            'project' => $project
        ]);
    }

    public function benchmark(Project $project)
    {
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id  . ' and name ' . $project->name);

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
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id  . ' and name ' . $project->name);

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
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id  . ' and name ' . $project->name);

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
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id  . ' and name ' . $project->name);

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
        return view('accentureViews.projectBenchmarkInnovation', [
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

    public function benchmarkImplementation(Project $project)
    {
        SecurityLog::createLog('User accessed project benchmarks of project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('accentureViews.projectBenchmarkImplementation', [
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
        return view('accentureViews.projectBenchmarkVendorComparison', [
            'project' => $project,
            'applications' => $project->vendorApplications
                ->filter(function (VendorApplication $application) {
                    return $application->phase == 'submitted';
                }),
            'vendor' => $vendor,
            'vendorName' => $vendorName,
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

    function arrayOfSelectionCriteriaResponsesQuestionsByPractice(Project $project, User $vendor, VendorApplication $application = null)
    {

        $fitgapQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'fitgap';
            });

        $practiceOfTheProject = $project->practice_id;

        $vendorCorporateQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id', '=', null);
            })->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'vendor_corporate';
            });

        $vendorMarketQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id', '=', null);
            })->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'vendor_market';
            });
        $experienceQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id', '=', null);
            })->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'experience';
            });
        $innovationDigitalEnablersQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id', '=', null);
            })->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'innovation_digitalEnablers';
            });
        $innovationAlliancesQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id', '=', null);
            })->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'innovation_alliances';
            });
        $innovationProductQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id', '=', null);
            })->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'innovation_product';
            });
        $innovationSustainabilityQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id', '=', null);
            })->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'innovation_sustainability';
            });

        $implementationImplementationQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'implementation_implementation';
            });
        $implementationRunQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->get()
            ->filter(function ($question) {
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

        SecurityLog::createLog('User viewed vendor proposal for vendor with ID ' . $vendor->id . ' in project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('accentureViews.viewVendorProposal', $this->arrayOfSelectionCriteriaResponsesQuestionsByPractice($project, $vendor, $application));
    }

    public function vendorProposalEdit(Project $project, User $vendor)
    {
        $application = VendorApplication::where('vendor_id', $vendor->id)
            ->where('project_id', $project->id)
            ->first();
        if ($application == null) {
            abort(404);
        }

        SecurityLog::createLog('User viewed vendor proposal for vendor with ID ' . $vendor->id . ' in project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('accentureViews.editVendorProposal', $this->arrayOfSelectionCriteriaResponsesQuestionsByPractice($project, $vendor, $application));
    }

    public function vendorProposalEvaluation(Project $project, User $vendor)
    {
        $application = VendorApplication::where('vendor_id', $vendor->id)
            ->where('project_id', $project->id)
            ->first();
        if ($application == null) {
            abort(404);
        }

        SecurityLog::createLog('User viewed vendor proposal for vendor with ID ' . $vendor->id . ' in project with ID ' . $project->id  . ' and name ' . $project->name);

        return view('accentureViews.viewVendorProposalEvaluation', $this->arrayOfSelectionCriteriaResponsesQuestionsByPractice($project, $vendor, $application));
    }

    public function filterQuestionsResponsesByPractice($responses)
    {
        $questionResponsesWithTheSamePracticeAsProyect = [];
        foreach ($responses as $response) {
            var_dump($response);
        }
        die();
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
