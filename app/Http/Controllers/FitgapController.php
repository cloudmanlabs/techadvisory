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
            'disabled' => $request->disabled ?? false
        ]);
    }

    public function vendorJson(User $vendor, Project $project)
    {
        $vendorApplication = VendorApplication::where([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id
        ])->first();

        if($vendorApplication == null){
            abort(404);
        }

        return $vendorApplication->fitgapData;
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
}
