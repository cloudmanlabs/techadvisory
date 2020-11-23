<?php

namespace App\Http\Controllers\Accenture;

use App\Owner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Practice;
use App\Project;
use App\User;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function home()
    {

        if (empty(auth()->user()->owner())) {
            // No region filter

            $openProjects = Project::openProjects();
            $preparationProjects = Project::preparationProjects();
            $oldProjects = Project::oldProjects();
        } else {
            // filter by his region
            $myOwnerId = auth()->user()->owner()->id;
            $openProjects = Project::projectsFromOwner($myOwnerId, 'open');
            $preparationProjects = Project::projectsFromOwner($myOwnerId, 'preparation');
            $oldProjects = Project::projectsFromOwner($myOwnerId, 'old');
        }
/*        $openProjects = Project::openProjects();
        $preparationProjects = Project::preparationProjects();
        $oldProjects = Project::oldProjects();*/

        $practices = Practice::all()->pluck('name');
        $clients = User::clientUsers()->pluck('name');
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->pluck('name');

        return view('accentureViews.home', [
            'practices' => $practices,
            'clients' => $clients,
            'vendors' => $vendors,

            'openProjects' => $openProjects,
            'preparationProjects' => $preparationProjects,
            'oldProjects' => $oldProjects,
        ]);
    }
}
