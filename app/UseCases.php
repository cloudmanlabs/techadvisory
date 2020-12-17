<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Class useCases
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
class UseCases extends Model
{
    public $guarded = [];

    protected $table = 'use_cases';

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
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
//    public function question1()
//    {
//        return $this->question1;
//    }
//
//    public function question2()
//    {
//        return $this->question2;
//    }
//
//    public function question3()
//    {
//        return $this->question3;
//    }
//
//    public function phase()
//    {
//        return $this->phase;
//    }

//    public static function deleteByProject($projectId)
//    {
//        UseCases::where('project_id', '=', $projectId)->delete();
//    }
//
    public static function findByProject($projectId)
    {
        return UseCases::where('project_id', '=', $projectId)->get();
    }

    public static function findById($userCaseId)
    {
        return UseCases::where('id', '=', $userCaseId);
    }
}
