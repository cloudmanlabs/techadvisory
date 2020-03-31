<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 */
class Practice extends Model
{
    public $guarded = [];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
