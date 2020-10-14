<?php


namespace App\Http\Controllers\Accenture;


use App\Http\Controllers\Controller;
use App\Practice;
use App\Project;
use App\Subpractice;
use App\User;
use App\VendorApplication;
use App\VendorSolution;
use Illuminate\Http\Request;

class BenchmarkController extends Controller
{
    // Overview Controllers *****************************************************************************

    public function overviewGeneral(Request $request)
    {
        // Receive data.
        $regionsToFilter = $request->input('regions');
        if ($regionsToFilter) {
            $regionsToFilter = explode(',', $regionsToFilter);
        }
        $yearsToFilter = $request->input('years');
        if ($yearsToFilter) {
            $yearsToFilter = explode(',', $yearsToFilter);
        }

        // Data for graphics. Applying filters.
        $practices = Practice::all();                                                              // Chart 1
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();     // Chart 2
        $clients = User::clientUsers()->where('hasFinishedSetup', true)->get();     // Chart 3
        // Note: In the 3 previous cases, the filters are sended to the view in order to filter there, calling the models.
        $industries = Project::calculateProjectsPerIndustry($regionsToFilter, $yearsToFilter);     // Chart 4

        // Data for selects.
        $regions = collect(config('arrays.regions'));
        $years = Project::calculateProjectsPerYears();

        return View('accentureViews.benchmarkOverview', [
            'regions' => $regions,
            'years' => $years,
            'practices' => $practices,
            'vendors' => $vendors,
            'clients' => $clients,
            'industries' => $industries,

            'regionsToFilter' => $regionsToFilter,
            'yearsToFilter' => $yearsToFilter,
        ]);
    }

