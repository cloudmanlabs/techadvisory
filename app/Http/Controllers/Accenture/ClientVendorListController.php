<?php

namespace App\Http\Controllers\Accenture;

use App\ClientProfileQuestionResponse;
use App\Exports\UserCredentialExport;
use App\Http\Controllers\Controller;
use App\SecurityLog;
use App\User;
use App\UserCredential;
use App\VendorProfileQuestionResponse;
use App\VendorSolution;
use App\VendorSolutionQuestionResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ClientVendorListController extends Controller
{
    public function createClientPost(Request $request)
    {
        $client = new User([
            'userType' => 'client',
            'name' => 'New client',
            'email' => Str::random() . '@example.com',
            'password' => Hash::make('password') // Doesn't matter because login with this email is turned off
        ]);
        $client->save();

        return redirect()->route('accenture.clientProfileEdit', ['client' => $client, 'firstTime' => true]);
    }


    public function clientList()
    {
        return view('accentureViews.clientList', [
            'clients' => User::clientUsers()->get()
        ]);
    }

    public function clientProfileView(User $client)
    {
        SecurityLog::createLog('User viewed Client with ID ' . $client->id);

        return view('accentureViews.clientProfileView', [
            'client' => $client,
            'questions' => $client->clientProfileQuestions,
        ]);
    }

    public function clientProfileEdit(Request $request, User $client)
    {
        SecurityLog::createLog('User viewed Client with ID ' . $client->id);

        return view('accentureViews.clientProfileEdit', [
            'client' => $client,
            'questions' => $client->clientProfileQuestions,

            'firstTime' => $request->firstTime ?? false
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

    public function changeClientEmail(Request $request)
    {
        $request->validate([
            'client_id' => 'required|numeric',
            'value' => 'required',
        ]);

        $client = User::find($request->client_id);
        if ($client == null || ! $client->isClient()) {
            abort(404);
        }

        $client->email = $request->value;
        $client->save();

        return response()->json([
            'status' => 200,
            'message' => 'nma'
        ]);
    }

    public function createFirstClientCredential(Request $request)
    {
        $request->validate([
            'client_id' => 'required|numeric',
            'email' => 'required',
            'name' => 'required',
        ]);

        $client = User::find($request->client_id);
        if ($client == null || ! $client->isClient()) {
            abort(404);
        }

        $credential = new UserCredential([
            'email' => $request->email,
            'name' => $request->name
        ]);
        $client->credentials()->save($credential);

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
            'email' => Str::random() . '@example.com',
            'password' => Hash::make('password')
        ]);
        $vendor->save();

        return redirect()->route('accenture.vendorProfileEdit', ['vendor' => $vendor, 'firstTime' => true]);
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

        SecurityLog::createLog('User viewed Vendor with ID ' . $vendor->id);

        return view('accentureViews.vendorProfileView', [
            'vendor' => $vendor,
            'generalQuestions' => $generalQuestions,
            'economicQuestions' => $economicQuestions,
            'legalQuestions' => $legalQuestions,
        ]);
    }

    public function vendorProfileEdit(Request $request, User $vendor)
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

        SecurityLog::createLog('User viewed Vendor with ID ' . $vendor->id);

        return view('accentureViews.vendorProfileEdit', [
            'vendor' => $vendor,
            'generalQuestions' => $generalQuestions,
            'economicQuestions' => $economicQuestions,
            'legalQuestions' => $legalQuestions,

            'firstTime' => $request->firstTime ?? false
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
    public function changeVendorEmail(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|numeric',
            'value' => 'required',
        ]);

        $client = User::find($request->vendor_id);
        if ($client == null || !$client->isVendor()) {
            abort(404);
        }

        $client->email = $request->value;
        $client->save();

        return response()->json([
            'status' => 200,
            'message' => 'nma'
        ]);
    }

    public function createFirstVendorCredential(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|numeric',
            'email' => 'required',
            'name' => 'required',
        ]);

        $vendor = User::find($request->vendor_id);
        if ($vendor == null || !$vendor->isVendor()) {
            abort(404);
        }

        $credential = new UserCredential([
            'email' => $request->email,
            'name' => $request->name
        ]);
        $vendor->credentials()->save($credential);

        return response()->json([
            'status' => 200,
            'message' => 'nma'
        ]);
    }


    public function vendorValidateResponses(User $vendor)
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

        return view('accentureViews.vendorValidateResponses', [
            'vendor' => $vendor,
            'generalQuestions' => $generalQuestions,
            'economicQuestions' => $economicQuestions,
            'legalQuestions' => $legalQuestions,
        ]);
    }

    public function setValidated(Request $request, User $vendor)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'required',
        ]);

        $answer = VendorProfileQuestionResponse::find($request->changing);
        if ($answer == null) {
            abort(404);
        }

        $answer->shouldShow = $request->value === 'true';

        $answer->save();
    }

    public function submitVendor(User $vendor)
    {
        $vendor->hasFinishedSetup = true;
        $vendor->save();

        return redirect()->route('accenture.vendorList');
    }





    public function vendorSolution(VendorSolution $solution)
    {
        SecurityLog::createLog('User viewed Solution with ID ' . $solution->id);

        return view('accentureViews.vendorSolution', [
            'solution' => $solution,
            'questions' => $solution->questions
        ]);
    }

    public function vendorSolutionEdit(VendorSolution $solution)
    {
        SecurityLog::createLog('User viewed Solution with ID ' . $solution->id);

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







    public function exportCredentials(User $user)
    {
        $export = new UserCredentialExport($user);

        return Excel::download($export, 'credentials.xlsx');
    }
}
