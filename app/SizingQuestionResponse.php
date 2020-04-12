<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $response
 * @property boolean $shouldShow
 */
class SizingQuestionResponse extends Model
{
    public $guarded = [];

    public $casts = [
        'shouldShow' => 'boolean'
    ];

    public function original()
    {
        return $this->belongsTo(SizingQuestion::class, 'question_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
