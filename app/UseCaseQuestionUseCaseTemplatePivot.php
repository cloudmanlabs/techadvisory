<?php


namespace App;

/**
 * @property string $use_case_questions_id
 * @property string $use_case_templates_id
 *
 *
 */

use Illuminate\Database\Eloquent\Model;

class UseCaseQuestionUseCaseTemplatePivot extends Model
{
    public $guarded = [];

    public function question()
    {
        return $this->belongsTo(UseCaseQuestion::class, 'use_case_questions_id');
    }

    public function template()
    {
        return $this->belongsTo(UseCaseTemplate::class, 'use_case_templates_id');
    }
}
