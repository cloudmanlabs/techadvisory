<?php


namespace App\Http\Controllers\Accenture;


use App\Http\Controllers\Controller;
use App\Practice;
use App\Project;
use App\Subpractice;
use App\User;
use App\VendorApplication;
use App\VendorSolution;
use App\VendorsProjectsAnalysis;
use App\VendorUseCasesEvaluation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BenchmarkController extends Controller
{
    // Overview Controllers *****************************************************************************

    public function overviewGeneral(Request $request)
    {
        $regionsToFilter = [];
        $yearsToFilter = [];
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
        $vendors = User::vendorUsers()->get()
            ->filter(function (User $vendor) use ($practices, $regionsToFilter, $yearsToFilter) {
                $count = 0;
                foreach ($practices as $practice) {
                    $count += $practice->numberOfProjectsAnsweredByVendor($vendor, $regionsToFilter, $yearsToFilter);
                }
                return $count > 0;
            });     // Chart 2
        $clients = User::clientUsers()->get()
            ->filter(function (User $client) use ($regionsToFilter, $yearsToFilter) {
                return $client->projectsClientFilteredBenchmarkOverview($regionsToFilter, $yearsToFilter) > 0;
            });     // Chart 3
        // Note: In the 3 previous cases, the filters are sended to the view in order to filter there, calling the models.
        $industries = Project::calculateProjectsPerIndustry($regionsToFilter, $yearsToFilter);     // Chart 4

        // Data for selects.
        $regions = collect(config('arrays.regions'));
        $years = Project::calculateProjectsPerYears();

        return View('accentureViews.benchmarkOverview', [
            'nav1' => 'overview',
            'nav2' => 'general',

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

        $years = Project::calculateProjectsPerYearsHistoricalFiltered($industriesToFilter, $regionsToFilter);

        $transportProjectsByYears = Project::calculateProjectsPerYearsHistoricalFilteredByPractice(
            1, $industriesToFilter, $regionsToFilter);
        $planningProjectsByYears = Project::calculateProjectsPerYearsHistoricalFilteredByPractice(
            2, $industriesToFilter, $regionsToFilter);
        $manufacturingProjectsByYears = Project::calculateProjectsPerYearsHistoricalFilteredByPractice(
            3, $industriesToFilter, $regionsToFilter);
        $warehousingProjectsByYears = Project::calculateProjectsPerYearsHistoricalFilteredByPractice(
            4, $industriesToFilter, $regionsToFilter);
        $sourcingProjectsByYears = Project::calculateProjectsPerYearsHistoricalFilteredByPractice(
            5, $industriesToFilter, $regionsToFilter);

        // Data for selects.
        $regions = collect(config('arrays.regions'));
        $industries = collect(config('arrays.industryExperience'));

        return View('accentureViews.benchmarkOverviewHistorical', [
            'nav1' => 'overview',
            'nav2' => 'historical',

            'regions' => $regions,
            'industries' => $industries,
            'years' => $years,

            'transportProjectsByYears' => $transportProjectsByYears,
            'planningProjectsByYears' => $planningProjectsByYears,
            'manufacturingProjectsByYears' => $manufacturingProjectsByYears,
            'warehousingProjectsByYears' => $warehousingProjectsByYears,
            'sourcingProjectsByYears' => $sourcingProjectsByYears,

            'industriesToFilter' => $industriesToFilter,
            'regionsToFilter' => $regionsToFilter,

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
        $industries = User::vendorsPerIndustry();

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
            'nav1' => 'overview',
            'nav2' => 'vendor',

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
        if ($subpracticesIDsToFilter) {
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
        $howManyVendorsToChart = 10;
        // Chart 1
        $vendorScores = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToChart,
            'totalScore', $practicesIDsToFilter, $subpracticesIDsToFilter ?? [],
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        // Chart 2 ( no project filter)
//        $vendors = VendorApplication::getVendorsFilteredForRankingChart($practicesIDsToFilter,
//            $subpracticesIDsToFilter, $yearsToFilter, $industriesToFilter, $regionsToFilter);

        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $years = Project::calculateProjectsPerYears();
        $industries = collect(config('arrays.industryExperience'));
        $regions = collect(config('arrays.regions'));

        // Data for informative panels (counts)
        $totalVendors = User::vendorUsers()->get()
            ->filter(function (User $vendor) use ($regionsToFilter, $yearsToFilter, $industriesToFilter, $practicesIDsToFilter, $subpracticesIDsToFilter) {
                $count = $vendor->vendorAppliedProjectsFiltered($practicesIDsToFilter, $subpracticesIDsToFilter ?? [], $yearsToFilter, $industriesToFilter, $regionsToFilter);
                return $count > 0;
            })->count();

        $totalClients = User::clientUsers()->get()
            ->filter(function (User $client) use ($regionsToFilter, $yearsToFilter, $industriesToFilter, $practicesIDsToFilter, $subpracticesIDsToFilter){
                $count = $client->clientInProjectsWithApplicationAnsweredFiltered($practicesIDsToFilter, $subpracticesIDsToFilter ?? [], $yearsToFilter, $industriesToFilter, $regionsToFilter);
                return $count > 0;
//                return $client->projectsClientFilteredBenchmarkOverview($regionsToFilter, $yearsToFilter, $industriesToFilter) > 0;
            })->count();

        $totalProjectsQuery = Project::select('projects.*')
            ->distinct('projects.id')
            ->where('currentPhase', '=', 'old')
            ->leftJoin('project_subpractice as sub', 'projects.id', '=', 'sub.project_id')
            ->whereHas('vendorApplications', function (Builder $query) {
                $query->where('phase', 'submitted');
            });

        if ($regionsToFilter) {
            $totalProjectsQuery = $totalProjectsQuery->where(function ($totalProjectsQuery) use ($regionsToFilter) {
                for ($i = 0; $i < count($regionsToFilter); $i++) {
                    $totalProjectsQuery = $totalProjectsQuery->where('regions', 'like', '%' . $regionsToFilter[$i] . '%');
                }
            });
        }

        if ($yearsToFilter) {
            $totalProjectsQuery = $totalProjectsQuery->where(function ($totalProjectsQuery) use ($yearsToFilter) {
                for ($i = 0; $i < count($yearsToFilter); $i++) {
                    $totalProjectsQuery = $totalProjectsQuery->orWhere('created_at', 'like', '%' . $yearsToFilter[$i] . '%');
                }
            });
        }

        if ($industriesToFilter) {
            $totalProjectsQuery = $totalProjectsQuery->where(function ($totalProjectsQuery) use ($industriesToFilter) {
                for ($i = 0; $i < count($industriesToFilter); $i++) {
                    $totalProjectsQuery = $totalProjectsQuery->orWhere('industry', '=', $industriesToFilter[$i]);
                }
            });
        }

        if ($practicesIDsToFilter) {
            $totalProjectsQuery = $totalProjectsQuery->where(function ($query) use ($practicesIDsToFilter) {
                foreach ($practicesIDsToFilter as $practiceID) {
                    $query->orWhere('practice_id', '=', $practiceID);
                }
            });
        }

        if ($subpracticesIDsToFilter) {
            $totalProjectsQuery = $totalProjectsQuery->where(function ($query) use ($subpracticesIDsToFilter) {
                foreach ($subpracticesIDsToFilter ?? [] as $subpracticeID) {
                    $query->orWhere('sub.subpractice_id', '=', $subpracticeID);
                }
            });
        }

        $totalProjects = $totalProjectsQuery->get()
            ->filter(function($project) use ($subpracticesIDsToFilter) {
                $projectSubpracticeIds = $project->subpractices->map(function($subpractice) {
                    return $subpractice->id;
                });

                foreach ($subpracticesIDsToFilter ?? [] as $subpracticeID) {
                    if(!$projectSubpracticeIds->contains($subpracticeID)) {
                        return false;
                    }
                }

                return true;
            })->count();

        $vendors = User::vendorUsers()->get()
            ->filter(function (User $vendor) use ($regionsToFilter, $yearsToFilter, $industriesToFilter, $practicesIDsToFilter, $subpracticesIDsToFilter) {
                $count = $vendor->vendorAppliedProjectsFiltered($practicesIDsToFilter, $subpracticesIDsToFilter ?? [], $yearsToFilter, $industriesToFilter, $regionsToFilter);
                return $count > 0;
            });

        $totalSolutions = 0;
        foreach ($vendors as $vendor) {
            $totalSolutions += $vendor->vendorSolutions->count();
        }

        return View('accentureViews.benchmarkProjectResults', [
            'nav1' => 'projectResults',
            'nav2' => 'overall',


            'practices' => $practices,
            'subpractices' => $subpractices,
            'years' => $years,
            'industries' => $industries,
            'regions' => $regions,

            'totalVendors' => $totalVendors,
            'totalClients' => $totalClients,
            'totalProjects' => $totalProjects,
            'totalSolutions' => $totalSolutions,

            'vendors' => $vendors,
            'vendorScores' => $vendorScores,

            'practicesIDsToFilter' => $practicesIDsToFilter,
            'subpracticesIDsToFilter' => $subpracticesIDsToFilter,
            'yearsToFilter' => $yearsToFilter,
            'industriesToFilter' => $industriesToFilter,
            'regionsToFilter' => $regionsToFilter,
        ]);
    }

    public function projectUseCasesResultsOverall(Request $request)
    {
        // Receive data.
        $practicesIDsToFilter = $request->input('practices');
        if ($practicesIDsToFilter) {
            $practicesIDsToFilter = explode(',', $practicesIDsToFilter);
        }

        $subpracticesIDsToFilter = $request->input('subpractices');
        if ($subpracticesIDsToFilter) {
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

        $practices = Practice::all();
        $filteredPractices = $practicesIDsToFilter ? Practice::whereIn('id', $practicesIDsToFilter)->get() : $practices;
        $subpractices = [];
        $years = Project::calculateProjectsPerYears();
        $industries = collect(config('arrays.industryExperience'));
        $regions = collect(config('arrays.regions'));

        // Data for informative panels (counts)
        $totalVendors = VendorsProjectsAnalysis::numberOfVendorsEvaluated($regionsToFilter, $yearsToFilter, $industriesToFilter, $practicesIDsToFilter);

        $totalClients = VendorUseCasesEvaluation::numberOfClientsThatEvaluatedVendors($regionsToFilter, $yearsToFilter, $industriesToFilter, $practicesIDsToFilter);

        $totalProjects = VendorsProjectsAnalysis::numberOfProjectsWithVendorsEvaluated($regionsToFilter, $yearsToFilter, $industriesToFilter, $practicesIDsToFilter);

        $vendors = VendorsProjectsAnalysis::vendorsEvaluated($regionsToFilter, $yearsToFilter, $industriesToFilter, $practicesIDsToFilter);

        $vendorScores = [];
        foreach ($vendors as $vendor) {
            $cachedVendorEvaluations = VendorsProjectsAnalysis::getByVendor($vendor->id);
            $vendorScores[$vendor->id] = 0.0;
            foreach ($cachedVendorEvaluations as $cachedVendorEvaluation) {
                $vendorScores[$vendor->id] += $cachedVendorEvaluation->total;
            }

            $vendorScores[$vendor->id] /= count($cachedVendorEvaluations);
        }

        $totalSolutions = 0;
        foreach ($vendors as $vendor) {
            $totalSolutions += $vendor->vendorSolutions->count();
        }

        return View('accentureViews.benchmarkProjectResultsUseCasesOverall', [
            'nav1' => 'projectResults',
            'nav2' => 'overallUseCases',


            'practices' => $practices,
            'subpractices' => $subpractices,
            'years' => $years,
            'industries' => $industries,
            'regions' => $regions,

            'totalVendors' => $totalVendors,
            'totalClients' => $totalClients,
            'totalProjects' => $totalProjects,
            'totalSolutions' => $totalSolutions,

            'vendors' => $vendors,
            'vendorScores' => $vendorScores,

            'practicesIDsToFilter' => $practicesIDsToFilter,
            'subpracticesIDsToFilter' => $subpracticesIDsToFilter,
            'yearsToFilter' => $yearsToFilter,
            'industriesToFilter' => $industriesToFilter,
            'regionsToFilter' => $regionsToFilter,
        ]);
    }

    public function projectResultsFitgap(Request $request)
    {
        $practicesIDsToFilter = $request->input('practices');
        if ($practicesIDsToFilter) {
            $practicesIDsToFilter = explode(',', $practicesIDsToFilter);
        }

        $subpracticesIDsToFilter = $request->input('subpractices');
        if ($subpracticesIDsToFilter) {
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

        $howManyVendorsToFirstChart = 10;
        $howManyVendorsToTheRestChart = 5;

        $vendorScoresFitgap = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToFirstChart,
            'fitgapScore', $practicesIDsToFilter, $subpracticesIDsToFilter ?? [],
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        $vendorScoresFitgapFunctional = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToTheRestChart,
            'fitgapFunctionalScore', $practicesIDsToFilter, $subpracticesIDsToFilter ?? [],
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        $vendorScoresFitgapTechnical = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToTheRestChart,
            'fitgapTechnicalScore', $practicesIDsToFilter, $subpracticesIDsToFilter ?? [],
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        $vendorScoresFitgapService = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToTheRestChart,
            'fitgapServiceScore', $practicesIDsToFilter, $subpracticesIDsToFilter ?? [],
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        $vendorScoresFitgapOthers = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToTheRestChart,
            'fitgapOtherScore', $practicesIDsToFilter, $subpracticesIDsToFilter ?? [],
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        // Data for selects
        $practices = Practice::all();
        $years = Project::calculateProjectsPerYears();
        $industries = collect(config('arrays.industryExperience'));
        $regions = collect(config('arrays.regions'));

        return View('accentureViews.benchmarkProjectResultsFitgap', [
            'nav1' => 'projectResults',
            'nav2' => 'fitgap',

            'practices' => $practices,
            'years' => $years,
            'industries' => $industries,
            'regions' => $regions,

            'vendorScoresFitgap' => $vendorScoresFitgap,
            'vendorScoresFitgapFunctional' => $vendorScoresFitgapFunctional,
            'vendorScoresFitgapTechnical' => $vendorScoresFitgapTechnical,
            'vendorScoresFitgapService' => $vendorScoresFitgapService,
            'vendorScoresFitgapOthers' => $vendorScoresFitgapOthers,

            'practicesIDsToFilter' => $practicesIDsToFilter,
            'subpracticesIDsToFilter' => $subpracticesIDsToFilter,
            'yearsToFilter' => $yearsToFilter,
            'industriesToFilter' => $industriesToFilter,
            'regionsToFilter' => $regionsToFilter,
        ]);
    }

    public function projectResultsUseCases(Request $request)
    {
        $practicesIDsToFilter = $request->input('practices');
        if ($practicesIDsToFilter) {
            $practicesIDsToFilter = explode(',', $practicesIDsToFilter);
        }

        $subpracticesIDsToFilter = $request->input('subpractices');
        if ($subpracticesIDsToFilter) {
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

        $howManyVendorsToFirstChart = 10;
        $howManyVendorsToTheRestChart = 5;

//        $vendorScoresFitgap = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToFirstChart,
//            'fitgapScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
//            $yearsToFilter, $industriesToFilter, $regionsToFilter);
//
//        $vendorScoresFitgapFunctional = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToTheRestChart,
//            'fitgapFunctionalScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
//            $yearsToFilter, $industriesToFilter, $regionsToFilter);
//
//        $vendorScoresFitgapTechnical = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToTheRestChart,
//            'fitgapTechnicalScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
//            $yearsToFilter, $industriesToFilter, $regionsToFilter);
//
//        $vendorScoresFitgapService = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToTheRestChart,
//            'fitgapServiceScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
//            $yearsToFilter, $industriesToFilter, $regionsToFilter);
//
//        $vendorScoresFitgapOthers = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToTheRestChart,
//            'fitgapOtherScore', $practicesIDsToFilter, $subpracticesIDsToFilter,
//            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        $vendors = VendorsProjectsAnalysis::vendorsEvaluated();

        $vendorScores = [];
        $vendorScoresSolutionFit = [];
        $vendorScoresUsability = [];
        $vendorScoresPerformance = [];
        $vendorScoresLookFeel = [];
        $vendorScoresOthers = [];

        foreach ($vendors as $vendor) {
            $cachedVendorEvaluations = VendorsProjectsAnalysis::getByVendor($vendor->id);
            $vendorScores[$vendor->id] = 0.0;
            $vendorScoresSolutionFit[$vendor->id] = 0.0;
            $vendorScoresUsability[$vendor->id] = 0.0;
            $vendorScoresPerformance[$vendor->id] = 0.0;
            $vendorScoresLookFeel[$vendor->id] = 0.0;
            $vendorScoresOthers[$vendor->id] = 0.0;

            foreach ($cachedVendorEvaluations as $cachedVendorEvaluation) {
                $vendorScores[$vendor->id] += $cachedVendorEvaluation->total;
                $vendorScoresSolutionFit[$vendor->id] += $cachedVendorEvaluation->solution_fit;
                $vendorScoresUsability[$vendor->id] += $cachedVendorEvaluation->usability;
                $vendorScoresPerformance[$vendor->id] += $cachedVendorEvaluation->performance;
                $vendorScoresLookFeel[$vendor->id] += $cachedVendorEvaluation->look_feel;
                $vendorScoresOthers[$vendor->id] += $cachedVendorEvaluation->others;
            }

            $vendorScores[$vendor->id] /= count($cachedVendorEvaluations);
            $vendorScoresSolutionFit[$vendor->id] /= count($cachedVendorEvaluations);
            $vendorScoresUsability[$vendor->id] /= count($cachedVendorEvaluations);
            $vendorScoresPerformance[$vendor->id] /= count($cachedVendorEvaluations);
            $vendorScoresLookFeel[$vendor->id] /= count($cachedVendorEvaluations);
            $vendorScoresOthers[$vendor->id] /= count($cachedVendorEvaluations);
        }

        // Data for selects
        $practices = Practice::all();
        $years = Project::calculateProjectsPerYears();
        $industries = collect(config('arrays.industryExperience'));
        $regions = collect(config('arrays.regions'));

        return View('accentureViews.benchmarkProjectResultsUseCases', [
            'nav1' => 'projectResults',
            'nav2' => 'useCases',

            'practices' => $practices,
            'years' => $years,
            'industries' => $industries,
            'regions' => $regions,

            'vendorScores' => $vendorScores,
            'vendorScoresSolutionFit' => $vendorScoresSolutionFit,
            'vendorScoresUsability' => $vendorScoresUsability,
            'vendorScoresPerformance' => $vendorScoresPerformance,
            'vendorScoresLookFeel' => $vendorScoresLookFeel,
            'vendorScoresOthers' => $vendorScoresOthers,

//            'vendorScoresFitgap' => $vendorScoresFitgap,
//            'vendorScoresFitgapFunctional' => $vendorScoresFitgapFunctional,
//            'vendorScoresFitgapTechnical' => $vendorScoresFitgapTechnical,
//            'vendorScoresFitgapService' => $vendorScoresFitgapService,
//            'vendorScoresFitgapOthers' => $vendorScoresFitgapOthers,

            'practicesIDsToFilter' => $practicesIDsToFilter,
            'subpracticesIDsToFilter' => $subpracticesIDsToFilter,
            'yearsToFilter' => $yearsToFilter,
            'industriesToFilter' => $industriesToFilter,
            'regionsToFilter' => $regionsToFilter,
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
        if ($subpracticesIDsToFilter) {
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
        $howManyVendorsToChart = 10;
        $vendorScoresVendor = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToChart,
            'vendorScore', $practicesIDsToFilter, $subpracticesIDsToFilter ?? [],
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $years = Project::calculateProjectsPerYears();
        $industries = collect(config('arrays.industryExperience'));
        $regions = collect(config('arrays.regions'));

        return View('accentureViews.benchmarkProjectResultsVendor', [
            'nav1' => 'projectResults',
            'nav2' => 'vendor',

            'practices' => $practices,
            'subpractices' => $subpractices,
            'years' => $years,
            'industries' => $industries,
            'regions' => $regions,

            'vendorScoresVendor' => $vendorScoresVendor,

            'practicesIDsToFilter' => $practicesIDsToFilter,
            'subpracticesIDsToFilter' => $subpracticesIDsToFilter,
            'yearsToFilter' => $yearsToFilter,
            'industriesToFilter' => $industriesToFilter,
            'regionsToFilter' => $regionsToFilter,
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
        if ($subpracticesIDsToFilter) {
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
        $howManyVendorsToChart = 10;
        $vendorScoresExperience = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToChart,
            'experienceScore', $practicesIDsToFilter, $subpracticesIDsToFilter ?? [],
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $years = Project::calculateProjectsPerYears();
        $industries = collect(config('arrays.industryExperience'));
        $regions = collect(config('arrays.regions'));


        return View('accentureViews.benchmarkProjectResultsExperience', [
            'nav1' => 'projectResults',
            'nav2' => 'experience',

            'practices' => $practices,
            'subpractices' => $subpractices,
            'years' => $years,
            'industries' => $industries,
            'regions' => $regions,

            'vendorScoresExperience' => $vendorScoresExperience,

            'practicesIDsToFilter' => $practicesIDsToFilter,
            'subpracticesIDsToFilter' => $subpracticesIDsToFilter,
            'yearsToFilter' => $yearsToFilter,
            'industriesToFilter' => $industriesToFilter,
            'regionsToFilter' => $regionsToFilter,
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
        if ($subpracticesIDsToFilter) {
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
        $howManyVendorsToChart = 10;
        $vendorScoresInnovation = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToChart,
            'innovationScore', $practicesIDsToFilter, $subpracticesIDsToFilter ?? [],
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $years = Project::calculateProjectsPerYears();
        $industries = collect(config('arrays.industryExperience'));
        $regions = collect(config('arrays.regions'));

        return View('accentureViews.benchmarkProjectResultsInnovation', [
            'nav1' => 'projectResults',
            'nav2' => 'innovation',

            'practices' => $practices,
            'subpractices' => $subpractices,
            'years' => $years,
            'industries' => $industries,
            'regions' => $regions,

            'vendorScoresInnovation' => $vendorScoresInnovation,

            'practicesIDsToFilter' => $practicesIDsToFilter,
            'subpracticesIDsToFilter' => $subpracticesIDsToFilter,
            'yearsToFilter' => $yearsToFilter,
            'industriesToFilter' => $industriesToFilter,
            'regionsToFilter' => $regionsToFilter,
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
        if ($subpracticesIDsToFilter) {
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
        $howManyVendorsToFirstChart = 10;
        $howManyVendorsToOthersCharts = 5;

        $vendorScoresImplementation = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToFirstChart,
            'implementationScore', $practicesIDsToFilter, $subpracticesIDsToFilter ?? [],
            $yearsToFilter, $industriesToFilter, $regionsToFilter);
        $vendorScoresImplementationImplementation = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToOthersCharts,
            'implementationImplementationScore', $practicesIDsToFilter, $subpracticesIDsToFilter ?? [],
            $yearsToFilter, $industriesToFilter, $regionsToFilter);
        $vendorScoresImplementationRun = VendorApplication::calculateBestVendorsProjectResultsFiltered($howManyVendorsToOthersCharts,
            'implementationRunScore', $practicesIDsToFilter, $subpracticesIDsToFilter ?? [],
            $yearsToFilter, $industriesToFilter, $regionsToFilter);

        // Data for selects
        $practices = Practice::all();
        $subpractices = [];
        $years = Project::calculateProjectsPerYears();
        $industries = collect(config('arrays.industryExperience'));
        $regions = collect(config('arrays.regions'));

        return View('accentureViews.benchmarkProjectResultsImplementation', [
            'nav1' => 'projectResults',
            'nav2' => 'implementation',

            'practices' => $practices,
            'subpractices' => $subpractices,
            'years' => $years,
            'industries' => $industries,
            'regions' => $regions,

            'vendorScoresImplementation' => $vendorScoresImplementation,
            'vendorScoresImplementationImplementation' => $vendorScoresImplementationImplementation,
            'vendorScoresImplementationRun' => $vendorScoresImplementationRun,

            'practicesIDsToFilter' => $practicesIDsToFilter,
            'subpracticesIDsToFilter' => $subpracticesIDsToFilter,
            'yearsToFilter' => $yearsToFilter,
            'industriesToFilter' => $industriesToFilter,
            'regionsToFilter' => $regionsToFilter,
        ]);
    }

    // Custom Searches Controllers ***************************************************************************
    // This two methods give a clone view of custom searches (only for accenture).
    public function customSearches()
    {
        // Data for populate the select options.
        $practices = Practice::pluck('name')->toArray();
        $subpractices = [];
        $clients = User::clientUsers()->where('hasFinishedSetup', true)->pluck('name')->toArray();
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->pluck('name')->toArray();
        $regions = collect(config('arrays.regions'));
        $industries = collect(config('arrays.industryExperience'));
        $years = collect(range(2017, intval(date('Y'))));

        // Data to show and filter.
        $projects = Project::select('id', 'name', 'practice_id', 'client_id',
            'created_at', 'industry', 'regions', 'currentPhase')
            ->where('currentPhase', '=', 'old')->get();

        // By default CustomSearches shows Custom project searches (analytic by projects).
        return View('accentureViews.benchmarkCustomSearchesProject', [
            'nav1' => 'custom',
            'nav2' => 'project',

            'practices' => $practices,
            'subpractices' => $subpractices,
            'clients' => $clients,
            'vendors' => $vendors,
            'regions' => $regions,
            'industries' => $industries,
            'years' => $years,

            'projects' => $projects,
        ]);
    }

    public function customSearchesVendor()
    {
        // Data for populate the select options.
        $segments = collect(['Megasuite', 'SCM suite', 'Specific solution']);
        $practices = Practice::pluck('name')->toArray();
        $regions = collect(config('arrays.regions'));
        $industries = collect(config('arrays.industryExperience'));
        $years = collect(range(2017, intval(date('Y'))));
        $transportFlows = collect(config('arrays.transportFlows'));
        $transportModes = collect(config('arrays.transportModes'));
        $transportTypes = collect(config('arrays.transportTypes'));

        // Data to show and filter.
        $vendors = User::vendorUsers()->where('hasFinishedSetup', true)->get();

        return View('accentureViews.benchmarkCustomSearchesVendor', [
            'nav1' => 'custom',
            'nav2' => 'vendor',

            'segments' => $segments,
            'practices' => $practices,
            'regions' => $regions,
            'industries' => $industries,
            'years' => $years,
            'transportFlows' => $transportFlows,
            'transportModes' => $transportModes,
            'transportTypes' => $transportTypes,

            'vendors' => $vendors,
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
    public function getSubpracticesfromPracticeName(string $practiceName)
    {
        $practice = Practice::where('name',$practiceName)->first();

        $subpractices = [];
        if(!empty($practice)) $subpractices = Subpractice::where('practice_id', $practice->id)->pluck('name')->toArray();


        return \response()->json([
            'status' => 200,
            'subpractices' => $subpractices,
            'message' => 'Success'
        ]);
    }


}
