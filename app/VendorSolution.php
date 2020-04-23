<?php

namespace App;

use Guimcaballero\LaravelFolders\Models\Folder;
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

    public function folder()
    {
        return $this->morphOne(Folder::class, 'folderable');
    }
}
