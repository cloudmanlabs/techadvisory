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

    public static function vendorsEvaluated()
    {
        $vendorIds = VendorsProjectsAnalysis::select('vendor_id')
            ->distinct('vendor_id')->get();

        $vendors = [];
        foreach ($vendorIds as $vendorId) {
            $vendor = User::vendorUsers()->find($vendorId)->first();
            if ($vendor != null) {
                $vendors[] = $vendor;
            }
        }

        return $vendors;
    }

    public static function numberOfProjectsWithVendorsEvaluated()
    {
        return VendorsProjectsAnalysis::select('project_id')
            ->distinct('project_id')
            ->get()
            ->count();
    }

    public static function numberOfVendorsEvaluated()
    {
        return VendorsProjectsAnalysis::select('vendor_id')
            ->distinct('vendor_id')
            ->get()
            ->count();
    }
}
