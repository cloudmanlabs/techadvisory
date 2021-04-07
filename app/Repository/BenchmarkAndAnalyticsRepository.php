<?php

namespace App\Repository;

use App\VendorApplication;
use Illuminate\Support\Facades\DB;

use function foo\func;

class BenchmarkAndAnalyticsRepository
{
    public static function yearsFilter()
    {
        return DB::table('projects')
            ->select(DB::raw('DISTINCT(YEAR(created_at)) as year'))
            ->orderBy('year', 'desc')
            ->get()
            ->pluck('year')
            ->toArray();
    }

    public static function overallTotalProjects($practiceId, $subpracticeIds, $years, $industries, $regions)
    {
        return self::overallTotalQuery($practiceId, $subpracticeIds, $years, $industries, $regions)
            ->select('p.id')
            ->distinct()
            ->get()
            ->count();
    }

    public static function overallTotalVendors($practiceId, $subpracticeIds, $years, $industries, $regions)
    {
        return self::overallTotalQuery($practiceId, $subpracticeIds, $years, $industries, $regions)
            ->join('vendor_applications as va', 'p.id', '=', 'va.project_id')
            ->where('va.phase', 'submitted')
            ->select('va.vendor_id')
            ->when(!empty($subpracticeIds), function ($query) use ($subpracticeIds) {
                $query->groupBy('p.id', 'va.vendor_id');

                return $query;
            })
            ->distinct('va.vendor_id')
            ->get()
            ->count();
    }

    public static function overallTotalClients($practiceId, $subpracticeIds, $years, $industries, $regions)
    {
        return self::overallTotalQuery($practiceId, $subpracticeIds, $years, $industries, $regions)
            ->select('p.client_id')
            ->when(!empty($subpracticeIds), function ($query) use ($subpracticeIds) {
                $query->groupBy('p.id', 'p.client_id');

                return $query;
            })
            ->distinct('p.client_id')
            ->count();
    }

    public static function overallTotalSolutions($practiceId, $subpracticeIds, $years, $industries, $regions)
    {
        return self::overallTotalQuery($practiceId, $subpracticeIds, $years, $industries, $regions)
            ->join('vendor_applications as va', 'p.id', '=', 'va.project_id')
            ->where('va.phase', 'submitted')
            ->select('va.solutionsUsed')
            ->when(!empty($subpracticeIds), function ($query) use ($subpracticeIds) {
                $query->groupBy('p.id', 'va.solutionsUsed');

                return $query;
            })
            ->distinct()
            ->get()
            ->map(function ($result) {
                return json_decode($result->solutionsUsed);
            })
            ->collapse()
            ->unique()
            ->count();
    }

    private static function overallTotalQuery($practiceId, $subpracticeIds, $years, $industries, $regions)
    {
        return DB::table('projects', 'p')
            ->where('p.currentPhase', '=', 'old')
            ->when(!empty($practiceId), function ($query) use ($practiceId) {
                return $query->where('p.practice_id', $practiceId);
            })
            ->groupBy()
            ->when(!empty($subpracticeIds), function ($query) use ($subpracticeIds) {
                sort($subpracticeIds);
                $commaSeparatedSubpractices = implode(',', $subpracticeIds);
                $query->leftJoin('project_subpractice as ps', 'p.id', '=', 'ps.project_id');
                $query->whereIn('ps.subpractice_id', $subpracticeIds);
                $query->groupBy('p.id');
                $query->havingRaw('group_concat(`ps`.`subpractice_id` order by `ps`.`subpractice_id` asc) = \''.$commaSeparatedSubpractices.'\'');

                return $query;
            })
            ->when(!empty($years), function ($query) use ($years) {
                return $query->where(function ($query) use ($years) {
                    foreach ($years as $year) {
                        $query->orWhereYear('p.created_at', $year);
                    }
                });
            })
            ->when(!empty($industries), function ($query) use ($industries) {
                return $query->where(function ($query) use ($industries) {
                    foreach ($industries as $industry) {
                        $query = $query->orWhere('p.industry', '=', $industry);
                    }
                });
            })
            ->when(!empty($regions), function ($query) use ($regions) {
                foreach ($regions as $region) {
                    $query->where('p.regions', 'like', '%'.$region.'%');
                }

                return $query;
            });
    }
}
