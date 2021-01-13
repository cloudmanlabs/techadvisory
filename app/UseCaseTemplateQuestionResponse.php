<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * @property string $response
 *
 * @property UseCaseQuestion $originalQuestion
 * @property UseCaseTemplate $useCaseTemplate
 */

class UseCaseTemplateQuestionResponse extends Model
{
    public $guarded = [];

    public function originalQuestion()
    {
        return $this->belongsTo(UseCaseQuestion::class, 'use_case_questions_id');
    }

    public function useCaseTemplate()
    {
        return $this->belongsTo(UseCaseTemplate::class, 'use_case_templates_id');
    }

    public static function getResponsesFromUseCaseTemplate(UseCaseTemplate $useCaseTemplate)
    {
        return self::select('id', 'use_case_templates_id', 'use_case_questions_id', 'response')
            ->where('use_case_templates_id', '=', $useCaseTemplate->id)
            ->whereNotNull('response')
            ->get();
    }
}
