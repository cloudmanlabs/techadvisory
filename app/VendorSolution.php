<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorSolution extends Model
{
    public $guarded = [];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function questions()
    {
        return $this->hasMany(VendorSolutionQuestionResponse::class, 'solution_id');
    }
}
