<?php

namespace App\Http\Controllers\Accenture;

use App\Http\Controllers\Controller;
use App\Practice;
use App\User;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function vendor()
    {
        return view('accentureViews.analysisVendor', [
            'practices' => Practice::all(),
            'vendors' => User::vendorUsers()->where('hasFinishedSetup', true)->get()
        ]);
    }

    public function client()
    {
        return view('accentureViews.analysisClient', [
            'practices' => Practice::all(),
            'vendors' => User::vendorUsers()->where('hasFinishedSetup', true)->get()
        ]);
    }
}
