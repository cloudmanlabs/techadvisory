<?php

namespace App\Http\Controllers;

use App\GeneralInfoQuestionResponse;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GeneralInfoQuestionController extends Controller
{
    public function changeResponse(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'required',
        ]);

        $answer = GeneralInfoQuestionResponse::find($request->changing);
        if ($answer == null) {
            abort(404);
        }

        if($answer->originalQuestion->type == 'boolean'){
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
}
