<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use App\User;
use App\VendorApplication;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function previewProject(Project $project)
    {
        if(! auth()->user()->hasAppliedToProject($project)){
            abort(404);
        }

        $clients = User::clientUsers()->get();

        return view('vendorViews.previewProject',[
            'project' => $project,
            'clients' => $clients,

            'generalInfoQuestions' => $project->generalInfoQuestions,
            'sizingQuestions' => $project->sizingQuestions,
        ]);
    }

    public function setRejected(Request $request, Project $project)
    {
        $application = VendorApplication::where('vendor_id', auth()->id())
                                            ->where('project_id', $project->id)
                                            ->first();
        if($application == null){
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





    public function newApplication(Project $project)
    {
        if (!auth()->user()->hasAppliedToProject($project)) {
            abort(404);
        }

        $clients = User::clientUsers()->get();

        return view('vendorViews.newApplication', [
            'project' => $project,
            'clients' => $clients,

            'generalInfoQuestions' => $project->generalInfoQuestions,
            'sizingQuestions' => $project->sizingQuestions,
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
        if($vendorApplication->phase != 'applicating'){
            abort(404);
        }

        $fitgapQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function($question){
            return $question->original->page == 'fitgap';
        });
        $vendorCorporateQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function($question){
            return $question->original->page == 'vendor_corporate';
        });
        $vendorMarketQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function($question){
            return $question->original->page == 'vendor_market';
        });
        $experienceQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function($question){
            return $question->original->page == 'experience';
        });
        $innovationDigitalEnablersQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function($question){
            return $question->original->page == 'innovation_digitalEnablers';
        });
        $innovationAlliancesQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function($question){
            return $question->original->page == 'innovation_alliances';
        });
        $innovationProductQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function($question){
            return $question->original->page == 'innovation_product';
        });
        $innovationSustainabilityQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function($question){
            return $question->original->page == 'innovation_sustainability';
        });

        $implementationImplementationQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function($question){
            return $question->original->page == 'implementation_implementation';
        });
        $implementationRunQuestions = $project->selectionCriteriaQuestionsForVendor($vendor)->get()->filter(function($question){
            return $question->original->page == 'implementation_run';
        });

        return view('vendorViews.newApplicationApply', [
            'project' => $project,

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

        return view('vendorViews.submittedApplication', [
            'project' => $project,

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
}
