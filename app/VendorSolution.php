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
}
