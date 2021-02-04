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
}
