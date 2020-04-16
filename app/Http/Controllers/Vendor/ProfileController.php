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
        return view('vendorViews.profile', [
            'vendor' => $vendor,
            'questions' => $vendor->vendorProfileQuestions
        ]);
    }

    public function homeProfileCreate()
    {
        $vendor = auth()->user();
        return view('vendorViews.homeProfileCreate', [
            'vendor' => $vendor,
            'questions' => $vendor->vendorProfileQuestions
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

        return redirect()->route('vendor.home');
    }
}
