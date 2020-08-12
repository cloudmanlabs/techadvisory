<?php

namespace App\Http\Controllers\Vendor;

use App\SelectionCriteriaQuestionResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use App\SecurityLog;
use App\User;
use App\VendorApplication;
use App\Providers\Utils;

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

        SecurityLog::createLog('User accessed project with ID ' . $project->id);

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

        $vendorApplication = \App\VendorApplication::where('project_id', $project->id)->where('vendor_id', $vendor->id)->first();

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


        SecurityLog::createLog('User accessed project with ID ' . $project->id);

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

        return redirect()->route('vendor.home');
    }

    public function setAccepted(Request $request, Project $project)
    {
        $application = VendorApplication::where('vendor_id', auth()->id())
            ->where('project_id', $project->id)
            ->first();
        if ($application == null) {
            abort(404);
        }

        $application->setApplicating();

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

        return response()->json([
            'status' => 200,
            'message' => 'hello'
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

        SecurityLog::createLog('User accessed project with ID ' . $project->id);

        return view('vendorViews.newApplication', [
            'project' => $project,
            'clients' => $clients,

            'generalInfoQuestions' => $project->generalInfoQuestions,
            'sizingQuestions' => $sizingQuestions,
        ]);
    }


    public function newApplicationApply(Project $project)
    {
        /** @var User $vendor */
        $vendor = auth()->user();
        if (!$vendor->hasAppliedToProject($project)) {
            abort(404);
        }

        $vendorApplication = \App\VendorApplication::where('project_id', $project->id)->where('vendor_id', $vendor->id)->first();
        if ($vendorApplication->phase != 'applicating') {
            abort(404);
        }

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

        // Feature 1: get Responses from similar project
        $selectionCriteriaQuestionsResponsesFromSimilarProject = SelectionCriteriaQuestionResponse::getResponsesFromSimilarProject($vendor, $project);
        $this->replaceResponses($vendorCorporateQuestions, $selectionCriteriaQuestionsResponsesFromSimilarProject);
        $this->replaceResponses($vendorMarketQuestions, $selectionCriteriaQuestionsResponsesFromSimilarProject);
        $this->replaceResponses($experienceQuestions, $selectionCriteriaQuestionsResponsesFromSimilarProject);
        $this->replaceResponses($innovationDigitalEnablersQuestions, $selectionCriteriaQuestionsResponsesFromSimilarProject);
        $this->replaceResponses($innovationAlliancesQuestions, $selectionCriteriaQuestionsResponsesFromSimilarProject);
        $this->replaceResponses($innovationProductQuestions, $selectionCriteriaQuestionsResponsesFromSimilarProject);
        $this->replaceResponses($innovationSustainabilityQuestions, $selectionCriteriaQuestionsResponsesFromSimilarProject);

        SecurityLog::createLog('User accessed project with ID ' . $project->id);

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
            'vendor_id' => $vendor->id
        ])->first();

        if ($application == null) {
            abort(404);
        }

        if (!$project->hasOrals) {
            abort(404);
        }

        SecurityLog::createLog('User accessed project with ID ' . $project->id);

        return view('vendorViews.newApplicationOrals', [
            'project' => $project,
            'application' => $application
        ]);
    }

    public function submittedApplication(Project $project)
    {
        /** @var User $vendor */
        $vendor = auth()->user();
        if (!$vendor->hasAppliedToProject($project)) {
            abort(404);
        }
        $vendorApplication = \App\VendorApplication::where('project_id', $project->id)->where('vendor_id', $vendor->id)->first();
        if ($vendorApplication->phase == 'applicating') {
            abort(404);
        }

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

        SecurityLog::createLog('User accessed project with ID ' . $project->id);

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

    private function replaceResponses($currentResponses, $similarResponses)
    {
        // Replace answers for Page Vendor Corporate
        foreach ($currentResponses as $currentResponse) {
            if ($currentResponse->response === null) {
                foreach ($similarResponses as $similarResponse) {
                    if ($currentResponse->question_id == $similarResponse->question_id) {
                        $currentResponse->response = $similarResponse->response;
                    }
                }
            }
        }
    }
}
