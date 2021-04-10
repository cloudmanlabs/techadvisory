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
use Maatwebsite\Excel\Facades\Excel;

class FitgapController extends Controller
{
    public function import5Columns(Request $request, Project $project)
    {
        $request->validate([
            'excel' => 'required|file',
        ]);

        $collection = Excel::toCollection(new FitgapImport, $request->file('excel'));
        $rows = $collection[0];

        // remove empty requirement rows
        foreach ($rows->slice(1) as $key => $row) {
            if (empty($row[4])) {
                unset($rows[$key]);
            }
        }

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

        SecurityLog::createLog('Excel imported to project', 'FitGap', ['projectId' => $project->id]);

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function clientJson(Project $project)
    {
        $fitgapQuestions = FitgapQuestion::findByProject($project->id);

        SecurityLog::createLog('Viewed', 'FitGap', ['projectId' => $project->id]);

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
            'vendor_id' => $vendor->id,
        ])->first();

        if ($vendorApplication == null) {
            abort(404);
        }

        $fitgapQuestions = FitgapQuestion::findByProject($project->id);
        $fitgapResponses = FitgapVendorResponse::findByVendorApplication($vendorApplication->id);

        SecurityLog::createLog('Viewed', 'FitGap', ['projectId' => $project->id]);

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
        $vendorApplication = VendorApplication::where([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
        ])->first();

        if ($vendorApplication == null) {
            abort(404);
        }

        $fitgapQuestions = FitgapQuestion::findByProject($project->id);
        $fitgapResponses = FitgapVendorResponse::findByVendorApplication($vendorApplication->id);

        SecurityLog::createLog('Viewed', 'FitGap', ['projectId' => $project->id]);

        return $fitgapQuestions->map(function ($fitgapQuestion) use ($fitgapResponses) {
            $fitgapResponseFound = $fitgapResponses->where('fitgap_question_id', $fitgapQuestion->id)->first();

            return [
                'ID' => $fitgapQuestion->id(),
                'Type' => $fitgapQuestion->requirementType(),
                'Level 1' => $fitgapQuestion->level1(),
                'Level 2' => $fitgapQuestion->level2(),
                'Level 3' => $fitgapQuestion->level3(),
                'Requirement' => $fitgapQuestion->requirement(),
                'Client' => $fitgapQuestion->client(),
                'Business Opportunity' => $fitgapQuestion->businessOpportunity(),
                'Vendor response' => $fitgapResponseFound ? $fitgapResponseFound->response() : '',
                'Comments' => $fitgapResponseFound ? $fitgapResponseFound->comments() : '',
            ];
        });
    }

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
        }

        $question->requirement_type = $newRequirement_type;
        $question->level_1 = $newLevel1;
        $question->level_2 = $newLevel2;
        $question->level_3 = $newLevel3;
        $question->requirement = $newRequirement;
        $question->client = $newClient;
        $question->business_opportunity = $newBusinessOpportunity;
        $question->save();

        SecurityLog::createLog('Question updated', 'FitGap', ['questionId' => $id]);

        return \response()->json([
            'status' => 200,
            'message' => 'Update Success',
        ]);
    }

    public function createFitgapQuestion(Project $project)
    {
        if ($project == null) {
            abort(404);
        }

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

        SecurityLog::createLog('Question created', 'FitGap', ['projectId' => $project->id]);

        return \response()->json([
            'status' => 200,
            'data' => $fitgapQuestion,
        ]);
    }

    public function deleteFitgapQuestion(Project $project)
    {
        $id = $_POST["data"][0];

        $question = FitgapQuestion::find($id);

        if ($question == null) {
            abort(404);
        }

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

        SecurityLog::createLog('Question deleted', 'FitGap', ['questionId' => $id]);

        return \response()->json([
            'status' => 200,
            'message' => 'Delete Success',
        ]);
    }

    public function moveFitgapQuestion(Request $request, Project $project)
    {
        // TODO Move to more convenient folder
        function moveElement($array, $from, $to)
        {
            $out = array_splice($array, $from, 1);
            array_splice($array, $to, 0, $out);

            return $array;
        }

        $fitgapQuestionId = (int) $request->input('fitgap_question_id');
        $to = (int) $request->input('to');

        $fitgapQuestions = FitgapQuestion::findByProject($project->id)->all();
        $fitgapQuestionToMove = FitgapQuestion::find($fitgapQuestionId);

        if ($fitgapQuestionToMove == null) {
            abort(404);
        }

        $from = (int) $fitgapQuestionToMove->position - 1;

        // Reindexing logic, encapsulate in a proper way
        $fitgapQuestions = moveElement($fitgapQuestions, $from, $to);
        foreach ($fitgapQuestions as $index => $fitgapQuestion) {
            $fitgapQuestion->position = $index + 1;
            $fitgapQuestion->save();
        }

        SecurityLog::createLog('Question moved', 'FitGap', ['questionId' => $fitgapQuestionId]);

        // End reindexing logic
        return \response()->json([
            'status' => 200,
            'message' => 'Update Move Success',
            'questions' => $fitgapQuestions,
        ]);
    }

    public function updateFitgapResponse(Project $project, User $vendor)
    {
        $questionId = $_POST["data"][0];

        if (($questionId == null) || $project == null || !$vendor->isVendor()) {
            return abort(404);
        }

        $vendorApplication = VendorApplication::where([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
        ])->first();

        $response = FitgapVendorResponse::findByFitgapQuestionFromTheApplication($vendorApplication->id, $questionId);

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
        }

        SecurityLog::createLog('Response updated', 'FitGap', ['responseId' => $response->id]);

        return \response()->json([
            'status' => 200,
            'message' => 'Update Success',
        ]);
    }

    public function clientIframe(Request $request, Project $project)
    {
        return view('fitgap.clientIframe', [
            'project' => $project,
            'disabled' => $request->disabled ?? false,
            'isAccenture' => $request->isAccenture,
        ]);
    }

    public function vendorIframe(Request $request, User $vendor, Project $project)
    {
        $vendorApplication = VendorApplication::where([
            'project_id' => $project->id,
            'vendor_id' => $vendor->id,
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
            'vendor_id' => $vendor->id,
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
