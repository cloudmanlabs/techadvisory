<?php


namespace App;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class VendorUseCasesEvaluation
 * @package App
 *
 * @property int $id
 */

class VendorUseCasesEvaluation extends Model
{
    protected $table = 'vendor_use_cases_evaluation';

    public static function findByIdsAndType($useCaseId, $userCredential, $vendorId, $evaluationType)
    {
        return VendorUseCasesEvaluation::where('use_case_id', '=', $useCaseId)
            ->where('user_credential', '=', $userCredential)
            ->where('vendor_id', '=', $vendorId)
            ->where('evaluation_type', '=', $evaluationType)
            ->first();
    }

    public static function evaluationsSubmitted($userCredential, $useCaseId, $selectedVendors, $evaluationType)
    {

        foreach ($selectedVendors as $selectedVendor) {
            $evaluation = VendorUseCasesEvaluation::where('use_case_id', '=', $useCaseId)
                ->where('user_credential', '=', $userCredential)
                ->where('vendor_id', '=', $selectedVendor->id)
                ->where('evaluation_type', '=', $evaluationType)
                ->first();

            if ($evaluation->submitted === 'no') {
                return 'no';
            }
        }

        return 'yes';
    }

    public static function getUserCredentialsByUseCaseAndSubmittingState($useCaseId, $userType, $submitted)
    {
        return VendorUseCasesEvaluation::select('user_credential')
            ->where('use_case_id', '=', $useCaseId)
            ->where('evaluation_type', '=', $userType)
            ->where('submitted', '=', $submitted ? 'yes' : 'no')
            ->distinct('user_credential')
            ->get();
    }

    public static function getByVendorAndUseCase($vendorId, $useCaseId)
    {
        return VendorUseCasesEvaluation::where('use_case_id', '=', $useCaseId)
            ->where('vendor_id', '=', $vendorId)
            ->where('submitted', '=', 'yes')
            ->get();
    }

    public static function getGroupedByUseCaseAndVendor($useCasesIds, $vendorIds)
    {

        $groupsByProject = VendorUseCasesEvaluation::whereIn('use_case_id', $useCasesIds)
            ->whereIn('vendor_id', $vendorIds)
            ->where('submitted', '=', 'yes')
            ->orderBy('use_case_id', 'asc')
            ->orderBy('user_credential', 'asc')
            ->orderBy('vendor_id', 'asc')
            ->get()
            ->groupBy('use_case_id');

        $grouped = [];

        foreach ($groupsByProject as $key => $groupByProject) {
            $grouped[$key] = $groupByProject->groupBy('user_credential');
        }

        return $grouped;
    }

    public static function numberOfClientsThatEvaluatedVendors()
    {
        return VendorUseCasesEvaluation::select('user_credential')
            ->where('submitted', '=', 'yes')
            ->where('evaluation_type', '=', 'client')
            ->distinct('user_credential')
            ->get()
            ->count();
    }
}