    public function overviewHistorical(Request $request)
    {
        // Receive data.
        $industriesToFilter = $request->input('industries');
        if ($industriesToFilter) {
            $industriesToFilter = explode(',', $industriesToFilter);
        }
        $regionsToFilter = $request->input('regions');
        if ($regionsToFilter) {
            $regionsToFilter = explode(',', $regionsToFilter);
        }
        $practicesToFilter = $request->input('practices');
        if ($practicesToFilter) {
            $practicesToFilter = explode(',', $practicesToFilter);
        }

        // Data for graphics. Applying filters. (no filter yet). Chart 1
        $years = Project::calculateProjectsPerYears();

        // Data for selects.
        $regions = collect(config('arrays.regions'));
        $industries = collect(config('arrays.industryExperience'));
        $practices = Practice::all();

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
        // Chart 1
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
        // Chart 2
        $industries = collect(config('arrays.industryExperience'))->map(function ($industry) {
            return (object)[
                'name' => $industry,
                'count' => User::vendorUsers()->get()->filter(function (User $vendor) use ($industry) {
                    return $vendor->getVendorResponse('vendorIndustry') == $industry;
                })->count(),
            ];
        });
        // Chart 3
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

    public function projectResultsOverall(Request $request)
    {
        // Receive data.
        $practicesIDsToFilter = $request->input('practices');
        if ($practicesIDsToFilter) {
            $practicesIDsToFilter = explode(',', $practicesIDsToFilter);
        }
        $subpracticesIDsToFilter = $request->input('subpractices');
        if ($practicesIDsToFilter) {
            $subpracticesIDsToFilter = explode(',', $subpracticesIDsToFilter);
        }
        $yearsToFilter = $request->input('years');
        if ($yearsToFilter) {
            $yearsToFilter = explode(',', $yearsToFilter);
        }
        $industriesToFilter = $request->input('industries');
        if ($industriesToFilter) {
            $industriesToFilter = explode(',', $industriesToFilter);

        }
        $regionsToFilter = $request->input('regions');
        if ($regionsToFilter) {
            $regionsToFilter = explode(',', $regionsToFilter);

        }

        // Data for charts. Applying Filters
        $howManyVendorsToChart = 5;
        // Chart 1
        $vendorScores = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToChart,
            'totalScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
            $yearsToFilter, $industriesToFilter, $regionsToFilter);
        // Chart 2 ( no project filter)
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();

        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $projectsByYears = Project::calculateProjectsPerYears();
        $industries = collect(config('arrays.industryExperience'));
        $regions = collect(config('arrays.regions'));

        // Data for informative panels (counts)
        $totalVendors = User::vendorUsers()->where('hasFinishedSetup', true)->count();
        $totalClients = User::clientUsers()->where('hasFinishedSetup', true)->count();
        $totalProjects = Project::all('id')->count();
        $totalSolutions = VendorSolution::all('id')->count();

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
            'vendorScores' => $vendorScores,
        ]);
    }

    public function projectResultsFitgap(Request $request)
    {
        // Receive data.
        $practicesIDsToFilter = $request->input('practices');
        if ($practicesIDsToFilter) {
            $practicesIDsToFilter = explode(',', $practicesIDsToFilter);
        }
        $subpracticesIDsToFilter = $request->input('subpractices');
        if ($practicesIDsToFilter) {
            $subpracticesIDsToFilter = explode(',', $subpracticesIDsToFilter);
        }
        $yearsToFilter = $request->input('years');
        if ($yearsToFilter) {
            $yearsToFilter = explode(',', $yearsToFilter);
        }
        $industriesToFilter = $request->input('industries');
        if ($industriesToFilter) {
            $industriesToFilter = explode(',', $industriesToFilter);

        }
        $regionsToFilter = $request->input('regions');
        if ($regionsToFilter) {
            $regionsToFilter = explode(',', $regionsToFilter);

        }

        // Data for charts. Applying Filters
        $howManyVendorsToChart = 5;

        $vendorScoresFitgap = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToChart,
            'fitgapScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        $vendorScoresFitgapFunctional = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToChart,
            'fitgapFunctionalScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        $vendorScoresFitgapTechnical = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToChart,
            'fitgapTechnicalScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        $vendorScoresFitgapService = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToChart,
            'fitgapServiceScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        $vendorScoresFitgapOthers = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToChart,
            'fitgapOtherScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $projectsByYears = Project::calculateProjectsPerYears();
        $industries = collect(config('arrays.industryExperience'));
        $regions = collect(config('arrays.regions'));

        return View('accentureViews.benchmarkProjectResultsFitgap', [
            'practices' => $practices,
            'subpractices' => $subpractices,
            'projectsByYears' => $projectsByYears,
            'industries' => $industries,
            'regions' => $regions,

            'vendorScoresFitgap' => $vendorScoresFitgap,
            'vendorScoresFitgapFunctional' => $vendorScoresFitgapFunctional,
            'vendorScoresFitgapTechnical' => $vendorScoresFitgapTechnical,
            'vendorScoresFitgapService' => $vendorScoresFitgapService,
            'vendorScoresFitgapOthers' => $vendorScoresFitgapOthers,
        ]);
    }

    public function projectResultsVendor(Request $request)
    {
        // Receive data
        $practicesIDsToFilter = $request->input('practices');
        if ($practicesIDsToFilter) {
            $practicesIDsToFilter = explode(',', $practicesIDsToFilter);
        }
        $subpracticesIDsToFilter = $request->input('subpractices');
        if ($practicesIDsToFilter) {
            $subpracticesIDsToFilter = explode(',', $subpracticesIDsToFilter);
        }
        $yearsToFilter = $request->input('years');
        if ($yearsToFilter) {
            $yearsToFilter = explode(',', $yearsToFilter);
        }
        $industriesToFilter = $request->input('industries');
        if ($industriesToFilter) {
            $industriesToFilter = explode(',', $industriesToFilter);
        }
        $regionsToFilter = $request->input('regions');
        if ($regionsToFilter) {
            $regionsToFilter = explode(',', $regionsToFilter);
        }

        // Data for charts
        $howManyVendorsToChart = 5;
        $vendorScoresVendor = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToChart,
            'vendorScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $projectsByYears = Project::calculateProjectsPerYears();
        $industries = collect(config('arrays.industryExperience'));
        $subIndustries = [];
        $regions = collect(config('arrays.regions'));

        return View('accentureViews.benchmarkProjectResultsVendor', [
            'practices' => $practices,
            'subpractices' => $subpractices,
            'projectsByYears' => $projectsByYears,
            'industries' => $industries,
            'subIndustries' => $subIndustries,
            'regions' => $regions,

            'vendorScoresVendor' => $vendorScoresVendor,
        ]);
    }

    public function projectResultsExperience(Request $request)
    {
        // Receive data
        $practicesIDsToFilter = $request->input('practices');
        if ($practicesIDsToFilter) {
            $practicesIDsToFilter = explode(',', $practicesIDsToFilter);
        }
        $subpracticesIDsToFilter = $request->input('subpractices');
        if ($practicesIDsToFilter) {
            $subpracticesIDsToFilter = explode(',', $subpracticesIDsToFilter);
        }
        $yearsToFilter = $request->input('years');
        if ($yearsToFilter) {
            $yearsToFilter = explode(',', $yearsToFilter);
        }
        $industriesToFilter = $request->input('industries');
        if ($industriesToFilter) {
            $industriesToFilter = explode(',', $industriesToFilter);
        }
        $regionsToFilter = $request->input('regions');
        if ($regionsToFilter) {
            $regionsToFilter = explode(',', $regionsToFilter);
        }

        // Data for charts.
        $howManyVendorsToChart = 5;
        $vendorScoresExperience = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToChart,
            'experienceScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $projectsByYears = Project::calculateProjectsPerYears();
        $industries = collect(config('arrays.industryExperience'));
        $subIndustries = [];
        $regions = collect(config('arrays.regions'));


        return View('accentureViews.benchmarkProjectResultsExperience', [
            'practices' => $practices,
            'subpractices' => $subpractices,
            'projectsByYears' => $projectsByYears,
            'industries' => $industries,
            'subIndustries' => $subIndustries,
            'regions' => $regions,

            'vendorScoresExperience' => $vendorScoresExperience,
        ]);
    }

    public function projectResultsInnovation(Request $request)
    {
        // Receive data
        $practicesIDsToFilter = $request->input('practices');
        if ($practicesIDsToFilter) {
            $practicesIDsToFilter = explode(',', $practicesIDsToFilter);
        }
        $subpracticesIDsToFilter = $request->input('subpractices');
        if ($practicesIDsToFilter) {
            $subpracticesIDsToFilter = explode(',', $subpracticesIDsToFilter);
        }
        $yearsToFilter = $request->input('years');
        if ($yearsToFilter) {
            $yearsToFilter = explode(',', $yearsToFilter);
        }
        $industriesToFilter = $request->input('industries');
        if ($industriesToFilter) {
            $industriesToFilter = explode(',', $industriesToFilter);
        }
        $regionsToFilter = $request->input('regions');
        if ($regionsToFilter) {
            $regionsToFilter = explode(',', $regionsToFilter);
        }

        // Data for charts
        $howManyVendorsToChart = 5;
        $vendorScoresInnovation = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToChart,
            'innovationScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $projectsByYears = Project::calculateProjectsPerYears();
        $industries = collect(config('arrays.industryExperience'));
        $subIndustries = [];
        $regions = collect(config('arrays.regions'));

        return View('accentureViews.benchmarkProjectResultsInnovation', [
            'practices' => $practices,
            'subpractices' => $subpractices,
            'projectsByYears' => $projectsByYears,
            'industries' => $industries,
            'subIndustries' => $subIndustries,
            'regions' => $regions,

            'vendorScoresInnovation' => $vendorScoresInnovation,
        ]);
    }

    public function projectResultsImplementation(Request $request)
    {
        // Receive data
        $practicesIDsToFilter = $request->input('practices');
        if ($practicesIDsToFilter) {
            $practicesIDsToFilter = explode(',', $practicesIDsToFilter);
        }
        $subpracticesIDsToFilter = $request->input('subpractices');
        if ($practicesIDsToFilter) {
            $subpracticesIDsToFilter = explode(',', $subpracticesIDsToFilter);
        }
        $yearsToFilter = $request->input('years');
        if ($yearsToFilter) {
            $yearsToFilter = explode(',', $yearsToFilter);
        }
        $industriesToFilter = $request->input('industries');
        if ($industriesToFilter) {
            $industriesToFilter = explode(',', $industriesToFilter);
        }
        $regionsToFilter = $request->input('regions');
        if ($regionsToFilter) {
            $regionsToFilter = explode(',', $regionsToFilter);
        }

        // Data for charts.
        $howManyVendorsToChart = 5;
        $vendorScoresImplementation = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToChart,
            'implementationScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
            $yearsToFilter, $industriesToFilter, $regionsToFilter);
        $vendorScoresImplementationImplementation = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToChart,
            'implementationImplementationScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
            $yearsToFilter, $industriesToFilter, $regionsToFilter);
        $vendorScoresImplementationRun = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToChart,
            'implementationRunScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $projectsByYears = Project::calculateProjectsPerYears();
        $industries = collect(config('arrays.industryExperience'));
        $subIndustries = [];
        $regions = collect(config('arrays.regions'));

        return View('accentureViews.benchmarkProjectResultsImplementation', [
            'practices' => $practices,
            'subpractices' => $subpractices,
            'projectsByYears' => $projectsByYears,
            'industries' => $industries,
            'subIndustries' => $subIndustries,
            'regions' => $regions,

            'vendorScoresImplementation' => $vendorScoresImplementation,
            'vendorScoresImplementationImplementation' => $vendorScoresImplementationImplementation,
            'vendorScoresImplementationRun' => $vendorScoresImplementationRun,
        ]);
    }

    public function getSubpracticesfromPractice(string $practiceId)
    {
        $practiceId = intval($practiceId);
        $practice = Practice::find($practiceId);
        $subpractices = Subpractice::where('practice_id', $practice->id)->get();

        return \response()->json([
            'status' => 200,
            'subpractices' => $subpractices,
            'message' => 'Success'
        ]);
    }

}
