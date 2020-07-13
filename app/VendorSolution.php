<?php

namespace App;

use Guimcaballero\LaravelFolders\Models\Folder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Practice|null $practice
 */
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

    public function practice()
    {
        return $this->belongsTo(Practice::class, 'practice_id');
    }
}
