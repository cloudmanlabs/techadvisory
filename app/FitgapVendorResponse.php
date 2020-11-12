<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpseclib\System\SSH\Agent\Identity;

/**
 * Class FitgapVendorResponse
 * @package App
 *
 * @property int $id
 * @property int $fitgap_question_id
 * @property int $vendor_application_id
 * @property string $response
 * @property string $comments
 * @property int $score
 *
 */
class FitgapVendorResponse extends Model
{
    public $guarded = [];

    protected $table = 'fitgap_vendor_responses';

    public function question()
    {
        return $this->belongsTo(FitgapQuestion::class, 'fitgap_question_id');
    }

    public function vendorApplication()
    {
        return $this->belongsTo(VendorApplication::class, 'vendor_application_id');
    }

    public function response()
    {
        return $this->response;
    }

    public function comments()
    {
        return $this->comments;
    }

    public function score()
    {
        return $this->score;
    }
}
