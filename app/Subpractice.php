<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subpractice extends Model
{
    public $guarded = [];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function practice()
    {
        return $this->belongsTo(Practice::class);
    }

    public function solutions()
    {
        return $this->belongsToMany(VendorSolution::class);
    }
}
