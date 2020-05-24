<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\VendorProfileQuestionResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile()
    {
        $vendor = auth()->user();

        $generalQuestions = $vendor->vendorProfileQuestions->filter(function ($question) {
            return $question->originalQuestion->page == 'general';
        });
        $economicQuestions = $vendor->vendorProfileQuestions->filter(function ($question) {
            return $question->originalQuestion->page == 'economic';
        });
        $legalQuestions = $vendor->vendorProfileQuestions->filter(function ($question) {
            return $question->originalQuestion->page == 'legal';
        });

        return view('vendorViews.profile', [
            'vendor' => $vendor,
            'generalQuestions' => $generalQuestions,
            'economicQuestions' => $economicQuestions,
            'legalQuestions' => $legalQuestions,
        ]);
    }

    public function homeProfileCreate()
    {
        $vendor = auth()->user();

        $generalQuestions = $vendor->vendorProfileQuestions->filter(function($question){
            return $question->originalQuestion->page == 'general';
        });
        $economicQuestions = $vendor->vendorProfileQuestions->filter(function($question){
            return $question->originalQuestion->page == 'economic';
        });
        $legalQuestions = $vendor->vendorProfileQuestions->filter(function($question){
            return $question->originalQuestion->page == 'legal';
        });

        return view('vendorViews.homeProfileCreate', [
            'vendor' => $vendor,
            'generalQuestions' => $generalQuestions,
            'economicQuestions' => $economicQuestions,
            'legalQuestions' => $legalQuestions,
        ]);
    }


    public function changeResponse(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'required',
        ]);

        $answer = VendorProfileQuestionResponse::find($request->changing);
        if ($answer == null) {
            abort(404);
        }

        if ($answer->vendor_id != auth()->id()) {
            abort(403);
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
