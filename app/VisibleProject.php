<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Class visibleProject
 * @package App
 *
 * @property int $id
 * @property int $user_credential_id
 * @property int $project_id
 */

class VisibleProject extends Model
{
    public $guarded = [];

    protected $table = 'visible_projects';

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function userCredential()
    {
        return $this->belongsTo(UserCredential::class, 'user_credential_id');
    }
}
