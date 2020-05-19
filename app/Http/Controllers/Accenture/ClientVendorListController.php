<?php

namespace App\Http\Controllers\Accenture;

use App\ClientProfileQuestionResponse;
use App\Http\Controllers\Controller;
use App\User;
use App\VendorProfileQuestionResponse;
use App\VendorSolution;
use App\VendorSolutionQuestionResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientVendorListController extends Controller
{
    public function createClientPost(Request $request)
    {
        $client = new User([
            'userType' => 'client',
            'name' => 'New client',
            'email' => 'newUser@example.com',
            'password' => Hash::make('password')
        ]);
        $client->save();

        return redirect()->route('accenture.clientProfileEdit', ['client' => $client]);
    }


    public function clientList()
    {
        return view('accentureViews.clientList', [
            'clients' => User::clientUsers()->get()
        ]);
    }

    public function clientProfileView(User $client)
    {
        return view('accentureViews.clientProfileView', [
            'client' => $client,
            'questions' => $client->clientProfileQuestions
        ]);
    }

    public function clientProfileEdit(User $client)
    {
        return view('accentureViews.clientProfileEdit', [
            'client' => $client,
            'questions' => $client->clientProfileQuestions
        ]);
    }

    public function changeClientProfileResponse(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'required',
        ]);

        $answer = ClientProfileQuestionResponse::find($request->changing);
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

    public function changeClientName(Request $request)
    {
        $request->validate([
            'client_id' => 'required|numeric',
            'value' => 'required',
        ]);

        $client = User::find($request->client_id);
        if ($client == null || ! $client->isClient()) {
            abort(404);
        }

        $client->name = $request->value;
        $client->save();

        return response()->json([
            'status' => 200,
            'message' => 'nma'
        ]);
    }



    public function createVendorPost(Request $request)
    {
        $vendor = new User([
            'userType' => 'vendor',
            'name' => 'New client',
            'email' => 'newUser@example.com',
            'password' => Hash::make('password')
        ]);
        $vendor->save();

        return redirect()->route('accenture.vendorProfileView', ['vendor' => $vendor]);
    }


    public function vendorList()
    {
        return view('accentureViews.vendorList', [
            'vendors' => User::vendorUsers()->where('hasFinishedSetup', true)->get(),
            'vendorsPendingValidation' => User::vendorUsers()->where('hasFinishedSetup', false)->get(),
            'vendorSolutions' => VendorSolution::all()
        ]);
    }

    public function vendorProfileView(User $vendor)
    {
        $generalQuestions = $vendor->vendorProfileQuestions->filter(function ($question) {
            return $question->originalQuestion->page == 'general';
        });
        $economicQuestions = $vendor->vendorProfileQuestions->filter(function ($question) {
            return $question->originalQuestion->page == 'economic';
        });
        $legalQuestions = $vendor->vendorProfileQuestions->filter(function ($question) {
            return $question->originalQuestion->page == 'legal';
        });

        return view('accentureViews.vendorProfileView', [
            'vendor' => $vendor,
            'generalQuestions' => $generalQuestions,
            'economicQuestions' => $economicQuestions,
            'legalQuestions' => $legalQuestions,
        ]);
    }

    public function vendorProfileEdit(User $vendor)
    {
        $generalQuestions = $vendor->vendorProfileQuestions->filter(function ($question) {
            return $question->originalQuestion->page == 'general';
        });
        $economicQuestions = $vendor->vendorProfileQuestions->filter(function ($question) {
            return $question->originalQuestion->page == 'economic';
        });
        $legalQuestions = $vendor->vendorProfileQuestions->filter(function ($question) {
            return $question->originalQuestion->page == 'legal';
        });

        return view('accentureViews.vendorProfileEdit', [
            'vendor' => $vendor,
            'generalQuestions' => $generalQuestions,
            'economicQuestions' => $economicQuestions,
            'legalQuestions' => $legalQuestions,
        ]);
    }

    public function changeVendorProfileResponse(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'required',
        ]);

        $answer = VendorProfileQuestionResponse::find($request->changing);
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

    public function changeVendorName(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|numeric',
            'value' => 'required',
        ]);

        $client = User::find($request->vendor_id);
        if ($client == null || !$client->isVendor()) {
            abort(404);
        }

        $client->name = $request->value;
        $client->save();

        return response()->json([
            'status' => 200,
            'message' => 'nma'
        ]);
    }






    public function vendorSolution(VendorSolution $solution)
    {
        return view('accentureViews.vendorSolution', [
            'solution' => $solution,
            'questions' => $solution->questions
        ]);
    }

    public function vendorSolutionEdit(VendorSolution $solution)
    {
        return view('accentureViews.vendorSolutionEdit', [
            'solution' => $solution,
            'questions' => $solution->questions
        ]);
    }


    public function changeSolutionName(Request $request)
    {
        $request->validate([
            'solution_id' => 'required|numeric',
            'newName' => 'required|string'
        ]);

        $solution = VendorSolution::find($request->solution_id);
        if ($solution == null) {
            abort(404);
        }

        $solution->name = $request->newName;
        $solution->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success'
        ]);
    }

    public function changeSolutionResponse(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'required',
        ]);

        $answer = VendorSolutionQuestionResponse::find($request->changing);
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
}
