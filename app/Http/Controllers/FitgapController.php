<?php

namespace App\Http\Controllers;

use App\Imports\FitgapImport;
use App\Project;
use App\SecurityLog;
use App\User;
use App\VendorApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class FitgapController extends Controller
{
    public function import5Columns(Request $request, Project $project)
    {
        $request->validate([
            'excel' => 'required|file'
        ]);

        $collection = Excel::toCollection(new FitgapImport, $request->file('excel'));
        $rows = $collection[0];

        $result5Cols = [];
        $resultClient = [];
        for ($i = 1; isset($rows[$i][0]) && $rows[$i][0] != null; $i++) {
            $row = $rows[$i];

            $result5Cols[] = [
                'Requirement Type' => $row[0], // This one won't be null cause we check it in the for
                'Level 1' => $row[1] ?? '',
                'Level 2' => $row[2] ?? '',
                'Level 3' => $row[3] ?? '',
                'Requirement' => $row[4] ?? '',
            ];
            $resultClient[] = [
                'Client' => $row[5] ?? '',
                'Business Opportunity' => $row[6] ?? '',
            ];
        }

        $project->fitgap5Columns = $result5Cols;
        $project->fitgapClientColumns = $resultClient;
        $project->hasUploadedFitgap = true;
        $project->save();

        Log::debug($project);

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }








    public function clientJson(Project $project)
    {
        $result = [];
        // Merge the two arrays
        foreach ($project->fitgap5Columns as $key => $something) {
            $result[] = array_merge($project->fitgap5Columns[$key], $project->fitgapClientColumns[$key] ?? [
                'Client' => '',
                'Business Opportunity' => '',
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
            $result[] = array_merge(
                $project->fitgap5Columns[$key],
                $vendorApplication->fitgapVendorColumns[$key] ?? [
                    'Vendor Response' => '',
                    'Comments' => '',
                ]
            );
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
            $row = array_merge(
                $project->fitgap5Columns[$key],
                $project->fitgapClientColumns[$key] ?? [
                    'Client' => '',
                    'Business Opportunity' => '',
                ],
                $vendorApplication->fitgapVendorColumns[$key] ?? [
                    'Vendor Response' => '',
                    'Comments' => '',
                ],
            );
            //$row['Score'] = $vendorApplication->fitgapVendorScores[$key] ?? 5;

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
        $result5Cols = [];
        $resultClient = [];
        foreach ($request->data as $key => $row) {
            if($row['Requirement Type'] == null || $row['Requirement Type'] == "") continue;

            $result5Cols[] = [
                'Requirement Type' => $row['Requirement Type'],
                'Level 1' => $row['Level 1'],
                'Level 2' => $row['Level 2'],
                'Level 3' => $row['Level 3'],
                'Requirement' => $row['Requirement'],
            ];
            $resultClient[] = [
                'Client' => $row['Client'],
                'Business Opportunity' => $row['Business Opportunity'],
            ];

            // Check if the value has changed. If it has, reset the vendor responses
            if(
                $row['Requirement Type'] != $project->fitgap5Columns[$key]['Requirement Type']
                || $row['Level 1'] != $project->fitgap5Columns[$key]['Level 1']
                || $row['Level 2'] != $project->fitgap5Columns[$key]['Level 2']
                || $row['Level 3'] != $project->fitgap5Columns[$key]['Level 3']
                || $row['Requirement'] != $project->fitgap5Columns[$key]['Requirement']
            ){
                foreach ($project->vendorApplications as $key1 => $application) {
                    /** @var VendorApplication $application */
                    $fitgapVendorColumns = $application->fitgapVendorColumns;

                    $fitgapVendorColumns[$key]['Vendor Response'] = '';
                    $fitgapVendorColumns[$key]['Comments'] = '';

                    $application->fitgapVendorColumns = $fitgapVendorColumns;
                    $application->save();
                }
            }
        }

        $project->fitgapClientColumns = $resultClient;
        $project->fitgap5Columns = $result5Cols;
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

        SecurityLog::createLog('Vendor edited fitgap in Project with ID ' . $project->id);

        $vendorApplication->fitgapVendorColumnsOld2 = $vendorApplication->fitgapVendorColumnsOld;
        $vendorApplication->fitgapVendorColumnsOld = $vendorApplication->fitgapVendorColumns;
        $vendorApplication->fitgapVendorColumns = $result;
        $vendorApplication->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function evaluationJsonUpload(Request $request, User $vendor, Project $project)
    {
        return 'Deprecated';

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
            'disabled' => $request->disabled ?? false,
            'isAccenture' => $request->isAccenture
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
