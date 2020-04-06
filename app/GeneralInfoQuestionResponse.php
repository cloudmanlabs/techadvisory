<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralInfoQuestionResponse extends Model
{
    public $guarded = [];

    public function original()
    {
        return $this->belongsTo(GeneralInfoQuestion::class, 'question_id');
    }
}
