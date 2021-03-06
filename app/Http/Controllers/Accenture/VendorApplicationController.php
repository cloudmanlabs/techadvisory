<?php

namespace App\Http\Controllers\Accenture;

use App\Http\Controllers\Controller;
use App\VendorApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorApplicationController extends Controller
{
    public function changeInvitedToOrals(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'required',
        ]);

        $application = VendorApplication::find($request->changing);
        if ($application == null) {
            abort(404);
        }

        $application->invitedToOrals = $request->value === 'true';
        $application->save();
    }

    public function changeOralsCompleted(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'required',
        ]);

        $application = VendorApplication::find($request->changing);
        if ($application == null) {
            abort(404);
        }

        $application->oralsCompleted = $request->value === 'true';

        $application->save();
    }

    public function updateSolutionsUsed(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'array',
        ]);

        $application = VendorApplication::find($request->changing);
        if ($application == null) {
            abort(404);
        }

        $application->solutionsUsed = $request->value;
        $application->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }


    public function updateDeliverables(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'array',
        ]);

        $application = VendorApplication::find($request->changing);
        if ($application == null) {
            abort(404);
        }

        $application->deliverables = $request->value;
        $application->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function updateRaci(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'array',
        ]);

        $application = VendorApplication::find($request->changing);
        if ($application == null) {
            abort(404);
        }

        $application->raciMatrix = $request->value;
        $application->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function updateStaffingCost(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'array',
        ]);

        $application = VendorApplication::find($request->changing);
        if ($application == null) {
            abort(404);
        }

        $application->staffingCost = $request->value;
        $application->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function updateTravelCost(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'array',
        ]);

        $application = VendorApplication::find($request->changing);
        if ($application == null) {
            abort(404);
        }

        $application->travelCost = $request->value;
        $application->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function updateAdditionalCost(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'array',
        ]);

        $application = VendorApplication::find($request->changing);
        if ($application == null) {
            abort(404);
        }

        $application->additionalCost = $request->value;
        $application->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function updateEstimate5Years(Request $request)
    {
        $request->validate([
            'changing' => 'required|numeric',
            'value' => 'array',
            'year0' => 'numeric',
        ]);

        $application = VendorApplication::find($request->changing);
        if ($application == null) {
            abort(404);
        }

        $application->estimate5Years = $request->value;
        $application->estimate5YearsYear0 = $request->year0;
        $application->save();


        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function updateNonBindingImplementation(Request $request)
    {
        $request->validate([
            'application_id' => 'required|numeric',
            'changing' => 'required|string',
            'value' => '',
        ]);

        $availableFields = [
            'overallImplementationMin',
            'overallImplementationMax',
            'staffingCostNonBinding',
            'staffingCostNonBindingComments',
            'travelCostNonBinding',
            'travelCostNonBindingComments',
            'additionalCostNonBinding',
            'additionalCostNonBindingComments',
            'averageYearlyCostMin',
            'averageYearlyCostMax',
            'totalRunCostMin',
            'totalRunCostMax',

            'pricingModelResponse',
            'detailedBreakdownResponse',
        ];

        $application = VendorApplication::find($request->application_id);
        if ($application == null) {
            abort(404);
        }

        if (!in_array($request->changing, $availableFields)) {
            abort(404);
        }

        $application->{$request->changing} = $request->value;
        $application->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function updateRunFile(Request $request)
    {
        $request->validate([
            'image' => 'required|file',
            'changing' => 'required|string',
        ]);

        $availableFields = [
            'pricingModelUpload',
            'detailedBreakdownUpload',
        ];

        $application = VendorApplication::find($request->application_id);
        if ($application == null) {
            abort(404);
        }

        if (!in_array($request->changing, $availableFields)) {
            abort(404);
        }

        $path = Storage::disk('public')->putFile('questionFiles', $request->image);

        $application->{$request->changing} = $path;
        $application->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }

    public function updateImplementationScores(Request $request)
    {
        $request->validate([
            'application_id' => 'required|numeric',
            'changing' => 'required|string',
            'value' => '',
        ]);

        $availableFields = [
            'additionalCostScore',
            'deliverablesScore',
            'estimate5YearsScore',
            'nonBindingEstimate5YearsScore',
            'overallCostScore',
            'raciMatrixScore',
            'staffingCostScore',
            'travelCostScore',
        ];

        $application = VendorApplication::find($request->application_id);
        if ($application == null) {
            abort(404);
        }

        if (!in_array($request->changing, $availableFields)) {
            abort(404);
        }

        $application->{$request->changing} = $request->value;
        $application->save();

        return \response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
    }
}
