<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use App\VendorApplication;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function previewProject(Project $project)
    {
        if(! auth()->user()->hasAppliedToProject($project)){
            abort(404);
        }

        return view('vendorViews.previewProject',[
            'project' => $project
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
}
