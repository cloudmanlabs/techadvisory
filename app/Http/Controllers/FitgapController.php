<?php

namespace App\Http\Controllers;

use App\FitgapQuestion;
use App\FitgapVendorResponse;
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

        FitgapQuestion::deleteByProject($project->id);

        foreach ($rows->slice(1) as $key => $row) {

            $fitgapQuestion = new FitgapQuestion([
                'position' => $key,
                'project_id' => $project->id,
                'requirement_type' => $row[0],
                'level_1' => $row[1],
                'level_2' => $row[2],
                'level_3' => $row[3],
                'requirement' => $row[4],
                'client' => $row[5],
                'business_opportunity' => $row[6],
            ]);

            $fitgapQuestion->save();
        }

        $project->hasUploadedFitgap = true;
        $project->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    /**
     * Returns the table to show as Accenture/Client views
     * @param Project $project
     * @return array
     */
    public function clientJson(Project $project)
    {
        $table = [];
        $myFitgapQuestions = FitgapQuestion::findByProject($project->id);

        foreach ($myFitgapQuestions as $key => $fitgapQuestion) {
            $table[$key]['Type'] = $fitgapQuestion->requirementType();
            $table[$key]['Level 1'] = $fitgapQuestion->level1();
            $table[$key]['Level 2'] = $fitgapQuestion->level2();
            $table[$key]['Level 3'] = $fitgapQuestion->level3();
            $table[$key]['Requirement'] = $fitgapQuestion->requirement();
            $table[$key]['Client'] = $fitgapQuestion->client();
            $table[$key]['Business Opportunity'] = $fitgapQuestion->businessOpportunity();
        }

        return $table;
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

        $table = [];
        $fitgapQuestions = FitgapQuestion::findByProject($project->id);
        $fitgapResponses = FitgapVendorResponse::findByVendorApplication($vendorApplication->id);

        return $fitgapQuestions->map(function ($fitgapQuestion) use ($fitgapResponses) {
            $fitgapResponseFound = $fitgapResponses->where('fitgap_question_id', $fitgapQuestion->id)->first();
            return [
                'Type' => $fitgapQuestion->requirementType(),
                'Level 1' => $fitgapQuestion->level1(),
                'Level 2' => $fitgapQuestion->level2(),
                'Level 3' => $fitgapQuestion->level3(),
                'Requirement' => $fitgapQuestion->requirement(),
                'Vendor response' => $fitgapResponseFound ? $fitgapResponseFound->response() : '',
                'Comments' => $fitgapResponseFound ? $fitgapResponseFound->comments() : '',
            ];
        });

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
        foreach ($project->fitgap5Columns as $key => $fitgapRow) {

            $result[$key] = $fitgapRow;

            // Client data
            foreach ($project->fitgapClientColumns as $fitgapClientRow) {
                // Add vendor Responses only where the column from Accenture exists (It could be deleted)
                $hasClientData = array_key_exists('Requirement Client Response', $fitgapClientRow);
                if ($hasClientData) {
                    // Add the client data with the relation.
                    if ($fitgapClientRow['Requirement Client Response'] == $fitgapRow['Requirement']) {
                        $result[$key]['Client'] = $fitgapClientRow['Client'];
                        $result[$key]['Business Opportunity'] = $fitgapClientRow['Business Opportunity'];
                    }
                } else {
                    // Add the client data without the relation.
                    $result[$key]['Client'] = $fitgapClientRow['Client'];
                    $result[$key]['Business Opportunity'] = $fitgapClientRow['Business Opportunity'];
                }
            }

            // Vendor data
            foreach ($vendorApplication->fitgapVendorColumns as $fitgapVendorRow) {
                // Add vendor Responses only where the column from Accenture exists (It could be deleted)
                $hasVendorData = array_key_exists('Requirement Response', $fitgapVendorRow);
                if ($hasVendorData) {

                    // Add the client data with the relation.
                    if ($fitgapVendorRow['Requirement Response'] == $fitgapRow['Requirement']) {
                        $result[$key]['Vendor Response'] = $fitgapVendorRow['Vendor Response'];
                        $result[$key]['Comments'] = $fitgapVendorRow['Comments'];
                    }
                } else {

                    // Add the client data without the relation.
                    $result[$key]['Vendor Response'] = $fitgapVendorRow['Vendor Response'];
                    $result[$key]['Comments'] = $fitgapVendorRow['Comments'];
                }
            }

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
            if ($row['Requirement Type'] == null || $row['Requirement Type'] == "") continue;

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
                'Requirement Client Response' => $row['Requirement'],
            ];

            // Check if the value has changed. If it has, reset the vendor responses
            if (
                $row['Requirement Type'] != $project->fitgap5Columns[$key]['Requirement Type']
                || $row['Level 1'] != $project->fitgap5Columns[$key]['Level 1']
                || $row['Level 2'] != $project->fitgap5Columns[$key]['Level 2']
                || $row['Level 3'] != $project->fitgap5Columns[$key]['Level 3']
                || $row['Requirement'] != $project->fitgap5Columns[$key]['Requirement']
            ) {
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
                'Requirement Response' => $row['Requirement'],
            ];
        }

        SecurityLog::createLog('Vendor edited fitgap in Project with ID ' . $project->id);

        $vendorApplication->fitgapVendorColumnsOld10 = $vendorApplication->fitgapVendorColumnsOld9;
        $vendorApplication->fitgapVendorColumnsOld9 = $vendorApplication->fitgapVendorColumnsOld8;
        $vendorApplication->fitgapVendorColumnsOld8 = $vendorApplication->fitgapVendorColumnsOld7;
        $vendorApplication->fitgapVendorColumnsOld7 = $vendorApplication->fitgapVendorColumnsOld6;
        $vendorApplication->fitgapVendorColumnsOld6 = $vendorApplication->fitgapVendorColumnsOld5;
        $vendorApplication->fitgapVendorColumnsOld5 = $vendorApplication->fitgapVendorColumnsOld4;
        $vendorApplication->fitgapVendorColumnsOld4 = $vendorApplication->fitgapVendorColumnsOld3;
        $vendorApplication->fitgapVendorColumnsOld3 = $vendorApplication->fitgapVendorColumnsOld2;
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
