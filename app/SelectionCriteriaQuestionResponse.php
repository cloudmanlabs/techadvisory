<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null $response
 * @property int $score
 *
 * @property SelectionCriteriaQuestion $originalQuestion
 * @property Project $project
 * @property User $vendor
 */
class SelectionCriteriaQuestionResponse extends Model
{
    public $guarded = [];

    public function originalQuestion()
    {
        return $this->belongsTo(SelectionCriteriaQuestion::class, 'question_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }


}
