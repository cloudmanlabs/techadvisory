<?php


namespace App\Http\Controllers\Accenture;


use App\Http\Controllers\Controller;
use App\Practice;
use App\Project;
use App\User;
use Illuminate\Http\Request;

class BenchmarkController extends Controller
{

    public function overviewGeneral(Request $request)
    {
        // Data for selects.
        $regions = collect(config('arrays.regions'));

        // Data for charts without filters.
        $practices = Practice::all();
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();
        $clients = User::clientUsers()->where('hasFinishedSetup', true)->get();
        $industries = collect(config('arrays.industryExperience'))
            ->map(function ($industry) {
                return (object)[
                    'name' => $industry,
                    'projectCount' => Project::all()
                        ->filter(function (Project $project) use ($industry) {
                            return $project->industry == $industry;
                        })
                        ->count()
                ];
            });

        // Applying filters.
        $regionToFilter = $request->input('region');
        if (!empty($regionToFilter)) {

        }

        return View('accentureViews.benchmarkOverview', [
            'regions' => $regions,
            'practices' => $practices,
            'vendors' => $vendors,
            'clients' => $clients,
            'industries' => $industries,
        ]);
    }

    public function overviewHistorical()
    {

    }

    public function overviewVendor()
    {

    }

    public function projectResultsOverall()
    {
        $example = 2;

        return View('accentureViews.benchmarkProjectResults', [
            'example' => $example,
        ]);
    }

    public function projectResultsFitgap()
    {

    }

    public function projectResultsVendor()
    {

    }

}
