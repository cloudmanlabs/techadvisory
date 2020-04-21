<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use App\VendorApplication;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
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
}
