<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use App\VendorApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FitgapController extends Controller
{
    public function vendorIframe(Request $request, User $vendor, Project $project)
    {
        $vendorApplication = VendorApplication::where([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id
        ])->first();
        if ($vendorApplication == null) {
            abort(404);
        }

        return view('fitgap.vendorIframe', [
            'project' => $project,
            'vendor' => $vendor,
            'disabled' => $request->disabled ?? false,
            'review' => $request->review ?? false,
        ]);
    }

    public function vendorJson(Request $request, User $vendor, Project $project)
    {
        $vendorApplication = VendorApplication::where([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id
        ])->first();

        if($vendorApplication == null){
            abort(404);
        }

        $fitgap = $vendorApplication->fitgapData;
        $result = [];

        // If we're not in review mode, remove the score
        $review = $request->review ?? false;
        foreach ($fitgap as $key => $row) {
            if(! $review){
                unset($row['Score']);
            }
            $result[] = $row;
        }

        return $result;
    }

    public function vendorJsonUpload(Request $request, User $vendor, Project $project)
    {
        $request->validate([
            'data' => 'required|array'
        ]);

        $vendorApplication = VendorApplication::where([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id
        ])->first();

        if($vendorApplication == null){
            abort(404);
        }

        $vendorApplication->fitgapData = $request->data;
        $vendorApplication->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }



    public function mainIframe(Request $request, Project $project)
    {
        return view('fitgap.mainIframe', [
            'project' => $project,
            'disabled' => $request->disabled ?? false
        ]);
    }

    public function mainJson(Project $project)
    {
        return $project->fitgapData;
    }

    public function mainJsonUpload(Request $request, Project $project)
    {
        $request->validate([
            'data' => 'required|array'
        ]);

        $project->fitgapData = $request->data;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }
}
