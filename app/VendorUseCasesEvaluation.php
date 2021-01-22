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
}
