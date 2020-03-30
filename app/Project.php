<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 *
 * @property boolean $hasOrals
 * @property boolean $hasValueTargeting
 *
 * @property integer $progressSetUp
 * @property integer $progressValue
 * @property integer $progressResponse
 * @property integer $progressAnalytics
 * @property integer $progressConclusions
 */
class Project extends Model
{
    public $guarded = [];

    public function conclusionsFolder()
    {
        return $this->morphTo(Folder::class, 'folderable');
    }
    public function selectedValueLeversFolder()
    {
        return $this->morphTo(Folder::class, 'folderable');
    }
    public function businessOpportunityFolder()
    {
        return $this->morphTo(Folder::class, 'folderable');
    }
    public function vtConclusionsFolder()
    {
        return $this->morphTo(Folder::class, 'folderable');
    }
}
