<?php

namespace App\Http\Controllers\Accenture;

use App\Http\Controllers\Controller;
use App\VendorApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
}
