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
        $myOwner_id = auth()->user()->owner()->id;
        if(empty($myOwner_id)){
            // No region filter
            $openProjects = Project::openProjects();
            $preparationProjects = Project::preparationProjects();
            $oldProjects = Project::oldProjects();
        }else{
            // filter by his region
            $openProjects = Project::projectsFromOwner($myOwner_id, 'open');
            $preparationProjects = Project::projectsFromOwner($myOwner_id, 'preparation');
            $oldProjects = Project::projectsFromOwner($myOwner_id, 'old');
        }

        $practices = Practice::all()->pluck('name');
        $clients = User::clientUsers()->pluck('name');

        return view('accentureViews.home', [
            'practices' => $practices,
            'clients' => $clients,

            'openProjects' => $openProjects,
            'preparationProjects' => $preparationProjects,
            'oldProjects' => $oldProjects,
        ]);
    }
}
