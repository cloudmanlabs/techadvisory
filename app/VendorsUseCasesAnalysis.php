<?php


namespace App;

use \Illuminate\Database\Eloquent\Model;

/**
 * Class VendorsUseCasesAnalysis
 * @package App
 *
 * @property int $id
 * @property int $vendor_id
 * @property int $use_case_id
 * @property int $project_id
 * @property float $solution_fit
 * @property float $usability
 * @property float $performance
 * @property float $look_feel
 * @property float $others
 * @property float $total
 */

class VendorsUseCasesAnalysis extends Model
{
    protected $table = 'vendors_use_cases_analysis';

    public static function getByVendorUseCaseAndProject($vendorId, $useCaseId, $projectId)
    {
        return VendorsUseCasesAnalysis::where('use_case_id', '=', $useCaseId)
            ->where('vendor_id', '=', $vendorId)
            ->where('project_id', '=', $projectId)
            ->first();
    }

    public static function getGroupedByProjectAndVendor($projectId, $selectedUseCases = null)
    {

        $groupsByProject = VendorsUseCasesAnalysis::where('project_id', '=', $projectId);
        if($selectedUseCases) {
            $groupsByProject = $groupsByProject->whereIn('use_case_id', $selectedUseCases);
        }

        $groupsByProject = $groupsByProject->get()->groupBy('project_id');

        foreach ($groupsByProject as $groupByProject) {
            $grouped = $groupByProject->groupBy('vendor_id');
        }

        return $grouped;
    }
}
