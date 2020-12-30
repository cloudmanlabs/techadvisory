<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * @property string|null $response
 *
 * @property UseCaseQuestion $originalQuestion
 * @property UseCase $useCase
 */

class UseCaseQuestionResponse extends Model
{
    public $guarded = [];

    public function originalQuestion()
    {
        return $this->belongsTo(UseCaseQuestion::class, 'use_case_questions_id');
    }

    public function useCase()
    {
        return $this->belongsTo(UseCase::class, 'use_case_id');
    }

    public static function getResponsesFromUseCase(UseCase $useCase)
    {
        return self::select('id', 'use_case_id', 'use_case_questions_id', 'response')
            ->where('use_case_id', '=', $useCase->id)
            ->whereNotNull('response')
            ->get();
    }
}
