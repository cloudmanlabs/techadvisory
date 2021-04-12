<?php

namespace App\Http\Controllers\Client;

use App\Exports\AnalyticsExport;
use App\Exports\VendorResponsesExport;
use App\Http\Controllers\Controller;
use App\Practice;
use App\Project;
use App\SecurityLog;
use App\UseCase;
use App\UseCaseQuestion;
use App\UseCaseQuestionResponse;
use App\UseCaseTemplate;
use App\UseCaseTemplateQuestionResponse;
use App\User;
use App\VendorApplication;
use App\VendorUseCasesEvaluation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    public function home(Project $project)
    {
        $startedVendors = $project->vendorsApplied(['applicating', 'pendingEvaluation', 'evaluated'])->get();
        $submittedVendors = $project->vendorsApplied(['submitted'])->get();
        $disqualifiedVendors = $project->vendorsApplied(['disqualified'])->get();

        SecurityLog::createLog('Client accessed project', 'Projects',
            ['projectId' => $project->id, 'projectName' => $project->name]);

        return view('clientViews.projectHome', [
            'project' => $project,

            'startedVendors' => $startedVendors,
            'submittedVendors' => $submittedVendors,
            'disqualifiedVendors' => $disqualifiedVendors,
        ]);
    }

    public function newProjectSetUp(Project $project)
    {
        $sizingQuestions = $project->sizingQuestions->filter(function ($el) {
            return $el->shouldShow;
        });

        $fitgapQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'fitgap');

        $vendorCorporateQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'vendor_corporate');
        $vendorMarketQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'vendor_market');

        $experienceQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page', 'experience');

        $innovationDigitalEnablersQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page',
            'innovation_digitalEnablers');
        $innovationAlliancesQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page',
            'innovation_alliances');
        $innovationProductQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page',
            'innovation_product');
        $innovationSustainabilityQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page',
            'innovation_sustainability');

        $implementationImplementationQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page',
            'implementation_implementation');
        $implementationRunQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page',
            'implementation_run');

        SecurityLog::createLog('Client accessed new project setup', 'Projects',
            ['projectId' => $project->id, 'projectName' => $project->name]);

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
        foreach ($questions as $questionKey => $questionValue) {
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
            $useCase->use_case_template_id = $useCaseTemplateId;
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

    private function createVendorEvaluationsIfNeeded($accessingClientCredentialsId, $useCaseId, $selectedVendors)
    {
        foreach ($selectedVendors as $selectedVendor) {
            $vendorEvaluation = VendorUseCasesEvaluation::findByIdsAndType($useCaseId, $accessingClientCredentialsId,
                $selectedVendor->id, 'client');
            if ($vendorEvaluation == null) {
                $vendorEvaluation = new VendorUseCasesEvaluation();
                $vendorEvaluation->use_case_id = $useCaseId;
                $vendorEvaluation->user_credential = $accessingClientCredentialsId;
                $vendorEvaluation->vendor_id = $selectedVendor->id;
                $vendorEvaluation->evaluation_type = 'client';
                $vendorEvaluation->save();
            }
        }
    }

    public function useCasesSetUp(Request $request, Project $project)
    {
        $client = $project->client;
        $clients = $client->credentials()->get();

        $projectOwner = $project->owner_id;
        $accentureUsers = User::accentureUsers()->get()->filter(function ($user) use ($projectOwner) {
            return $user->owner_id == $projectOwner || $user->owner_id == 0 || $user->owner_id == null;
        });

        $appliedVendors = $project->vendorsApplied()->get();

//        $useCases = UseCases::findByProject($project->id);
        $useCases = $project->useCases()->get();

        $projectPractice = $project->practice_id;
        $projectSubpractices = $project->subpractices->pluck('id')->toArray();
        $useCaseTemplates = UseCaseTemplate::all()->filter(function ($useCaseTemplate) use (
            $projectPractice,
            $projectSubpractices
        ) {
            return $useCaseTemplate->practice_id == $projectPractice && in_array($useCaseTemplate->subpractice_id,
                    $projectSubpractices);
        });

        $useCaseQuestions = UseCaseQuestion::all();
        $accessingClientCredentialsId = session('credential_id');
        $canEvaluateVendors = false;

        $selectedVendors = array();
        SecurityLog::createLog('Client accessed project use cases setup', 'Use cases', ['projectId' => $project->id]);

        $view = [
            'project' => $project,

            'clients' => $clients,

            'accentureUsers' => $accentureUsers,

            'appliedVendors' => $appliedVendors,

            'useCaseTemplates' => $useCaseTemplates,

            'client_id' => $accessingClientCredentialsId,
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
                $selectedClients = explode(',', urldecode($useCase->clientUsers));
                $canEvaluateVendors = (array_search($accessingClientCredentialsId,
                            $selectedClients) !== false) && $request->user()->isClient();
                $invitedVendors = explode(',', urldecode($project->use_case_invited_vendors));
                $selectedVendors = $project->vendorsApplied()->whereIn('id', $invitedVendors)->get();
                $view['canEvaluateVendors'] = $canEvaluateVendors;
                $view['selectedVendors'] = $selectedVendors;
                if ($canEvaluateVendors) {
                    $this->createVendorEvaluationsIfNeeded($accessingClientCredentialsId, $useCase->id,
                        $selectedVendors);
                    $view['evaluationsSubmitted'] = VendorUseCasesEvaluation::evaluationsSubmitted($accessingClientCredentialsId,
                        $useCase->id, $selectedVendors, 'client');
                }
            }
        }

        if ($useCase->use_case_template_id) {
            $useCaseTemplate = UseCaseTemplate::find($useCase->use_case_template_id);
            $useCaseTemplateQuestionsResponses = $useCaseTemplate->useCaseQuestions()->get();
            $useCaseQuestions = [];
            foreach ($useCaseTemplateQuestionsResponses as $useCaseTemplateQuestionsResponse) {
                $useCaseQuestions[] = UseCaseQuestion::find($useCaseTemplateQuestionsResponse->use_case_questions_id);
            }
        }

        $useCaseResponses = UseCaseQuestionResponse::getResponsesFromUseCase($useCase);
        $view['useCaseResponses'] = $useCaseResponses;
        $useCaseQuestions = $this->getQuestionsWithTypeFieldFilled($useCaseQuestions, $useCaseResponses);

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
            'others' => 'required|numeric',
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

        SecurityLog::createLog('Client saved scoring criteria', 'Projects',
            [
                'projectId' => $request->project_id,
                'rfp' => $request->rfp,
                'solutionFit' => $request->solutionFit,
                'usability' => $request->usability,
                'performance' => $request->performance,
                'lookFeel' => $request->lookFeel,
                'others' => $request->others,
            ]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function saveUseCaseScoringCriteria(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'scoringCriteria' => 'required|numeric',
        ]);

        $useCase = UseCase::find($request->useCaseId);
        if ($useCase == null) {
            abort(404);
        }

        $useCase->scoring_criteria = (float) $request->scoringCriteria;
        $useCase->save();

        SecurityLog::createLog('Client saved use case scoring criteria', 'Use cases',
            ['useCaseId' => $request->useCaseId, 'scoringCriteria' => $request->scoringCriteria]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function rollbackSubmitUseCaseVendorEvaluation(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userCredential' => 'required|exists:user_credentials,id|numeric',
        ]);

        $evaluations = VendorUseCasesEvaluation::where('use_case_id', '=', $request->useCaseId)
            ->where('user_credential', '=', $request->userCredential)
            ->where('evaluation_type', '=', 'client')
            ->get();
        if ($evaluations == null) {
            abort(404);
        }

        foreach ($evaluations as $evaluation) {
            $evaluation->submitted = 'no';
            $evaluation->save();
        }

        SecurityLog::createLog('Client rollback submitted use case vendor evaluation', 'Use cases',
            ['useCaseId' => $request->useCaseId]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function submitUseCaseVendorEvaluation(Request $request)
    {
        $request->validate([
            'evaluationId' => 'required|exists:vendor_use_cases_evaluation,id|numeric',
        ]);

        $evaluation = VendorUseCasesEvaluation::find($request->evaluationId);
        if ($evaluation == null) {
            abort(404);
        }

        $evaluation->submitted = 'yes';
        $evaluation->save();

        SecurityLog::createLog('Client submitted use case vendor evaluation', 'Use cases',
            ['useCaseId' => $request->useCaseId]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function upsertEvaluationSolutionFit(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userCredential' => 'required|exists:user_credentials,id|numeric',
            'vendorId' => 'required|exists:users,id|numeric',
            'value' => 'required|string',
        ]);

        $vendorEvaluation = VendorUseCasesEvaluation::findByIdsAndType($request->useCaseId, $request->userCredential,
            $request->vendorId, 'client');
        if ($vendorEvaluation == null) {
            abort(404);
        }

        $vendorEvaluation->solution_fit = $request->value != -1 ? $request->value : null;
        $vendorEvaluation->save();

        SecurityLog::createLog('Client saved evaluation solution fit', 'Projects',
            [
                'useCaseId' => $request->useCaseId,
                'userCredential' => $request->userCredential,
                'vendorId' => $request->vendorId,
                'value' => $request->value,
            ]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function upsertEvaluationUsability(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userCredential' => 'required|exists:user_credentials,id|numeric',
            'vendorId' => 'required|exists:users,id|numeric',
            'value' => 'required|string',
        ]);

        $vendorEvaluation = VendorUseCasesEvaluation::findByIdsAndType($request->useCaseId, $request->userCredential,
            $request->vendorId, 'client');
        if ($vendorEvaluation == null) {
            abort(404);
        }

        $vendorEvaluation->usability = $request->value != -1 ? $request->value : null;
        $vendorEvaluation->save();

        SecurityLog::createLog('Client saved evaluation usability', 'Projects',
            [
                'useCaseId' => $request->useCaseId,
                'userCredential' => $request->userCredential,
                'vendorId' => $request->vendorId,
                'value' => $request->value,
            ]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function upsertEvaluationPerformance(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userCredential' => 'required|exists:user_credentials,id|numeric',
            'vendorId' => 'required|exists:users,id|numeric',
            'value' => 'required|string',
        ]);

        $vendorEvaluation = VendorUseCasesEvaluation::findByIdsAndType($request->useCaseId, $request->userCredential,
            $request->vendorId, 'client');
        if ($vendorEvaluation == null) {
            abort(404);
        }

        $vendorEvaluation->performance = $request->value != -1 ? $request->value : null;
        $vendorEvaluation->save();

        SecurityLog::createLog('Client saved evaluation performance', 'Projects',
            [
                'useCaseId' => $request->useCaseId,
                'userCredential' => $request->userCredential,
                'vendorId' => $request->vendorId,
                'value' => $request->value,
            ]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function upsertEvaluationLookFeel(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userCredential' => 'required|exists:user_credentials,id|numeric',
            'vendorId' => 'required|exists:users,id|numeric',
            'value' => 'required|string',
        ]);

        $vendorEvaluation = VendorUseCasesEvaluation::findByIdsAndType($request->useCaseId, $request->userCredential,
            $request->vendorId, 'client');
        if ($vendorEvaluation == null) {
            abort(404);
        }

        $vendorEvaluation->look_feel = $request->value != -1 ? $request->value : null;
        $vendorEvaluation->save();

        SecurityLog::createLog('Client saved evaluation look and feel', 'Projects',
            [
                'useCaseId' => $request->useCaseId,
                'userCredential' => $request->userCredential,
                'vendorId' => $request->vendorId,
                'value' => $request->value,
            ]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function upsertEvaluationOthers(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userCredential' => 'required|exists:user_credentials,id|numeric',
            'vendorId' => 'required|exists:users,id|numeric',
            'value' => 'required|string',
        ]);

        $vendorEvaluation = VendorUseCasesEvaluation::findByIdsAndType($request->useCaseId, $request->userCredential,
            $request->vendorId, 'client');
        if ($vendorEvaluation == null) {
            abort(404);
        }

        $vendorEvaluation->others = $request->value != -1 ? $request->value : null;
        $vendorEvaluation->save();

        SecurityLog::createLog('Client saved evaluation others', 'Projects',
            [
                'useCaseId' => $request->useCaseId,
                'userCredential' => $request->userCredential,
                'vendorId' => $request->vendorId,
                'value' => $request->value,
            ]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function upsertEvaluationComments(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userCredential' => 'required|exists:user_credentials,id|numeric',
            'vendorId' => 'required|exists:users,id|numeric',
            'value' => 'nullable|string',
        ]);

        $vendorEvaluation = VendorUseCasesEvaluation::findByIdsAndType($request->useCaseId, $request->userCredential,
            $request->vendorId, 'client');
        if ($vendorEvaluation == null) {
            abort(404);
        }

        $vendorEvaluation->comments = $request->value;
        $vendorEvaluation->save();

        SecurityLog::createLog('Client saved evaluation comments', 'Projects',
            [
                'useCaseId' => $request->useCaseId,
                'userCredential' => $request->userCredential,
                'vendorId' => $request->vendorId,
                'value' => $request->value,
            ]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function upsertUseCaseAccentureUsers(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'userList.*' => 'required|exists:users,id|numeric',
        ]);

        $useCase = UseCase::find($request->useCaseId);
        if ($useCase == null) {
            abort(404);
        }

        $useCase->accentureUsers = $request->userList;
        $useCase->save();

        SecurityLog::createLog('Client saved use case accenture users', 'Use cases',
            ['useCaseId' => $request->useCaseId, 'userList' => $request->userList]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function upsertUseCaseClientUsers(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'clientList.*' => 'required|exists:users,id|numeric',
        ]);

        $useCase = UseCase::find($request->useCaseId);
        if ($useCase == null) {
            abort(404);
        }

        $useCase->clientUsers = $request->clientList;
        $useCase->save();

        SecurityLog::createLog('Client saved use case client users', 'Use cases',
            ['useCaseId' => $request->useCaseId, 'clientList' => $request->clientList]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function upsertUseCaseName(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'newName' => 'required|string',
        ]);

        $useCase = UseCase::find($request->useCaseId);
        if ($useCase == null) {
            abort(404);
        }

        $useCase->name = $request->newName;
        $useCase->save();

        SecurityLog::createLog('Client saved use case name', 'Use cases',
            ['useCaseId' => $request->useCaseId, 'name' => $request->newName]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function upsertUseCaseDescription(Request $request)
    {
        $request->validate([
            'useCaseId' => 'required|exists:use_case,id|numeric',
            'newDescription' => 'required|string',
        ]);

        $useCase = UseCase::find($request->useCaseId);
        if ($useCase == null) {
            abort(404);
        }

        $useCase->description = $request->newDescription;
        $useCase->save();

        SecurityLog::createLog('Client saved use case description', 'Use cases',
            ['useCaseId' => $request->useCaseId, 'description' => $request->newDescription]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function updateInvitedVendors(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'vendorList.*' => 'required|exists:users,id|numeric',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->use_case_invited_vendors = $request->vendorList;
        $project->save();

        SecurityLog::createLog('Client updated invited vendors', 'Project',
            ['projectId' => $request->project_id, 'vendorList' => $request->vendorList]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function changeProjectName(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'newName' => 'required|string',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->name = $request->newName;
        $project->save();

        SecurityLog::createLog('Client changed project name', 'Project',
            ['projectId' => $request->project_id, 'name' => $request->newName]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function changeProjectHasValueTargeting(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->hasValueTargeting = $request->value === 'yes';
        $project->save();

        SecurityLog::createLog('Client changed project has value targeting', 'Project',
            ['projectId' => $request->project_id, 'value' => $request->value]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function changeProjectHasOrals(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->hasOrals = $request->value === 'yes';
        $project->save();

        SecurityLog::createLog('Client changed project has orals', 'Project',
            ['projectId' => $request->project_id, 'value' => $request->value]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function changeProjectIsBinding(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->isBinding = $request->value === 'yes';
        $project->save();

        SecurityLog::createLog('Client changed project is binding', 'Project',
            ['projectId' => $request->project_id, 'value' => $request->value]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function changePractice(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'practice_id' => 'required|numeric',
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

        SecurityLog::createLog('Client changed practice', 'Project',
            ['projectId' => $request->project_id, 'practiceId' => $request->practice_id]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function changeSubpractice(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'subpractices' => 'required|array',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->subpractices()->sync($request->subpractices);
        $project->save();

        SecurityLog::createLog('Client changed subpractice', 'Project',
            ['projectId' => $request->project_id, 'subpractice' => $request->subpractices]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function changeIndustry(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->industry = $request->value;
        $project->save();

        SecurityLog::createLog('Client changed industry', 'Project',
            ['projectId' => $request->project_id, 'industry' => $request->value]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function changeRegions(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|array',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->regions = $request->value;
        $project->save();

        SecurityLog::createLog('Client changed regions', 'Project',
            ['projectId' => $request->project_id, 'regions' => $request->value]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function changeProjectType(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->projectType = $request->value;
        $project->save();

        SecurityLog::createLog('Client changed type', 'Project',
            ['projectId' => $request->project_id, 'projectType' => $request->value]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function changeCurrency(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->currency = $request->value;
        $project->save();

        SecurityLog::createLog('Client changed currency', 'Project',
            ['projectId' => $request->project_id, 'currency' => $request->value]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function changeDeadline(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->deadline = Carbon::createFromFormat('m/d/Y', $request->value)->toDateTimeString();
        $project->save();

        SecurityLog::createLog('Client changed deadline', 'Project',
            ['projectId' => $request->project_id, 'deadline' => $request->value]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }


    public function changeRFPOtherInfo(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'value' => 'required|string',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->rfpOtherInfo = $request->value;
        $project->save();

        SecurityLog::createLog('Client changed RFP other info', 'Project',
            ['projectId' => $request->project_id, 'value' => $request->value]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
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

        SecurityLog::createLog('Client set step 3 submitted', 'Project', ['projectId' => $request->project_id]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
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

        SecurityLog::createLog('Client rollback step 3', 'Project', ['projectId' => $request->project_id]);

        return \response()->json([
            'status' => 200,
            'message' => 'rollback client completed',
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

        SecurityLog::createLog('Client set step 4 submitted', 'Project', ['projectId' => $request->project_id]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
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

        SecurityLog::createLog('Client rollback step 4', 'Project', ['projectId' => $request->project_id]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
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

        SecurityLog::createLog('Published use cases', 'Use cases', ['projectId' => $project->id]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function updateScoringValues(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'values' => 'required|array',
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

        SecurityLog::createLog('Client update scoring values', 'Project',
            ['projectId' => $request->project_id, 'values' => $request->values]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
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
                ]),
            ],
            'value' => 'required|numeric',
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abort(404);
        }

        $project->{$request->changing} = $request->value;
        $project->save();

        SecurityLog::createLog('Client changed weights', 'Project',
            ['projectId' => $request->project_id, 'values' => $request->changing]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
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

        $innovationDigitalEnablersQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page',
            'innovation_digitalEnablers');
        $innovationAlliancesQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page',
            'innovation_alliances');
        $innovationProductQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page',
            'innovation_product');
        $innovationSustainabilityQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page',
            'innovation_sustainability');

        $implementationImplementationQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page',
            'implementation_implementation');
        $implementationRunQuestions = $project->selectionCriteriaQuestionsOriginals()->where('page',
            'implementation_run');

        SecurityLog::createLog('Client accessed project', 'Project',
            ['projectId' => $project->id, 'projectName' => $project->name]);

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

        SecurityLog::createLog('Client accessed project value targeting', 'Project',
            ['projectId' => $project->id, 'projectName' => $project->name]);

        return view('clientViews.projectValueTargeting', [
            'project' => $project,
        ]);
    }

    public function orals(Project $project)
    {
        if (!$project->hasOrals) {
            abort(404);
        }

        SecurityLog::createLog('Client accessed project orals', 'Project',
            ['projectId' => $project->id, 'projectName' => $project->name]);

        return view('clientViews.projectOrals', [
            'project' => $project,
            'applications' => $project->vendorApplications,
        ]);
    }

    public function conclusions(Project $project)
    {
        SecurityLog::createLog('Client accessed project conclusions', 'Project',
            ['projectId' => $project->id, 'projectName' => $project->name]);

        return view('clientViews.projectConclusions', [
            'project' => $project,
        ]);
    }

    public function benchmark(Project $project)
    {
        SecurityLog::createLog('Client accessed project benchmark', 'Project',
            ['projectId' => $project->id, 'projectName' => $project->name]);

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
        SecurityLog::createLog('Client accessed benchmark fitgap', 'Project',
            ['projectId' => $project->id, 'projectName' => $project->name]);

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
        SecurityLog::createLog('Client accessed benchmark vendor', 'Project',
            ['projectId' => $project->id, 'projectName' => $project->name]);

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
        SecurityLog::createLog('Client accessed benchmark experience', 'Project',
            ['projectId' => $project->id, 'projectName' => $project->name]);

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
        SecurityLog::createLog('Client accessed benchmark innovation', 'Project',
            ['projectId' => $project->id, 'projectName' => $project->name]);

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
        SecurityLog::createLog('Client accessed benchmark implementation', 'Project',
            ['projectId' => $project->id, 'projectName' => $project->name]);

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

        SecurityLog::createLog('Client accessed benchmark vendor comparison', 'Project',
            ['projectId' => $project->id, 'projectName' => $project->name]);

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

        $implementationImplementationQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function (
            $question
        ) {
            return $question->originalQuestion->page == 'implementation_implementation';
        });
        $implementationRunQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function (
            $question
        ) {
            return $question->originalQuestion->page == 'implementation_run';
        });

        SecurityLog::createLog('Client accessed vendor proposal view', 'Project',
            ['projectId' => $project->id, 'projectName' => $project->name, 'vendorId' => $vendor->id]);

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

        SecurityLog::createLog('Client download vendor proposal', 'Project',
            ['projectId' => $project->id, 'projectName' => $project->name, 'vendorId' => $vendor->id]);

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

        SecurityLog::createLog('Client export analytics', 'Project',
            ['projectId' => $project->id, 'projectName' => $project->name]);

        return Excel::download($export, 'responses.xlsx');
    }
}
