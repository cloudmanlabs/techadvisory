<?php

namespace App\Http\Controllers;

use App\SizingQuestionResponse;
use Illuminate\Http\Request;

class SizingQuestionController extends Controller
{
    public function changeResponse(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'required',
        ]);

        $answer = SizingQuestionResponse::find($request->changing);
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

    public function setShouldShow(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'required',
        ]);

        $answer = SizingQuestionResponse::find($request->changing);
        if ($answer == null) {
            abort(404);
        }

        $answer->shouldShow = $request->value === 'true';

        $answer->save();
    }
}
