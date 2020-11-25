<?php

namespace App\Providers;

use App\VendorApplication;
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
            ->orWhere('phase', '=', 'pendingEvaluation')          // Only bc we need some data. can be removed later.
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
                $result [$key]['score'] = $vendor->calculateMyVendorScore($targetScore);
                $result [$key]['count'] = $vendor->vendorAppliedProjectsFiltered($practicesID, $subpracticesID,
                    $years, $industries, $regions);
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
    public static function benchmarkProjectResultsFilters($query, $practicesID = [], $subpracticesID = [], $years = [], $industries = [], $regions = [])
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
