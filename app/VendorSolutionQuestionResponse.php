<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorSolutionQuestionResponse extends Model
{
    public $guarded = [];


    public function original()
    {
        return $this->belongsTo(VendorSolutionQuestion::class, 'question_id');
    }

    public function solution()
    {
        return $this->belongsTo(VendorSolution::class, 'solution_id');
    }
}
