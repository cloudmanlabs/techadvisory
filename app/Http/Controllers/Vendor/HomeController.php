<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Practice;
use App\User;

class HomeController extends Controller
{
    public function home()
    {
        /** @var User $vendor */
        $vendor = auth()->user();

        $practices = Practice::all()->pluck('name');

        $invitationProjects = $vendor->vendorAppliedProjects(['invitation'])->get()->filter(function ($project) {
            return $project->currentPhase == 'open';
        });
        $startedProjects = $vendor->vendorAppliedProjects(['applicating'])->get()->filter(function ($project) {
            return $project->currentPhase == 'open';
        });
        $submittedProjects = $vendor->vendorAppliedProjects([
            'pendingEvaluation', 'evaluated', 'submitted',
        ])->get()->filter(function ($project) {
            return $project->currentPhase == 'open';
        });
        $rejectedProjects = $vendor->vendorAppliedProjects(['rejected'])->get();

        return view('vendorViews.home', [
            'practices' => $practices,

            'invitationProjects' => $invitationProjects,
            'startedProjects' => $startedProjects,
            'submittedProjects' => $submittedProjects,
            'rejectedProjects' => $rejectedProjects,
        ]);
    }
}
