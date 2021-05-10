<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Class fitgapLevelWeight
 * @package App
 *
 * @property int $id
 *
 * @property string $name
 *
 * @property string $project
 *
 */

class FitgapLevelWeight extends Model
{
    public $guarded = [];

    protected $table = 'fitgap_level_weights';

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public static function deleteByProject($projectId)
    {
        FitgapLevelWeight::where('project_id', '=', $projectId)->delete();
    }
}
