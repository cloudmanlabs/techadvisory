<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Practice;
use App\Project;

class HomeController extends Controller
{
    public function home()
    {
        $clientId = auth()->user()->id;

        // Get projects
        $openProjects = Project::openProjects()->where('client_id', $clientId);
        $preparationProjects = Project::preparationProjects()->where('client_id', $clientId)->filter(function ($project
        ) {
            return $project->step3SubmittedAccenture;
        });
        $oldProjects = Project::oldProjects()->where('client_id', $clientId);

        $practices = Practice::all()->pluck('name');

        return view('clientViews.home', [
            'practices' => $practices,

            'openProjects' => $openProjects,
            'preparationProjects' => $preparationProjects,
            'oldProjects' => $oldProjects,
        ]);
    }
}
