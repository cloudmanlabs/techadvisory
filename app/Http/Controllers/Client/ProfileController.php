<?php

namespace App\Http\Controllers\Client;

use App\ClientProfileQuestionResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Practice;
use App\Project;
use App\User;

class ProfileController extends Controller
{
    public function profile()
    {
        $client = auth()->user();
        return view('clientViews.profile', [
            'client' => $client,
            'questions' => $client->clientProfileQuestions
        ]);
    }

    public function homeProfileCreate()
    {
        $client = auth()->user();
        return view('clientViews.homeProfileCreate', [
            'client' => $client,
            'questions' => $client->clientProfileQuestions
        ]);
    }

    public function changeResponse(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'required',
        ]);

        $answer = ClientProfileQuestionResponse::find($request->changing);
        if ($answer == null) {
            abort(404);
        }

        if($answer->client_id != auth()->id()){
            abort(403);
        }

        if ($answer->original->type == 'boolean') {
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

    public function submitProfile(Request $request)
    {
        $client = auth()->user();
        $client->hasFinishedSetup = true;
        $client->save();

        return redirect()->route('client.home');
    }
}
