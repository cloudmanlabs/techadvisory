<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    public $guarded = [];

    /**
     * Get the Users from the Owner.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Get the projects from the Owner.
     */
    public function projects()
    {
        return $this->hasMany('App\Project');
    }

}
