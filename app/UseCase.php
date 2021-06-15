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

    // public static function clients($userCaseId)
    // {
    //     return VendorUseCasesEvaluation::where('use_case_id', '=', $userCaseId)->where('evaluation_type', '=', 'client')->pluck('user_credential')->unique();
    // }

    // public static function users($userCaseId)
    // {
    //     return VendorUseCasesEvaluation::where('use_case_id', '=', $userCaseId)->where('evaluation_type', '=', 'accenture')->pluck('user_credential')->unique();
    // }

    // public static function usersSubmittedPercentage($userCaseId)
    // {
    //     $all = count(VendorUseCasesEvaluation::where('use_case_id', '=', $userCaseId)->pluck('user_credential')->unique());
    //     $submitted = count(VendorUseCasesEvaluation::where('use_case_id', '=', $userCaseId)->where('submitted', '=', 'yes')->pluck('user_credential')->unique());
    //     return round(($submitted / $all) *100, 2);
    // }
}
