<?php

namespace App;

use Guimcaballero\LaravelFolders\Models\Folder;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

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
 *
 * @property boolean $step4FinishedAccenture
 * @property boolean $step4FinishedClient
 *
 * @property array $scoringValues
 */
class Project extends Model
{
    public $guarded = [];

    protected $dates = [
        'deadline'
    ];

    protected $casts = [
        'step4FinishedAccenture' => 'boolean',
        'step4FinishedClient' => 'boolean',

        'scoringValues' => 'array'
    ];

    public function conclusionsFolder()
    {
        return $this->morphOne(Folder::class, 'folderable');
    }
    public function selectedValueLeversFolder()
    {
        return $this->morphOne(Folder::class, 'folderable');
    }
    public function businessOpportunityFolder()
    {
        return $this->morphOne(Folder::class, 'folderable');
    }
    public function vtConclusionsFolder()
    {
        return $this->morphOne(Folder::class, 'folderable');
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

    public function sizingQuestions()
    {
        return $this->hasMany(SizingQuestionResponse::class, 'project_id');
    }

    public function vendorApplications()
    {
        return $this->hasMany(VendorApplication::class, 'project_id');
    }

    /**
     * Returns the vendors applied to this project
     *
     * @param string[]|null $phase
     * @return void
     */
    public function vendorsApplied($phase = null)
    {
        return User::vendorUsers()
                ->whereHas('vendorApplications', function (Builder $query) use ($phase) {
                    if ($phase == null) {
                        $query->where('project_id', $this->id);
                    } else {
                        $query->where('project_id', $this->id)->whereIn('phase', $phase);
                    }
                });
    }


    public function selectionCriteriaQuestionsPivots()
    {
        return $this->hasMany(SelectionCriteriaQuestionProjectPivot::class, 'project_id');
    }

    public function selectionCriteriaQuestionsOriginals()
    {
        $questionIds = SelectionCriteriaQuestionProjectPivot::where('project_id', $this->id)->pluck('question_id')->toArray();
        $uniqueIds = array_values(array_unique($questionIds));

        return SelectionCriteriaQuestion::find($uniqueIds);
    }

    public function selectionCriteriaQuestions()
    {
        return $this->hasMany(SelectionCriteriaQuestionResponse::class, 'project_id');
    }

    public function selectionCriteriaQuestionsForVendor(User $vendor)
    {
        return $this->hasMany(SelectionCriteriaQuestionResponse::class, 'project_id')->where('vendor_id', $vendor->id);
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
