<?php

namespace App\Http\Controllers;

use _HumbugBoxe251c92b00d9\Nette\Neon\Exception;
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
    // Import method
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

    // Generate table methods.
    public function clientJson(Project $project)
    {
        $fitgapQuestions = FitgapQuestion::findByProject($project->id);

        return $fitgapQuestions->map(function ($fitgapQuestion) {
            return [
                'ID' => $fitgapQuestion->id(),
                'Type' => $fitgapQuestion->requirementType(),
                'Level 1' => $fitgapQuestion->level1(),
                'Level 2' => $fitgapQuestion->level2(),
                'Level 3' => $fitgapQuestion->level3(),
                'Requirement' => $fitgapQuestion->requirement(),
                'Client' => $fitgapQuestion->client(),
                'Business Opportunity' => $fitgapQuestion->businessOpportunity(),
            ];

        });
    }

    public function vendorJson(User $vendor, Project $project)
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
                'ID' => $fitgapQuestion->id(),
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

    public function evaluationJson(User $vendor, Project $project)
    {
        return $this->vendorJson($vendor, $project);
    }

    // Old methods for update
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

    // New methods for update, create and delete Fitgap Questions
    public function updateFitgapQuestion()
    {
        $id = $_POST["data"][0];
        $newRequirement_type = $_POST["data"][1];
        $newLevel1 = $_POST["data"][2];
        $newLevel2 = $_POST["data"][3];
        $newLevel3 = $_POST["data"][4];
        $newRequirement = $_POST["data"][5];
        $newClient = $_POST["data"][6];
        $newBusinessOpportunity = $_POST["data"][7];

        $question = FitgapQuestion::find($id);
        if ($question == null) {
            abort(404);
        } else {
            $question->requirement_type = $newRequirement_type;
            $question->level_1 = $newLevel1;
            $question->level_2 = $newLevel2;
            $question->level_3 = $newLevel3;
            $question->requirement = $newRequirement;
            $question->client = $newClient;
            $question->business_opportunity = $newBusinessOpportunity;
            $question->save();

            return \response()->json([
                'status' => 200,
                'message' => 'Update Success'
            ]);
        }
    }

    public function createFitgapQuestion(Project $project)
    {
        if ($project == null) {
            abort(404);
        } else {
            // Add the question at last position of the project..
            $lastQuestion = FitgapQuestion::findByProject($project->id)->last();
            $newPosition = $lastQuestion->position + 1;

            $fitgapQuestion = new FitgapQuestion([
                'position' => $newPosition,
                'project_id' => $project->id,
                'requirement_type' => '',
                'level_1' => '',
                'level_2' => '',
                'level_3' => '',
                'requirement' => '',
                'client' => '',
                'business_opportunity' => '',
            ]);
            $fitgapQuestion->save();

            return \response()->json([
                'status' => 200,
                'data' => $fitgapQuestion
            ]);

        }
    }

    public function deleteFitgapQuestion(Project $project)
    {
        $id = $_POST["data"][0];

        $question = FitgapQuestion::find($id);
        if ($question == null) {
            abort(404);
        } else {
            $questionPosition = $question->position;
            $questionsToUpdate = FitgapQuestion::findByProject($project->id)
                ->where('position', '>', $questionPosition);

            // update the positions
            foreach ($questionsToUpdate as $questionUpdate) {
                $questionUpdate->position = $questionUpdate->position - 1;
                $questionUpdate->save();
            }

            // delete the responses
            $responsesTodelete = FitgapVendorResponse::findByQuestion($question->id);
            foreach ($responsesTodelete as $response) {
                $response->delete();
            }

            $question->delete();

            return \response()->json([
                'status' => 200,
                'message' => 'Delete Success'
            ]);
        }
    }

    public function moveFitgapQuestion(Project $project)
    {

        // TODO Move to more convenient folder
        function moveElement($array, $from, $to)
        {
            $out = array_splice($array, $from, 1);
            array_splice($array, $to, 0, $out);
        }

        $fitgapQuestionId = $_POST["data"][0];
        $to = (int)$_POST["position"] + 1;

        $fitgapQuestions = FitgapQuestion::findByProject($project->id)->all();
        $fitgapQuestionToMove = FitgapQuestion::find($fitgapQuestionId);

        if ($fitgapQuestionToMove == null) {
            abort(404);
        }

        $from = (int)$fitgapQuestionToMove->position;

        // Reindexing logic, encapsulate in a proper way
        moveElement($fitgapQuestions, $from, $to);
        foreach ($fitgapQuestions as $index => $fitgapQuestion) {
            $fitgapQuestion->position = $index + 1;
            $fitgapQuestion->save();
        }
        // End reindexing logic
        $result= FitgapQuestion::findByProject($project->id)->all();
        return \response()->json([
            'status' => 200,
            'message' => 'Update Move Success',
            'questions' => $fitgapQuestions
        ]);
    }

    // New methods for update Fitgap Responses

    public function updateFitgapResponse(Project $project)
    {
        $questionId = $_POST["data"][0];
        $vendor = auth()->user();


        if (($questionId == null) || $project == null || !$vendor->isVendor()) {
            return abort(404);
        } else {
            $vendorApplication = VendorApplication::where([
                'project_id' => $project->id,
                'vendor_id' => $vendor->id
            ])->first();

            $response = FitgapVendorResponse::findByFitgapQuestionFromTheApplication(
                $vendorApplication->id, $questionId);

            $newVendorResponse = $_POST["data"][6];
            $newComments = $_POST["data"][7];

            if ($response == null) {

                // There is no answer yet.
                $response = new FitgapVendorResponse([
                    'fitgap_question_id' => $questionId,
                    'vendor_application_id' => $vendorApplication->id,
                    'response' => $newVendorResponse,
                    'comments' => $newComments,
                ]);
                $response->save();

            } else {

                // Edit the current response.
                $response->response = $newVendorResponse;
                $response->comments = $newComments;
                $response->save();

                return \response()->json([
                    'status' => 200,
                    'message' => 'Update Success'
                ]);
            }
        }

    }

    // Launch View Methods
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
