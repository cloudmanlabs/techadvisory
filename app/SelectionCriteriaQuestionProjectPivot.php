<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelectionCriteriaQuestionProjectPivot extends Model
{
    public $guarded = [];

    public function question()
    {
        return $this->belongsTo(SelectionCriteriaQuestion::class, 'question_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
