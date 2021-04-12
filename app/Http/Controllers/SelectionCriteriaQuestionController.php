<?php

namespace App\Http\Controllers;

use App\SecurityLog;
use App\SelectionCriteriaQuestionResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SelectionCriteriaQuestionController extends Controller
{
    public function changeResponse(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
        ]);

        $answer = SelectionCriteriaQuestionResponse::find($request->changing);
        if ($answer == null) {
            abort(404);
        }

        if ($answer->originalQuestion->type == 'boolean') {
            $answer->response = $request->value === 'yes';
        } else {
            $answer->response = $request->value;
        }
        $answer->save();

        SecurityLog::createLog('Response changed', 'Selection Criteria',
            ['changing' => $request->changing, 'value' => $request->value]);

        return response()->json([
            'status' => 200,
            'message' => 'nma',
        ]);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'required|file',
        ]);

        $answer = SelectionCriteriaQuestionResponse::find($request->changing);
        if ($answer == null) {
            abort(404);
        }

        $path = Storage::disk('public')->putFile('questionFiles', $request->value);

        $answer->response = $path;
        $answer->save();

        SecurityLog::createLog('File uploaded', 'Selection Criteria',
            ['changing' => $request->changing, 'value' => $request->value]);

        return response()->json([
            'status' => 200,
            'message' => 'nma',
        ]);
    }

    public function changeScore(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'required|numeric',
        ]);

        $answer = SelectionCriteriaQuestionResponse::find($request->changing);
        if ($answer == null) {
            abort(404);
        }

        $answer->score = $request->value;
        $answer->save();

        SecurityLog::createLog('Score changed', 'Selection Criteria',
            ['changing' => $request->changing, 'value' => $request->value]);

        return response()->json([
            'status' => 200,
            'message' => 'nma',
        ]);
    }
}
