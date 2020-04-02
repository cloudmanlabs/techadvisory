<?php

namespace App\Http\Controllers\Client;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function home(Project $project)
    {
        return view('clientViews.projectHome', [
            'project' => $project
        ]);
    }

    // public function edit(Project $project)
    // {
    //     return view('clientViews.projectEdit', [
    //         'project' => $project
    //     ]);
    // }

    public function view(Project $project)
    {
        return view('clientViews.projectView', [
            'project' => $project
        ]);
    }

    public function valueTargeting(Project $project)
    {
        if (!$project->hasValueTargeting) {
            abort(404);
        }

        return view('clientViews.projectValueTargeting', [
            'project' => $project
        ]);
    }

    public function orals(Project $project)
    {
        if(! $project->hasOrals){
            abort(404);
        }

        return view('clientViews.projectOrals', [
            'project' => $project
        ]);
    }

    public function conclusions(Project $project)
    {
        return view('clientViews.projectConclusions', [
            'project' => $project
        ]);
    }

    public function benchmark(Project $project)
    {
        return view('clientViews.projectBenchmark', [
            'project' => $project
        ]);
    }

    public function benchmarkFitgap(Project $project)
    {
        return view('clientViews.projectBenchmarkFitgap', [
            'project' => $project
        ]);
    }

    public function benchmarkVendor(Project $project)
    {
        return view('clientViews.projectBenchmarkVendor', [
            'project' => $project
        ]);
    }

    public function benchmarkExperience(Project $project)
    {
        return view('clientViews.projectBenchmarkExperience', [
            'project' => $project
        ]);
    }

    public function benchmarkInnovation(Project $project)
    {
        return view('clientViews.projectBenchmarkInnovation', [
            'project' => $project
        ]);
    }

    public function benchmarkImplementation(Project $project)
    {
        return view('clientViews.projectBenchmarkImplementation', [
            'project' => $project
        ]);
    }

}
