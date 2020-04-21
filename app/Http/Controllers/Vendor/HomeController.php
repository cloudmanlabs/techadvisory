<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Practice;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        /** @var User $vendor */
        $vendor = auth()->user();

        $practices = Practice::all()->pluck('name');

        $invitationProjects = $vendor->vendorAppliedProjects('invitation')->get();
        $startedProjects = $vendor->vendorAppliedProjects('started')->get();
        $submittedProjects = $vendor->vendorAppliedProjects('submitted')->get();
        $rejectedProjects = $vendor->vendorAppliedProjects('rejected')->get();

        return view('vendorViews.home', [
            'practices' => $practices,

            'invitationProjects' => $invitationProjects,
            'startedProjects' => $startedProjects,
            'submittedProjects' => $submittedProjects,
            'rejectedProjects' => $rejectedProjects,
        ]);
    }
}
