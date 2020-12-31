<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Class useCase
 * @package App
 *
 * @property int $id
 *
 * @property string $name
 * @property string $description
 * @property string $expected_results
 * @property string $practice
 * @property string $question1
 * @property string $question2
 * @property string $question3
 * @property string $phase
 *
 */
class UseCase extends Model
{
    public $guarded = [];

    protected $table = 'use_case';

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function template()
    {
        return $this->belongsTo(UseCaseTemplate::class, 'template_id');
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

//    public function description()
//    {
//        return $this->description;
//    }
//
//    public function expectedResults()
//    {
//        return $this->expected_results;
//    }
//
//    public static function deleteByProject($projectId)
//    {
//        UseCase::where('project_id', '=', $projectId)->delete();
//    }
//
    public static function findByProject($projectId)
    {
        return UseCase::where('project_id', '=', $projectId)->get();
    }

    public static function findById($userCaseId)
    {
        return UseCase::where('id', '=', $userCaseId);
    }
}
