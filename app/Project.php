<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Builder;

/**
 * @property string $name
 *
 * @property boolean $hasOrals
 * @property boolean $hasValueTargeting
 * @property boolean $isBinding
 *
 * @property integer $progressSetUp
 * @property integer $progressValue
 * @property integer $progressResponse
 * @property integer $progressAnalytics
 * @property integer $progressConclusions
 *
 * @property string $currentPhase
 */
class Project extends Model
{
    public $guarded = [];

    protected $dates = [
        'deadline'
    ];

    /**
     * List of fields that can be changed from a post request in the frontend
     */
    const fieldsChangableByPost = [
        'shortDescription',
        'clientContactEmail',
        'clientContactPhone',
        'accentureContactEmail',
        'accentureContactPhone',
        'projectType',
        'projectCurrency',
        'detailedDescription',
        'practiceSelect',
        'subpracticeSelect',
        'regionServed',
        'transportFlows',
        'transportMode',
        'transportType',
        'tentativeProjectSetUp',
        'tentativeValueEnablers',
        'tentativeVendorResponse',
        'tentativeAnalytics',
        'tentativeConclusions',
    ];

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

    public function practice()
    {
        return $this->belongsTo(Practice::class);
    }

    public function subpractices()
    {
        return $this->belongsToMany(Subpractice::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function generalInfoQuestions()
    {
        return $this->hasMany(GeneralInfoQuestionResponse::class, 'project_id');
    }





    /**
     * Returns all projects in Open Phase
     *
     * @return Builder
     */
    public static function openProjects(): Builder
    {
        return self::where('currentPhase', 'open');
    }

    /**
     * Returns all projects in Preparation Phase
     *
     * @return Builder
     */
    public static function preparationProjects(): Builder
    {
        return self::where('currentPhase', 'preparation');
    }

    /**
     * Returns all projects in Old Phase
     *
     * @return Builder
     */
    public static function oldProjects(): Builder
    {
        return self::where('currentPhase', 'old');
    }
}
