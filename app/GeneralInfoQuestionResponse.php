<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $response
 */
class GeneralInfoQuestionResponse extends Model
{
    public $guarded = [];

    public function originalQuestion()
    {
        return $this->belongsTo(GeneralInfoQuestion::class, 'question_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
