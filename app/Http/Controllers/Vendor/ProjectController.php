<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Project;
use App\Providers\Utils;
use App\SecurityLog;
use App\SelectionCriteriaQuestionResponse;
use App\UseCase;
use App\UseCaseQuestion;
use App\UseCaseQuestionResponse;
use App\User;
use App\VendorApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function previewProject(Project $project)
    {
        if (!auth()->user()->hasAppliedToProject($project)) {
            abort(404);
        }

        $sizingQuestions = $project->sizingQuestions->filter(function ($el) {
            return $el->shouldShow;
        });

        $clients = User::clientUsers()->get();

        SecurityLog::createLog('Vendor accessed project', 'Projects',
            ['projectId' => $project->id, 'projectName' => $project->name]);

        return view('vendorViews.previewProject', [
            'project' => $project,
            'clients' => $clients,

            'generalInfoQuestions' => $project->generalInfoQuestions,
            'sizingQuestions' => $sizingQuestions,
        ]);
    }

    public function previewProjectApply(Project $project)
    {
        /** @var User $vendor */
        $vendor = auth()->user();
        if (!$vendor->hasAppliedToProject($project)) {
            abort(404);
        }

        $vendorApplication = \App\VendorApplication::where('project_id', $project->id)
            ->where('vendor_id', $vendor->id)->first();

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
            })
            ->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'vendor_market';
            });

        $experienceQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id', '=', null);
            })
            ->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'experience';
            });

        $innovationDigitalEnablersQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id', '=', null);
            })
            ->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'innovation_digitalEnablers';
            });

        $innovationAlliancesQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id', '=', null);
            })
            ->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'innovation_alliances';
            });

        $innovationProductQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id', '=', null);
            })
            ->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'innovation_product';
            });

        $innovationSustainabilityQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) use ($practiceOfTheProject) {
                $query->where('practice_id', '=', $practiceOfTheProject)
                    ->orWhere('practice_id', '=', null);
            })
            ->get()
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


        SecurityLog::createLog('Vendor accessed preview project apply', 'Projects',
            ['projectId' => $project->id, 'projectName' => $project->name]);

        return view('vendorViews.previewProjectApply', [
            'project' => $project,
            'vendorApplication' => $vendorApplication,

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

    public function setRejected(Request $request, Project $project)
    {
        $application = VendorApplication::where('vendor_id', auth()->id())
            ->where('project_id', $project->id)
            ->first();

        if ($application == null) {
            abort(404);
        }

        $application->setRejected();

        SecurityLog::createLog('Vendor rejected', 'Projects',
            ['projectId' => $project->id, 'projectName' => $project->name]);

        return redirect()->route('vendor.home');
    }

    public function setAccepted(Request $request, Project $project)
    {
        $vendor = Auth::user();
        $application = VendorApplication::where('vendor_id', $vendor->id)
            ->where('project_id', $project->id)
            ->first();

        if ($application == null) {
            abort(404);
        }

        $application->setApplicating();
        $this->replaceResponsesWithRecommendations($project, $vendor);

        SecurityLog::createLog('Vendor accepted', 'Projects',
            ['projectId' => $project->id, 'projectName' => $project->name]);

        return redirect()->route('vendor.home');
    }

    public function setSubmitted(Request $request, Project $project)
    {
        $application = VendorApplication::where('vendor_id', auth()->id())
            ->where('project_id', $project->id)
            ->first();
        if ($application == null) {
            abort(404);
        }

        $application->setPendingEvaluation();

        SecurityLog::createLog('Vendor submitted application', 'Projects',
            ['projectId' => $project->id, 'projectName' => $project->name]);

        return response()->json([
            'status' => 200,
            'message' => 'hello',
        ]);
    }

    public function newApplication(Project $project)
    {
        if (!auth()->user()->hasAppliedToProject($project)) {
            abort(404);
        }

        $clients = User::clientUsers()->get();

        $sizingQuestions = $project->sizingQuestions->filter(function ($el) {
            return $el->shouldShow;
        });

        SecurityLog::createLog('Vendor created evaluation', 'Projects',
            ['projectId' => $project->id, 'projectName' => $project->name]);

        return view('vendorViews.newApplication', [
            'project' => $project,
            'clients' => $clients,

            'generalInfoQuestions' => $project->generalInfoQuestions,
            'sizingQuestions' => $sizingQuestions,
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

    public function useCasesSetUp(Request $request, Project $project)
    {
//        $useCases = UseCases::findByProject($project->id);
        $useCases = $project->useCases()->get();

        $useCaseQuestions = UseCaseQuestion::all();

        $view = [
            'project' => $project,

            'useCases' => $useCases,
            'useCaseQuestions' => $useCaseQuestions,
        ];

        $useCaseNumber = $request->input('useCase');
        if ($useCaseNumber) {
            $useCase = UseCase::find($useCaseNumber);
            $view['currentUseCase'] = $useCase;
            $useCaseResponses = UseCaseQuestionResponse::getResponsesFromUseCase($useCase);
            $view['useCaseResponses'] = $useCaseResponses;
            $useCaseQuestions = $this->getQuestionsWithTypeFieldFilled($useCaseQuestions, $useCaseResponses);
        } elseif ($project->useCasesPhase === 'evaluation') {
            $useCase = UseCase::findByProject($project->id)->first();
            $view['currentUseCase'] = $useCase;
            $useCaseResponses = UseCaseQuestionResponse::getResponsesFromUseCase($useCase);
            $view['useCaseResponses'] = $useCaseResponses;
            $useCaseQuestions = $this->getQuestionsWithTypeFieldFilled($useCaseQuestions, $useCaseResponses);
        }

        $view['useCaseQuestions'] = $useCaseQuestions;

        SecurityLog::createLog('Accessed project use cases setup', 'UseCases', ['projectId' => $project->id]);

        return view('vendorViews.useCasesSetUp', $view);
    }


    public function newApplicationApply(Project $project)
    {
        /** @var User $vendor */
        $vendor = auth()->user();

        if (!$vendor->hasAppliedToProject($project)) {
            abort(404);
        }

        $vendorApplication = \App\VendorApplication::where('project_id', $project->id)
            ->where('vendor_id', $vendor->id)
            ->first();

        if ($vendorApplication->phase != 'applicating') {
            abort(404);
        }

        $fitgapQuestions = $project->getFitGapQuestions($vendor);
        $vendorCorporateQuestions = $project->getVendorCorporateQuestions($vendor);
        $vendorMarketQuestions = $project->getVendorMarketQuestions($vendor);
        $experienceQuestions = $project->getExperienceQuestions($vendor);
        $innovationDigitalEnablersQuestions = $project->getInnovationDigitalEnablersQuestions($vendor);
        $innovationAlliancesQuestions = $project->getInnovationAlliancesQuestions($vendor);
        $innovationProductQuestions = $project->getInnovationProductQuestions($vendor);
        $innovationSustainabilityQuestions = $project->getInnovationSustainabilityQuestions($vendor);
        $implementationImplementationQuestions = $project->getImplementationImplementationQuestions($vendor);
        $implementationRunQuestions = $project->getImplementationRunQuestions($vendor);

//        $selectionCriteriaQuestionsResponsesFromSimilarProject = SelectionCriteriaQuestionResponse::getResponsesFromSimilarProject($vendor,
//            $project);
//        $this->replaceResponses($vendorCorporateQuestions, $selectionCriteriaQuestionsResponsesFromSimilarProject);
//        $this->replaceResponses($vendorMarketQuestions, $selectionCriteriaQuestionsResponsesFromSimilarProject);
//        $this->replaceResponses($experienceQuestions, $selectionCriteriaQuestionsResponsesFromSimilarProject);
//        $this->replaceResponses($innovationDigitalEnablersQuestions,
//            $selectionCriteriaQuestionsResponsesFromSimilarProject);
//        $this->replaceResponses($innovationAlliancesQuestions, $selectionCriteriaQuestionsResponsesFromSimilarProject);
//        $this->replaceResponses($innovationProductQuestions, $selectionCriteriaQuestionsResponsesFromSimilarProject);
//        $this->replaceResponses($innovationSustainabilityQuestions,
//            $selectionCriteriaQuestionsResponsesFromSimilarProject);

        SecurityLog::createLog('Vendor applied to project', 'Projects',
            ['projectId' => $project->id, 'projectName' => $project->name]);

        return view('vendorViews.newApplicationApply', [
            'project' => $project,
            'vendorApplication' => $vendorApplication,
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

    public function projectOrals(Project $project)
    {
        /** @var User $vendor */
        $vendor = auth()->user();

        $application = VendorApplication::where([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
        ])->first();

        if ($application == null) {
            abort(404);
        }

        if (!$project->hasOrals) {
            abort(404);
        }

        SecurityLog::createLog('Vendor accessed project orals', 'Projects',
            ['projectId' => $project->id, 'projectName' => $project->name]);

        return view('vendorViews.newApplicationOrals', [
            'project' => $project,
            'application' => $application,
        ]);
    }

    public function submittedApplication(Project $project)
    {
        /** @var User $vendor */
        $vendor = auth()->user();
        if (!$vendor->hasAppliedToProject($project)) {
            abort(404);
        }
        $vendorApplication = \App\VendorApplication::where('project_id', $project->id)->where('vendor_id',
            $vendor->id)->first();
        if ($vendorApplication->phase == 'applicating') {
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

        SecurityLog::createLog('Vendor accessed submitted application', 'Projects',
            ['projectId' => $project->id, 'projectName' => $project->name]);

        return view('vendorViews.submittedApplication', [
            'project' => $project,
            'vendorApplication' => $vendorApplication,
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

    private function replaceResponsesWithRecommendations(Project $project, User $vendor)
    {
        $vendorCorporateQuestions = $project->getVendorCorporateQuestions($vendor);
        $vendorMarketQuestions = $project->getVendorMarketQuestions($vendor);
        $experienceQuestions = $project->getExperienceQuestions($vendor);
        $innovationDigitalEnablersQuestions = $project->getInnovationDigitalEnablersQuestions($vendor);
        $innovationAlliancesQuestions = $project->getInnovationAlliancesQuestions($vendor);
        $innovationProductQuestions = $project->getInnovationProductQuestions($vendor);
        $innovationSustainabilityQuestions = $project->getInnovationSustainabilityQuestions($vendor);

        $similarResponses = SelectionCriteriaQuestionResponse::getResponsesFromSimilarProject($vendor, $project);
        $this->replaceResponses($vendorCorporateQuestions, $similarResponses);
        $this->replaceResponses($vendorMarketQuestions, $similarResponses);
        $this->replaceResponses($experienceQuestions, $similarResponses);
        $this->replaceResponses($innovationDigitalEnablersQuestions, $similarResponses);
        $this->replaceResponses($innovationAlliancesQuestions, $similarResponses);
        $this->replaceResponses($innovationProductQuestions, $similarResponses);
        $this->replaceResponses($innovationSustainabilityQuestions, $similarResponses);
    }


    private function replaceResponses($currentResponses, $similarResponses)
    {
        // Replace answers for Page Vendor Corporate
        foreach ($currentResponses as $currentResponse) {
            if ($currentResponse->response === null) {
                foreach ($similarResponses as $similarResponse) {
                    if ($currentResponse->question_id == $similarResponse->question_id) {
                        $currentResponse->response = $similarResponse->response;
                        $currentResponse->save();
                    }
                }
            }
        }
    }
}
