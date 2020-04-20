<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\VendorSolution;
use Illuminate\Http\Request;

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
}
