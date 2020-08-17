<?php

namespace App\Http\Controllers\Accenture;

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

        // feature 2.4: get projects but filtered by region
        $myRegion = auth()->user()->region;
        $openProjects = Project::openProjectsFromMyRegion($myRegion);
        $preparationProjects = Project::preparationProjectsFromMyRegion($myRegion);
        $oldProjects = Project::oldProjectsFromMyRegion($myRegion);

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
