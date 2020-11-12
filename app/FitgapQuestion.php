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
 * @property string $level1
 * @property string $level2
 * @property string $level3
 *
 * @property string $client
 * @property string $businessOpportunity
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

}
