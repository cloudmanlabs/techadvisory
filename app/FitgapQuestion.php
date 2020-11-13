<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Class FitgapVendorResponse
 * @package App
 *
 * @property int $id
 * @property int $position
 *
 * @property string $requirement_type
 * @property string $level_1
 * @property string $level_2
 * @property string $level_3
 * @property string $requirement
 *
 * @property string $client
 * @property string $business_opportunity
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

    public function requirement()
    {
        return $this->requirement;
    }

    public function requirementType()
    {
        return $this->requirement_type;
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

    public function client()
    {
        // name changed
        return $this->client;
    }

    public function businessOpportunity()
    {
        return $this->business_opportunity;
    }

    public static function deleteByProject($projectId)
    {
        FitgapQuestion::where('project_id', '=', $projectId)->delete();

    }

    public static function findByProject($projectId)
    {
        return FitgapQuestion::where('project_id', '=', $projectId)
            ->orderBy('position', 'asc')
            ->get();

    }

}
