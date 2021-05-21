<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Practice;
use App\User;
use App\UserCredential;

class HomeController extends Controller
{
    public function home()
    {
        /** @var User $vendor */
        $vendor = auth()->user();
        $credential_id = session('credential_id');

        $practices = Practice::all()->pluck('name');

        $visibleProjects = [];

        if (UserCredential::find($credential_id)->vendor_user_type == 2) {
          $visibleProjects = UserCredential::find($credential_id)->visibleProjects()->pluck('project_id')->toArray();
        }

        $invitationProjects = $vendor->vendorAppliedProjects(['invitation'])->get()->filter(function ($project) {
            return $project->currentPhase != 'preparation';
        });
        $startedProjects = $vendor->vendorAppliedProjects(['applicating'])->get()->filter(function ($project) {
            return $project->currentPhase != 'preparation';
        });
        $submittedProjects = $vendor->vendorAppliedProjects([
            'pendingEvaluation', 'evaluated', 'submitted',
        ])->get()->filter(function ($project) {
            return $project->currentPhase != 'preparation';
        });
        $rejectedProjects = $vendor->vendorAppliedProjects(['rejected'])->get();

        return view('vendorViews.home', [
            'practices' => $practices,
            'credential_id' => $credential_id,

            'invitationProjects' => $invitationProjects,
            'startedProjects' => $startedProjects,
            'submittedProjects' => $submittedProjects,
            'rejectedProjects' => $rejectedProjects,
            'visibleProjects' => $visibleProjects
        ]);
    }
}
