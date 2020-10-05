<?php


namespace App\Http\Controllers\Accenture;


use App\Http\Controllers\Controller;
use App\Practice;
use App\Project;
use App\User;
use App\VendorSolution;
use Illuminate\Http\Request;

class BenchmarkController extends Controller
{

    // Overview Controllers *****************************************************************************

    public function overviewGeneral(Request $request)
    {
        // Data for selects.
        $regions = collect(config('arrays.regions'));
        $years = collect(range(2017, intval(date('Y'))))->map(function ($year) {
            return (object)[
                'year' => $year,
                'projectCount' => Project::all()->filter(function ($project) use ($year) {
                    return $project->created_at->year == $year;
                })->count(),
            ];
        });

        // Data for charts without filters.
        $practices = Practice::all();
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();
        $clients = User::clientUsers()->where('hasFinishedSetup', true)->get();
        $industries = collect(config('arrays.industryExperience'))->map(function ($industry) {
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
        $yearToFilter = $request->input('year');
        if (!empty($yearToFilter)) {
            $yearToFilter = intval($yearToFilter);
        }

        return View('accentureViews.benchmarkOverview', [
            'regions' => $regions,
            'years' => $years,
            'practices' => $practices,
            'vendors' => $vendors,
            'clients' => $clients,
            'industries' => $industries,
        ]);
    }

    public function overviewHistorical()
    {
        // Data for selects.
        $regions = collect(config('arrays.regions'));
        $industries = collect(config('arrays.industryExperience'));
        $practices = Practice::all();

        // Data for charts without filters.
        $years = collect(range(2017, intval(date('Y'))))->map(function ($year) {
            return (object)[
                'year' => $year,
                'projectCount' => Project::all()->filter(function ($project) use ($year) {
                    return $project->created_at->year == $year;
                })->count(),
            ];
        });

        return View('accentureViews.benchmarkOverviewHistorical', [
            'regions' => $regions,
            'industries' => $industries,
            'practices' => $practices,
            'years' => $years,

        ]);
    }

    public function overviewVendor()
    {
        // Data for graphs.
        $practices = Practice::all()->map(function (Practice $practice) {
            return (object)[
                'name' => $practice->name,
                'count' => VendorSolution::all()
                    ->filter(function (VendorSolution $solution) use ($practice) {
                        if ($solution->practice == null) return false;

                        return $solution->practice->is($practice);
                    })
                    ->count(),
            ];
        });
        $industries = collect(config('arrays.industryExperience'))->map(function ($industry) {
            return (object)[
                'name' => $industry,
                'count' => User::vendorUsers()->get()->filter(function (User $vendor) use ($industry) {
                    return $vendor->getVendorResponse('vendorIndustry') == $industry;
                })->count(),
            ];
        });
        $regions = collect(config('arrays.regions'))->map(function ($region) {
            return (object)[
                'name' => $region,
                'count' => User::vendorUsers()->get()->filter(function (User $vendor) use ($region) {
                    return in_array($region, json_decode($vendor->getVendorResponse('vendorRegions')) ?? []);
                })->count(),
            ];
        });

        return View('accentureViews.benchmarkOverviewVendor', [
            'practices' => $practices,
            'industries' => $industries,
            'regions' => $regions,
        ]);
    }

    // Project results Controllers ***************************************************************************

    public function projectResultsOverall()
    {
        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $projectsByYears = collect(range(2017, intval(date('Y'))))->map(function ($year) {
            return (object)[
                'year' => $year,
                'projectCount' => Project::all()->filter(function ($project) use ($year) {
                    return $project->created_at->year == $year;
                })->count(),
            ];
        });
        $industries = collect(config('arrays.industryExperience'));
        $regions = collect(config('arrays.regions'));

        // data for informative panels (counts)
        $totalVendors = User::vendorUsers()->where('hasFinishedSetup', true)->count();
        $totalClients = User::clientUsers()->where('hasFinishedSetup', true)->count();
        $totalProjects = Project::all()->count();
        $totalSolutions = 0;

        // Data for charts
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();
        $vendorScores = User::bestVendorsOverallScore(5);

        return View('accentureViews.benchmarkProjectResults', [
            'practices' => $practices,
            'subpractices' => $subpractices,
            'projectsByYears' => $projectsByYears,
            'industries' => $industries,
            'regions' => $regions,
            'totalVendors' => $totalVendors,
            'totalClients' => $totalClients,
            'totalProjects' => $totalProjects,
            'totalSolutions' => $totalSolutions,
            'vendors' => $vendors,
        ]);
    }

    public function projectResultsFitgap()
    {
        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $projectsByYears = collect(range(2017, intval(date('Y'))))->map(function ($year) {
            return (object)[
                'year' => $year,
                'projectCount' => Project::all()->filter(function ($project) use ($year) {
                    return $project->created_at->year == $year;
                })->count(),
            ];
        });
        $industries = collect(config('arrays.industryExperience'));
        $subIndustries = [];
        $regions = collect(config('arrays.regions'));

        // Data for charts

        return View('accentureViews.benchmarkProjectResultsFitgap', [
            'practices' => $practices,
            'subpractices' => $subpractices,
            'projectsByYears' => $projectsByYears,
            'industries' => $industries,
            'subIndustries' => $subIndustries,
            'regions' => $regions,
        ]);

    }

    public function projectResultsVendor()
    {
        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $projectsByYears = collect(range(2017, intval(date('Y'))))->map(function ($year) {
            return (object)[
                'year' => $year,
                'projectCount' => Project::all()->filter(function ($project) use ($year) {
                    return $project->created_at->year == $year;
                })->count(),
            ];
        });
        $industries = collect(config('arrays.industryExperience'));
        $subIndustries = [];
        $regions = collect(config('arrays.regions'));

        // Data for charts

        return View('accentureViews.benchmarkProjectResultsVendor', [
            'practices' => $practices,
            'subpractices' => $subpractices,
            'projectsByYears' => $projectsByYears,
            'industries' => $industries,
            'subIndustries' => $subIndustries,
            'regions' => $regions,
        ]);
    }

    public function projectResultsExperience()
    {
        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $projectsByYears = collect(range(2017, intval(date('Y'))))->map(function ($year) {
            return (object)[
                'year' => $year,
                'projectCount' => Project::all()->filter(function ($project) use ($year) {
                    return $project->created_at->year == $year;
                })->count(),
            ];
        });
        $industries = collect(config('arrays.industryExperience'));
        $subIndustries = [];
        $regions = collect(config('arrays.regions'));

        // Data for charts

        return View('accentureViews.benchmarkProjectResultsExperience', [
            'practices' => $practices,
            'subpractices' => $subpractices,
            'projectsByYears' => $projectsByYears,
            'industries' => $industries,
            'subIndustries' => $subIndustries,
            'regions' => $regions,
        ]);
    }

    public function projectResultsInnovation()
    {
        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $projectsByYears = collect(range(2017, intval(date('Y'))))->map(function ($year) {
            return (object)[
                'year' => $year,
                'projectCount' => Project::all()->filter(function ($project) use ($year) {
                    return $project->created_at->year == $year;
                })->count(),
            ];
        });
        $industries = collect(config('arrays.industryExperience'));
        $subIndustries = [];
        $regions = collect(config('arrays.regions'));

        // Data for charts

        return View('accentureViews.benchmarkProjectResultsInnovation', [
            'practices' => $practices,
            'subpractices' => $subpractices,
            'projectsByYears' => $projectsByYears,
            'industries' => $industries,
            'subIndustries' => $subIndustries,
            'regions' => $regions,
        ]);
    }

    public function projectResultsImplementation()
    {
        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $projectsByYears = collect(range(2017, intval(date('Y'))))->map(function ($year) {
            return (object)[
                'year' => $year,
                'projectCount' => Project::all()->filter(function ($project) use ($year) {
                    return $project->created_at->year == $year;
                })->count(),
            ];
        });
        $industries = collect(config('arrays.industryExperience'));
        $subIndustries = [];
        $regions = collect(config('arrays.regions'));

        // Data for charts

        return View('accentureViews.benchmarkProjectResultsImplementation', [
            'practices' => $practices,
            'subpractices' => $subpractices,
            'projectsByYears' => $projectsByYears,
            'industries' => $industries,
            'subIndustries' => $subIndustries,
            'regions' => $regions,
        ]);
    }

}
