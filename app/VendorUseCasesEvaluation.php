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
        error_log('$useCaseId: '.$useCaseId);
        error_log('$userCredential: '.$userCredential);
        error_log('$vendorId: '.$vendorId);
        error_log('$evaluationType: '.$evaluationType);
        $evaluation = VendorUseCasesEvaluation::where('use_case_id', '=', $useCaseId)
            ->where('user_credential', '=', $userCredential)
            ->where('vendor_id', '=', $vendorId)
            ->where('evaluation_type', '=', $evaluationType)
            ->first();

        error_log($evaluation);
        return $evaluation;
    }
}
