<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Class useCase
 * @package App
 *
 * @property int $id
 *
 * @property string $name
 * @property string $description
 * @property string $practice
 *
 * @property Collection $useCaseQuestions
 *
 * @property string $project
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

    public function useCaseQuestions()
    {
        return $this->hasMany(UseCaseQuestionResponse::class, 'use_case_id');
    }

    public static function findByProject($projectId)
    {
        return UseCase::where('project_id', '=', $projectId)->get();
    }

    public static function findById($userCaseId)
    {
        return UseCase::where('id', '=', $userCaseId);
    }
}
