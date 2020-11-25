<?php

namespace App\Providers;

use App\Project;
use App\User;
use App\VendorApplication;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class ChartsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Returns an object collection as
     *  'years' => year (as string),
     *  'projectCount' => Number of projects from this year. Can search by null industry too.
     * @return Collection
     */
    public static function calculateProjectsPerYears()
    {
        return collect(range(2017, intval(date('Y'))))->map(function ($year) {
            return (object)[
                'year' => $year,
                'projectCount' => Project::all()->filter(function ($project) use ($year) {
                    return $project->created_at->year == $year;
                })->count(),
            ];
        });
    }

    /**
     * Returns an object collection as
     *  'years' => year (as string),
     *  'projectCount' => Number of projects from this year. Can search by null industry too.
     * Supports Historical Filters
     * @param array $industries
     * @param array $regions
     * @return Collection
     */
    public static function calculateProjectsPerYearsHistoricalFiltered($industries = [], $regions = [])
    {
        return collect(range(2017, intval(date('Y'))))
            ->map(function ($year) use ($industries, $regions) {
                return (object)[
                    'year' => $year,
                    'projectCount' => ChartsProvider::getProjectCountfromYear($year, $industries, $regions)
                ];
            });
    }

    private static function getProjectCountfromYear($year, $industries = [], $regions = [])
    {
        $query = Project::select('id', 'currentPhase', 'industry', 'practice_id', 'regions', 'created_at');
        $query = ChartsProvider::benchmarkOverviewHistoricalFilters($query, $industries, $regions);

        $query = $query->get()
            ->filter(function ($project) use ($year) {
                return $project->created_at->year == $year;
            })->count();

        return $query;
    }

    /**
     * Returns an object collection as
     *  'years' => year (as string),
     *  'projectCount' => Number of projects from this year with the practice provided.
     * Supports Historical Filters
     * @param $practiceId
     * @param array $industries
     * @param array $regions
     * @return Collection
     */
    public static function calculateProjectsPerYearsHistoricalFilteredByPractice($practiceId, $industries = [], $regions = [])
    {
        return collect(range(2017, intval(date('Y'))))
            ->map(function ($year) use ($practiceId, $industries, $regions) {
                return (object)[
                    'year' => $year,
                    'projectCount' =>
                        ChartsProvider::getProjectCountFromYearByPractice($practiceId, $year, $industries, $regions)
                ];
            });
    }

    private static function getProjectCountFromYearByPractice($practiceId, $year, $industries = [], $regions = [])
    {
        $query = Project::select('id', 'currentPhase', 'industry', 'practice_id', 'regions', 'created_at');
        $query = ChartsProvider::benchmarkOverviewHistoricalFilters($query, $industries, $regions, $practiceId);

        $query = $query->get()
            ->filter(function ($project) use ($year) {
                return $project->created_at->year == $year;
            })->count();

        return $query;
    }

    /**
     * Returns an object collection as
     *  'name' => industry name,
     *  'projectCount' => Number of projects with this industry. Can search by null industry too.
     * Supports possible filters by region and years.
     * @param array $regions
     * @param array $years
     * @return Collection
     */
    public static function calculateProjectsPerIndustry($regions = [], $years = [])
    {
        return collect(config('arrays.industryExperience'))->map(function ($industry)
        use ($regions, $years) {
            return (object)[
                'name' => $industry,
                'projectCount' => ChartsProvider::getProjectCountFromIndustry($industry, $regions, $years)];
        });
    }

    private static function getProjectCountFromIndustry($industry, $regions = [], $years = [])
    {
        $query = Project::select('id', 'currentPhase', 'industry', 'practice_id', 'regions', 'created_at');
        $query = ChartsProvider::benchmarkOverviewFilters($query, $regions, $years);

        $query = $query->get()->filter(function (Project $project) use ($industry) {
            return $project->industry == $industry;
        })->count();

        return $query;
    }

    // Encapsulate the filters for graphics from view: Overview - general
    private static function benchmarkOverviewFilters($query, $regions = [], $years = [])
    {

        if ($regions) {
            $query = $query->where(function ($query) use ($regions) {
                for ($i = 0; $i < count($regions); $i++) {
                    $query = $query->where('regions', 'like', '%' . $regions[$i] . '%');
                }
            });
        }

        if ($years) {
            $query = $query->where(function ($query) use ($years) {
                for ($i = 0; $i < count($years); $i++) {
                    $query = $query->orWhere('created_at', 'like', '%' . $years[$i] . '%');
                }
            });
        }
        return $query;
    }

    // Encapsulate the filters for graphics from view: Overview - Historical
    private static function benchmarkOverviewHistoricalFilters($query, $industries = [], $regions = [], $practice = [])
    {
        $query = $query->where('currentPhase', '=', 'old');

        if ($industries) {
            $query = $query->where(function ($query) use ($industries) {
                for ($i = 0; $i < count($industries); $i++) {
                    $query = $query->orWhere('industry', '=', $industries[$i]);
                }
            });
        }

        if ($regions) {
            $query = $query->where(function ($query) use ($regions) {
                for ($i = 0; $i < count($regions); $i++) {
                    $query = $query->where('regions', 'like', '%' . $regions[$i] . '%');
                }
            });
        }

        // Single type select.
        if ($practice) {
            $practice = intval($practice);
            $query = $query->where(function ($query) use ($practice) {
                $query = $query->orWhere('practice_id', '=', $practice);
            });
        }

        return $query;
    }

    public static function vendorsPerIndustry()
    {
        $industriesVendorCount = collect(config('arrays.industryExperience'))->map(function ($industry) {
            return (object)[
                'name' => $industry,
                'count' => ChartsProvider::vendorsCountPerThisIndustry($industry),
            ];
        });
        return $industriesVendorCount;
    }

    // returns the number of vendors from the Industry consulted.
    private static function vendorsCountPerThisIndustry($industryToCount)
    {
        $query = User::where('hasFinishedSetup', true)->get();

        $industries = collect();

        foreach ($query as $vendor) {
            $check = $vendor->getIndustryFromVendor();
            if (strpos($check, $industryToCount) !== false) {
                $industries->push($check);
            }
        }
        return $industries->count();
    }

    /**
     * This function calculates the best vendors by the target score.
     * Supports Project Results filters.
     * @param int $nVendors The number of vendors we want data
     * @param String $targetScore Property name from vendor Application
     * @param array $practicesID
     * @param array $subpracticesID
     * @param array $years
     * @param array $industries
     * @param array $regions
     *
     * @return array $result
     * Returns a associative array like:
     *  vendor_id => vendor id
     *  name => vendor name.
     *  score => target score of this vendor
     *  count => project counts of this vendor
     */
    public static function calculateBestNVendorsByScore(int $nVendors, string $targetScore,
                                                        $practicesID = [], $subpracticesID = [],
                                                        $years = [], $industries = [],
                                                        $regions = [])
    {
        if (!is_integer($nVendors)) {
            return [];
        }

        // All vendor applications that we need Raw data without user filters
        $allVendorApplications = VendorApplication::
        where('phase', '=', 'submitted')
            ->join('projects as p', 'project_id', '=', 'p.id')
            ->join('users as u', 'vendor_id', '=', 'u.id')
            ->join('project_subpractice as sub', 'vendor_applications.project_id', '=', 'sub.project_id')
            ->where('p.currentPhase', '=', 'old');

        // Applying user filters to projects
        $allVendorApplications = ChartsProvider::benchmarkProjectResultsFilters($allVendorApplications,
            $practicesID, $subpracticesID, $years, $industries, $regions);
        $allVendorApplications = $allVendorApplications->select('vendor_id')->distinct()->get();

        // Grouping the results to simply iterate on interface.
        $result = [];
        foreach ($allVendorApplications as $key => $vendorApplication) {
            $vendor = $vendorApplication->vendor;
            if (!empty($vendor)) {
                $result [$key]['vendor_id'] = $vendor->id;
                $result [$key]['name'] = $vendor->name;
                $result [$key]['score'] = $vendor->vendorAppliedProjectsScoreFiltered($targetScore,
                    $practicesID, $subpracticesID, $years, $industries, $regions);
                $result [$key]['count'] = $vendor->vendorAppliedProjectsFilteredCount(
                    $practicesID, $subpracticesID, $years, $industries, $regions);
            }
        }

        // Sort by score
        $scoreIndex = array_column($result, 'score');
        array_multisort($scoreIndex, SORT_DESC, $result);

        // Cut by best nVendors
        $result = array_slice($result, 0, $nVendors, true);

        return $result;
    }

    /**
     * This function calculates the score of ranking and overall, at the same time
     * Supports Project Results filters.
     * @param array $practicesID
     * @param array $subpracticesID
     * @param array $years
     * @param array $industries
     * @param array $regions
     *
     * @return array $result
     * Returns a associative array like:
     *  vendor_id => vendor id
     *  name => vendor name.
     *  overall => overall score of this vendor.
     *  ranking => ranking score of this vendor.
     */
    public static function calculateOverallAndRankingScoreForAllVendors($practicesID = [], $subpracticesID = [],
                                                                        $years = [], $industries = [],
                                                                        $regions = [])
    {

        // All vendor applications that we need Raw data without user filters
        $allVendorApplications = VendorApplication::
        where('phase', '=', 'submitted')
            ->join('projects as p', 'project_id', '=', 'p.id')
            ->join('users as u', 'vendor_id', '=', 'u.id')
            ->join('project_subpractice as sub', 'vendor_applications.project_id', '=', 'sub.project_id')
            ->where('p.currentPhase', '=', 'old');

        // Applying user filters to projects
        $allVendorApplications = ChartsProvider::benchmarkProjectResultsFilters($allVendorApplications,
            $practicesID, $subpracticesID, $years, $industries, $regions);
        $allVendorApplications = $allVendorApplications->select('vendor_id')->distinct()->get();

        // Grouping the results to simply iterate on interface.
        $result = [];
        foreach ($allVendorApplications as $key => $vendorApplication) {
            $vendor = $vendorApplication->vendor;
            if (!empty($vendor)) {
                $result [$key]['vendor_id'] = $vendor->id;
                $result [$key]['name'] = $vendor->name;
                $result [$key]['overall'] = $vendor->calculateMyVendorScore('overall_score');
                $result [$key]['ranking'] = round(10 - $vendor->calculateMyVendorScore('ranking_score'), 2);  // NOTE: We use 10 - val so we get the chart flipped horizontally
            }
        }

        return $result;
    }

    // Encapsulate the filters for graphics from view: Project Results
    private static function benchmarkProjectResultsFilters($query, $practicesID = [], $subpracticesID = [], $years = [], $industries = [], $regions = [])
    {
        // Applying user filters to projects
        if ($practicesID) {
            $query = $query->where(function ($query) use ($practicesID) {
                for ($i = 0; $i < count($practicesID); $i++) {
                    $query = $query->orWhere('p.practice_id', '=', $practicesID[$i]);
                }
            });
        }
        if (is_array($subpracticesID)) {
            $query = $query->where(function ($query) use ($subpracticesID) {
                for ($i = 0; $i < count($subpracticesID); $i++) {
                    // AND
                    $query = $query->where('sub.subpractice_id', '=', $subpracticesID[$i]);
                }
            });
        }
        if ($years) {
            $query = $query->where(function ($query) use ($years) {
                for ($i = 0; $i < count($years); $i++) {
                    // OR
                    $query = $query->orWhere('p.created_at', 'like', '%' . $years[$i] . '%');
                }
            });
        }
        if ($industries) {
            $query = $query->where(function ($query) use ($industries) {
                for ($i = 0; $i < count($industries); $i++) {
                    $query = $query->orWhere('p.industry', '=', $industries[$i]);
                }
            });
        }
        if ($regions) {
            $query = $query->where(function ($query) use ($regions) {
                for ($i = 0; $i < count($regions); $i++) {
                    // AND
                    $query = $query->where('p.regions', 'like', '%' . $regions[$i] . '%');
                }
            });
        }

        return $query;
    }

}
