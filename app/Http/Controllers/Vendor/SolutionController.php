<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\VendorSolution;
use App\VendorSolutionQuestionResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SolutionController extends Controller
{
    public function solutionHome()
    {
        return view('vendorViews.solutionsHome',[
            'solutions' => auth()->user()->vendorSolutions
        ]);
    }

    public function createSolution(Request $request)
    {
        $solution = new VendorSolution([
            'vendor_id' => auth()->id(),
            'name' => 'New solution'
        ]);
        $solution->save();

        return redirect()->route('vendor.newSolutionSetUp', ['solution' => $solution]);
    }

    public function newSolutionSetUp(VendorSolution $solution)
    {
        return view('vendorViews.newSolutionSetUp', [
            'solution' => $solution
        ]);
    }

    public function solutionEdit(VendorSolution $solution)
    {
        return view('vendorViews.solutionEdit', [
            'solution' => $solution
        ]);
    }

    public function changeResponse(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'required',
        ]);

        $answer = VendorSolutionQuestionResponse::find($request->changing);
        if ($answer == null) {
            abort(404);
        }

        Log::debug($answer->solution->vendor);
        Log::debug(auth()->id());
        if ($answer->solution->vendor->id != auth()->id()) {
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
}
