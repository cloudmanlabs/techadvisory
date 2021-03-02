<?php


namespace App;

use \Illuminate\Database\Eloquent\Model;
use stdClass;

/**
 * Class VendorsProjectAnalysis
 * @package App
 *
 * @property int $id
 * @property int $vendor_id
 * @property int $project_id
 * @property float $solution_fit
 * @property float $usability
 * @property float $performance
 * @property float $look_feel
 * @property float $others
 * @property float $total
 */

class VendorsProjectsAnalysis extends Model
{
    protected $table = 'vendors_projects_analysis';

    public static function getByVendorAndProject($vendorId, $projectId)
    {
        return VendorsProjectsAnalysis::where('vendor_id', '=', $vendorId)
            ->where('project_id', '=', $projectId)
            ->first();
    }

    public static function getByProject($projectId)
    {
        return VendorsProjectsAnalysis::where('project_id', '=', $projectId)
            ->get();
    }

    public static function getByVendor($vendorId)
    {
        return VendorsProjectsAnalysis::where('vendor_id', '=', $vendorId)
            ->get();
    }

    public static function getVendorIndexedByProject($projectId)
    {
        $analytics = VendorsProjectsAnalysis::where('project_id', '=', $projectId)
            ->get();
        $indexed = new stdClass();
        foreach ($analytics as $analysis) {
            $indexed->{$analysis->vendor_id} = $analysis;
        }

        return $indexed;
    }

    public static function vendorsEvaluated($regions = [], $years = [], $industries = [], $practices = [])
    {
        $vendorIds = VendorsProjectsAnalysis::select('vendor_id')
            ->distinct('vendor_id')
            ->join('projects', 'vendors_projects_analysis.project_id', '=', 'projects.id');

        if ($regions) {
            $vendorIds = $vendorIds->where(function ($vendorIds) use ($regions) {
                for ($i = 0; $i < count($regions); $i++) {
                    $vendorIds = $vendorIds->where('projects.regions', 'like', '%' . $regions[$i] . '%');
                }
            });
        }

        if ($years) {
            $vendorIds = $vendorIds->where(function ($vendorIds) use ($years) {
                for ($i = 0; $i < count($years); $i++) {
                    $vendorIds = $vendorIds->orWhere('projects.created_at', 'like', '%' . $years[$i] . '%');
                }
            });
        }

        if ($industries) {
            $vendorIds = $vendorIds->where(function ($vendorIds) use ($industries) {
                for ($i = 0; $i < count($industries); $i++) {
                    $vendorIds = $vendorIds->orWhere('projects.industry', '=', $industries[$i]);
                }
            });
        }

        if ($practices) {
            $vendorIds = $vendorIds->where(function ($vendorIds) use ($practices) {
                for ($i = 0; $i < count($practices); $i++) {
                    $vendorIds = $vendorIds->where('projects.practice_id', '=', $practices[$i]);
                }
            });
        }

        $vendorIds = $vendorIds->get();

        $vendors = [];
        foreach ($vendorIds as $vendorId) {
            $vendor = User::vendorUsers()->find($vendorId)->first();
            if ($vendor != null) {
                $vendors[] = $vendor;
            }
        }

        return $vendors;
    }

    public static function numberOfProjectsWithVendorsEvaluated($regions = [], $years = [], $industries = [], $practices = [])
    {
        $query = VendorsProjectsAnalysis::select('project_id')
            ->distinct('project_id')
            ->join('projects', 'vendors_projects_analysis.project_id', '=', 'projects.id');

        if ($regions) {
            $query = $query->where(function ($query) use ($regions) {
                for ($i = 0; $i < count($regions); $i++) {
                    $query = $query->where('projects.regions', 'like', '%' . $regions[$i] . '%');
                }
            });
        }

        if ($years) {
            $query = $query->where(function ($query) use ($years) {
                for ($i = 0; $i < count($years); $i++) {
                    $query = $query->orWhere('projects.created_at', 'like', '%' . $years[$i] . '%');
                }
            });
        }

        if ($industries) {
            $query = $query->where(function ($query) use ($industries) {
                for ($i = 0; $i < count($industries); $i++) {
                    $query = $query->orWhere('projects.industry', '=', $industries[$i]);
                }
            });
        }

        if ($practices) {
            $query = $query->where(function ($query) use ($practices) {
                for ($i = 0; $i < count($practices); $i++) {
                    $query = $query->where('projects.practice_id', '=', $practices[$i]);
                }
            });
        }

        return $query->get()->count();
    }

    public static function numberOfVendorsEvaluated($regions = [], $years = [], $industries = [], $practices = [])
    {
        $query = VendorsProjectsAnalysis::select('vendor_id')
            ->distinct('vendor_id')
            ->join('projects', 'vendors_projects_analysis.project_id', '=', 'projects.id');

        if ($regions) {
            $query = $query->where(function ($query) use ($regions) {
                for ($i = 0; $i < count($regions); $i++) {
                    $query = $query->where('projects.regions', 'like', '%' . $regions[$i] . '%');
                }
            });
        }

        if ($years) {
            $query = $query->where(function ($query) use ($years) {
                for ($i = 0; $i < count($years); $i++) {
                    $query = $query->orWhere('projects.created_at', 'like', '%' . $years[$i] . '%');
                }
            });
        }

        if ($industries) {
            $query = $query->where(function ($query) use ($industries) {
                for ($i = 0; $i < count($industries); $i++) {
                    $query = $query->orWhere('projects.industry', '=', $industries[$i]);
                }
            });
        }

        if ($practices) {
            $query = $query->where(function ($query) use ($practices) {
                for ($i = 0; $i < count($practices); $i++) {
                    $query = $query->where('projects.practice_id', '=', $practices[$i]);
                }
            });
        }

        return $query->get()->count();
    }
}
