<?php

namespace App\Http\Controllers\Accenture;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use App\User;

class ProjectController extends Controller
{
    public function home(Project $project)
    {
        return view('accentureViews.projectHome', [
            'project' => $project
        ]);
    }

    public function view(Project $project)
    {
        return view('accentureViews.projectView', [
            'project' => $project
        ]);
    }

    public function edit(Project $project)
    {
        return view('accentureViews.projectEdit', [
            'project' => $project
        ]);
    }

    public function valueTargeting(Project $project)
    {
        if (!$project->hasValueTargeting) {
            abort(404);
        }

        return view('accentureViews.projectValueTargeting', [
            'project' => $project
        ]);
    }

    public function orals(Project $project)
    {
        if(! $project->hasOrals){
            abort(404);
        }

        return view('accentureViews.projectOrals', [
            'project' => $project
        ]);
    }

    public function conclusions(Project $project)
    {
        return view('accentureViews.projectConclusions', [
            'project' => $project
        ]);
    }



    public function benchmark(Project $project)
    {
        return view('accentureViews.projectBenchmark', [
            'project' => $project
        ]);
    }

    public function benchmarkFitgap(Project $project)
    {
        return view('accentureViews.projectBenchmarkFitgap', [
            'project' => $project
        ]);
    }

    public function benchmarkVendor(Project $project)
    {
        return view('accentureViews.projectBenchmarkVendor', [
            'project' => $project
        ]);
    }

    public function benchmarkExperience(Project $project)
    {
        return view('accentureViews.projectBenchmarkExperience', [
            'project' => $project
        ]);
    }

    public function benchmarkInnovation(Project $project)
    {
        return view('accentureViews.projectBenchmarkInnovation', [
            'project' => $project
        ]);
    }

    public function benchmarkImplementation(Project $project)
    {
        return view('accentureViews.projectBenchmarkImplementation', [
            'project' => $project
        ]);
    }
}
