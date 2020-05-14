<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use App\VendorApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FitgapController extends Controller
{
    public function clientJson(Project $project)
    {
        $result = [];
        // Merge the two arrays
        foreach ($project->fitgap5Columns as $key => $something) {
            $result[] = array_merge($project->fitgap5Columns[$key], $project->fitgapClientColumns[$key] ?? [
                'Client' => '',
                'Business Oportunity' => '',
            ]);
        }

        return $result;
    }

    public function vendorJson(Request $request, User $vendor, Project $project)
    {
        $vendorApplication = VendorApplication::where([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id
        ])->first();

        if ($vendorApplication == null) {
            abort(404);
        }

        $result = [];
        // Merge the two arrays
        foreach ($project->fitgap5Columns as $key => $something) {
            $result[] = array_merge($project->fitgap5Columns[$key], $vendorApplication->fitgapVendorColumns[$key] ?? [
                'Vendor Response' => '',
                'Comments' => '',
            ]);
        }

        return $result;
    }

    public function evaluationJson(Request $request, User $vendor, Project $project)
    {
        $vendorApplication = VendorApplication::where([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id
        ])->first();

        if ($vendorApplication == null) {
            abort(404);
        }

        $result = [];
        // Merge the two arrays
        foreach ($project->fitgap5Columns as $key => $something) {
            $row = array_merge($project->fitgap5Columns[$key], $vendorApplication->fitgapVendorColumns[$key] ?? [
                'Vendor Response' => '',
                'Comments' => '',
            ]);
            $row['Score'] = $vendorApplication->fitgapVendorScores[$key] ?? 5;

            $result[] = $row;
        }

        return $result;
    }






    public function clientJsonUpload(Request $request, Project $project)
    {
        $request->validate([
            'data' => 'required|array'
        ]);

        // The data array contains all the columns, cause what is that the jexcel json exporter gives us
        // We get only the two columns that matter here and save them

        // Parse stuff here
        $result = [];
        foreach ($request->data as $key => $row) {
            $result[] = [
                'Client' => $row['Client'],
                'Business Oportunity' => $row['Business Oportunity'],
            ];
        }

        $project->fitgapClientColumns = $result;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
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

        if ($vendorApplication == null) {
            abort(404);
        }

        // Parse stuff here
        $result = [];
        foreach ($request->data as $key => $row) {
            $result[] = [
                'Vendor Response' => $row['Vendor Response'],
                'Comments' => $row['Comments'],
            ];
        }

        $vendorApplication->fitgapVendorColumns = $result;
        $vendorApplication->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function evaluationJsonUpload(Request $request, User $vendor, Project $project)
    {
        $request->validate([
            'data' => 'required|array'
        ]);

        $vendorApplication = VendorApplication::where([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id
        ])->first();

        if ($vendorApplication == null) {
            abort(404);
        }

        // Parse stuff here
        $result = [];
        foreach ($request->data as $key => $row) {
            $result[] = $row['Score'];
        }

        $vendorApplication->fitgapVendorScores = $result;
        $vendorApplication->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }









    public function clientIframe(Request $request, Project $project)
    {
        return view('fitgap.clientIframe', [
            'project' => $project,
            'disabled' => $request->disabled ?? false
        ]);
    }

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
        ]);
    }

    public function evaluationIframe(Request $request, User $vendor, Project $project)
    {
        $vendorApplication = VendorApplication::where([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id
        ])->first();
        if ($vendorApplication == null) {
            abort(404);
        }

        return view('fitgap.evaluationIframe', [
            'project' => $project,
            'vendor' => $vendor,
            'disabled' => $request->disabled ?? false,
        ]);
    }
}
