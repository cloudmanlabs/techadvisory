<?php


namespace App\Http\Controllers;

use App\SecurityLog;
use App\UseCaseQuestion;
use App\UseCaseQuestionResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UseCaseQuestionResponseController extends Controller
{
    public function upsertResponse(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'useCase' => 'required|numeric',
        ]);

        $answer = UseCaseQuestionResponse::where('use_case_questions_id', $request->changing)
            ->where('use_case_id', $request->useCase)
            ->first();
        if ($answer == null) {
            $answer = new UseCaseQuestionResponse();
            $answer->use_case_questions_id = $request->changing;
            $answer->use_case_id = $request->useCase;
        }

        $question = UseCaseQuestion::find($request->changing);
        if ($question->type == 'boolean') {
            $answer->response = $request->value === 'yes';
        } else {
            $answer->response = $request->value;
        }
        $answer->save();

        SecurityLog::createLog('Saved response', 'Use Cases',
            ['useCaseId' => $request->useCase, 'changing' => $request->changing]);

        return response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'useCase' => 'required|numeric',
            'value' => 'required|file',
        ]);

        $answer = UseCaseQuestionResponse::where('use_case_questions_id', $request->changing)
            ->where('use_case_id', $request->useCase)
            ->first();
        if ($answer == null) {
            $answer = new UseCaseQuestionResponse();
            $answer->use_case_questions_id = $request->changing;
            $answer->use_case_id = $request->useCase;
        }

        $path = Storage::disk('public')->putFile('questionFiles', $request->value);

        $answer->response = $path;
        $answer->save();

        SecurityLog::createLog('Uploaded file for response', 'Use Cases',
            ['useCaseId' => $request->useCase, 'changing' => $request->changing, 'value' => $request->value]);

        return response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }
}
