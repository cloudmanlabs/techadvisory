<?php

namespace App\Http\Controllers;

use App\SelectionCriteriaQuestionResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SelectionCriteriaQuestionController extends Controller
{
    public function changeResponse(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'required',
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

        return response()->json([
            'status' => 200,
            'message' => 'nma'
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

        Log::debug($request);

        $answer->score = $request->value;
        $answer->save();

        return response()->json([
            'status' => 200,
            'message' => 'nma'
        ]);
    }
}
