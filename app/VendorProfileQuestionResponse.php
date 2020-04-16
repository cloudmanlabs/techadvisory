<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorProfileQuestionResponse extends Model
{
    public $guarded = [];


    public function original()
    {
        return $this->belongsTo(VendorProfileQuestion::class, 'question_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
