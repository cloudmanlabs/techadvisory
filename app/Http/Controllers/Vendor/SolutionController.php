<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Practice;
use App\VendorSolution;
use App\VendorSolutionQuestionResponse;
use Illuminate\Http\Request;

class SolutionController extends Controller
{
    public function solutionHome()
    {
        return view('vendorViews.solutionsHome', [
            'solutions' => auth()->user()->vendorSolutions,
        ]);
    }

    public function createSolution(Request $request)
    {
        $solution = new VendorSolution([
            'vendor_id' => auth()->id(),
            'name' => 'New solution',
        ]);
        $solution->save();

        return redirect()->route('vendor.newSolutionSetUp', ['solution' => $solution, 'firstTime' => true]);
    }

    public function newSolutionSetUp(Request $request, VendorSolution $solution)
    {
        return view('vendorViews.newSolutionSetUp', [
            'solution' => $solution,
            'questions' => $solution->questions,

            'firstTime' => $request->firstTime ?? false,
        ]);
    }

    public function solutionEdit(VendorSolution $solution)
    {
        return view('vendorViews.solutionEdit', [
            'solution' => $solution,
            'questions' => $solution->questions,
        ]);
    }

    public function changeSolutionName(Request $request)
    {
        $request->validate([
            'solution_id' => 'required|numeric',
            'newName' => 'required|string',
        ]);

        $solution = VendorSolution::find($request->solution_id);
        if ($solution == null) {
            abort(404);
        }

        $solution->name = $request->newName;
        $solution->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function changeSolutionPractice(Request $request)
    {
        $request->validate([
            'solution_id' => 'required|numeric',
            'practice_id' => 'required|numeric',
        ]);

        $solution = VendorSolution::find($request->solution_id);
        if ($solution == null) {
            abort(404);
        }

        $practice = Practice::find($request->practice_id);
        if ($practice == null) {
            abort(404);
        }

        $solution->practice_id = $request->practice_id;
        $solution->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function changeSolutionSubpractice(Request $request)
    {
        $request->validate([
            'solution_id' => 'required|numeric',
            'subpractices' => 'required|array',
        ]);

        $solution = VendorSolution::find($request->solution_id);
        if ($solution == null) {
            abort(404);
        }

        $solution->subpractices()->sync($request->subpractices);
        $solution->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function changeResponse(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
        ]);

        $answer = VendorSolutionQuestionResponse::find($request->changing);
        if ($answer == null) {
            abort(404);
        }

        if ($answer->solution->vendor->id != auth()->id()) {
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
            'message' => 'nma',
        ]);
    }
}
