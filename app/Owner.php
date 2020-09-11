<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * @property string $name
 * Class Owner
 * @package App
 */
class Owner extends Model
{
    public $guarded = [];
    protected $table = 'owners';

    public static $title = 'name';

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
