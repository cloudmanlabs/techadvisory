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

    public static function findByIds($useCaseId, $clientId, $vendorId)
    {
        return VendorUseCasesEvaluation::where('use_case_id', '=', $useCaseId)
            ->where('client_id', '=', $clientId)
            ->where('vendor_id', '=', $vendorId)
            ->first();
    }
}
