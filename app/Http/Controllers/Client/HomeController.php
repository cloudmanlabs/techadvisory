<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Practice;
use App\Project;
use App\User;

class HomeController extends Controller
{
    public function home()
    {
        $clientId = auth()->user()->id;

        // Get projects
        $openProjects = Project::openProjects()->where('client_id', $clientId)->get();
        $preparationProjects = Project::preparationProjects()->where('client_id', $clientId)->get()->filter(function ($project) {
            return $project->step3SubmittedAccenture;
        });
        $oldProjects = Project::oldProjects()->where('client_id', $clientId)->get();

        $practices = Practice::all()->pluck('name');

        return view('clientViews.home', [
            'practices' => $practices,

            'openProjects' => $openProjects,
            'preparationProjects' => $preparationProjects,
            'oldProjects' => $oldProjects,
        ]);
    }
}
