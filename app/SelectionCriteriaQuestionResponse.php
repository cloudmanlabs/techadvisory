<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $response
 * @property int $score
 */
class SelectionCriteriaQuestionResponse extends Model
{
    public $guarded = [];

    public function original()
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
