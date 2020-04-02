<?php

namespace App\Http\Controllers\Accenture;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use App\User;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function createPost(Request $request)
    {
        $project = new Project();
        $project->save();

        return redirect()->route('accenture.newProjectSetUp', ['project' => $project]);
    }

    public function newProjectSetUp(Project $project)
    {
        $clients = User::clientUsers()->get();

        return view('accentureViews.newProjectSetUp', [
            'project' => $project,
            'clients' => $clients
        ]);
    }

    public function changeProjectName (Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'newName' => 'required|string'
        ]);

        $project = Project::find($request->project_id);
        if($project == null){
            abourt(404);
        }

        $project->name = $request->newName;
        $project->save();
    }

    public function assignClient(Request $request)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'client_id' => 'required|numeric'
        ]);

        $project = Project::find($request->project_id);
        if ($project == null) {
            abourt(404);
        }

        $project->client_id = $request->client_id;
        $project->save();
    }



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
