<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FitgapVendorResponse
 * @package App
 *
 * @property int $id
 * @property int $position
 *
 * @property string $requirementType
 * @property string $level_1
 * @property string $level_2
 * @property string $level_3
 *
 * @property string $client
 * @property string $business_Opportunity
 *
 */
class FitgapQuestion extends Model
{
    public $guarded = [];

    protected $table = 'fitgap_questions';

    protected $optionsRequirementType = [
        'Functional',
        'Technical',
        'Service',
        'Others',
    ];

    protected $optionsBusinessOpportinity = [
        'YES',
        'NO'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function position()
    {
        return $this->position;
    }

    public function level1()
    {
        return $this->level_1;
    }

    public function level2()
    {
        return $this->level_2;
    }

    public function level3()
    {
        return $this->level_3;
    }

    public function clientResponse()
    {
        return $this->client;
    }

    public function businessOpportunity()
    {
        return $this->business_Opportunity;
    }

}
