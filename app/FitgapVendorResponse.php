<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpseclib\System\SSH\Agent\Identity;

/**
 * Class FitgapVendorResponse
 * @package App
 *
 * @property int $id
 * @property int $fitgapQuestionId
 *
 */
class FitgapVendorResponse extends Model
{
    public $guarded = [];

    protected $table = 'fitgap_vendor_responses';
}
