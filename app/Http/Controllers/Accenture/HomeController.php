<?php

namespace App\Http\Controllers\Accenture;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Practice;
use App\Project;
use App\User;

class HomeController extends Controller
{
    public function home()
    {
        // Get projects
        $openProjects = Project::openProjects()->get();
        $preparationProjects = Project::preparationProjects()->get();
        $oldProjects = Project::oldProjects()->get();

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
