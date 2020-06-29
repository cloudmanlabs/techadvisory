<?php

namespace App;

use Guimcaballero\LaravelFolders\Models\Folder;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * @property string $name
 *
 * @property boolean $hasOrals
 * @property boolean $hasValueTargeting
 * @property boolean $isBinding
 *
 * @property boolean $publishedAnalytics
 *
 * @property array $regions
 * @property string $industry
 *
 * @property string $currentPhase
 *
 * @property boolean $step3SubmittedAccenture
 * @property boolean $step3SubmittedClient
 * @property boolean $step4SubmittedAccenture
 * @property boolean $step4SubmittedClient
 *
 * @property array $scoringValues
 * @property string $rfpOtherInfo
 *
 * @property array $fitgap5Columns
 * @property array $fitgapClientColumns
 *
 * @property integer $fitgapWeightMust
 * @property integer $fitgapWeightRequired
 * @property integer $fitgapWeightNiceToHave
 *
 * @property integer $fitgapWeightFullySupports
 * @property integer $fitgapWeightPartiallySupports
 * @property integer $fitgapWeightPlanned
 * @property integer $fitgapWeightNotSupported
 *
 * @property integer $fitgapFunctionalWeight
 * @property integer $fitgapTechnicalWeight
 * @property integer $fitgapServiceWeight
 * @property integer $fitgapOthersWeight
 *
 * @property integer $implementationImplementationWeight
 * @property integer $implementationRunWeight
 *
 * @property \Carbon\Carbon $deadline
 * @property \Carbon\Carbon $oralsFromDate
 * @property \Carbon\Carbon $oralsToDate
 */
class Project extends Model
{
    public $guarded = [];

    protected $dates = [
        'deadline',
        'oralsFromDate',
        'oralsToDate'
    ];

    protected $casts = [
        'step3SubmittedAccenture' => 'boolean',
        'step3SubmittedClient' => 'boolean',
        'step4SubmittedAccenture' => 'boolean',
        'step4SubmittedClient' => 'boolean',

        'publishedAnalytics' => 'boolean',
        'hasOrals' => 'boolean',
        'hasValueTargeting' => 'boolean',
        'isBinding' => 'boolean',

        'scoringValues' => 'array',
        'fitgap5Columns' => 'array',
        'fitgapClientColumns' => 'array',
        'regions' => 'array',
    ];

    public function conclusionsFolder()
    {
        return $this->morphOne(Folder::class, 'folderable')->where('folderable_group', 'conclusions');
    }

    public function hasValueTargetingFiles()
    {
        return
            $this->selectedValueLeversFolder->hasFiles() ||
            $this->businessOpportunityFolder->hasFiles() ||
            $this->vtConclusionsFolder->hasFiles();
    }

    public function hasValueTargetingFilesInEach()
    {
        return
            $this->selectedValueLeversFolder->hasFiles() &&
            $this->businessOpportunityFolder->hasFiles() &&
            $this->vtConclusionsFolder->hasFiles();
    }

    public function hasConclusionFiles()
    {
        return
            $this->conclusionsFolder->hasFiles();
    }

    /**
     * Returns if all the rows in Fitgap have a value in Business Opportunity
     *
     * @return boolean
     */
    public function hasCompletedBusinessOpportunity()
    {
        foreach (($this->fitgapClientColumns ?? []) as $key => $value) {
            if (!isset($value['Business Opportunity']) || $value['Business Opportunity'] == null || $value['Business Opportunity'] == '') return false;
        }
        return true;
    }

    public function hasSentOrals()
    {
        foreach ($this->vendorApplications as $key => $application) {
            if ($application->invitedToOrals) {
                return true;
            }
            if ($application->oralsCompleted) {
                return true;
            }
        }
        return false;
    }

    public function selectedValueLeversFolder()
    {
        return $this->morphOne(Folder::class, 'folderable')->where('folderable_group', 'selectedValueLevers');
    }
    public function businessOpportunityFolder()
    {
        return $this->morphOne(Folder::class, 'folderable')->where('folderable_group', 'businessOpportunity');
    }
    public function vtConclusionsFolder()
    {
        return $this->morphOne(Folder::class, 'folderable')->where('folderable_group', 'vtConclusions');
    }
    public function rfpFolder()
    {
        return $this->morphOne(Folder::class, 'folderable')->where('folderable_group', 'rfp');
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

    public function generalInfoQuestionsInPage(string $page)
    {
        return $this->generalInfoQuestions->filter(function (GeneralInfoQuestionResponse $response) use ($page) {
            return $response->originalQuestion->page == $page;
        });
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
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function vendorsApplied($phase = null): \Illuminate\Database\Eloquent\Builder
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




    public function progress()
    {
        return $this->progressSetUp() +
            $this->progressValue() +
            $this->progressResponse() +
            $this->progressAnalytics() +
            $this->progressConclusions();
    }

    public function progressSetUp()
    {
        $score = 0;
        if ($this->step3SubmittedAccenture) $score += 5;
        if ($this->step4SubmittedAccenture) $score += 10;
        if ($this->step3SubmittedClient) $score += 10;
        if ($this->step4SubmittedClient) $score += 10;
        if ($this->currentPhase == 'open') {
            if ($this->hasValueTargeting) $score += 5;
            else $score += 25;
        }

        return $score;
    }

    public function progressValue()
    {
        $score = 0;
        if ($this->hasValueTargeting) {
            if ($this->hasValueTargetingFilesInEach()) {
                $score += 10;
            }

            if ($this->hasCompletedBusinessOpportunity()) {
                $score += 10;
            }
        }
        return $score;
    }

    public function progressResponse()
    {
        $score = 0;

        if ($this->vendorsApplied(['pendingEvaluation', 'evaluated', 'submitted'])->count() > 0) {
            $score += 15;
        }

        if ($this->vendorsApplied(['submitted'])->count() > 0) {
            $score += 10;
        }

        return $score;
    }

    public function progressAnalytics()
    {
        $score = 0;

        if($this->hasOrals){
            if ($this->publishedAnalytics) {
                $score += 5;
            }

            if ($this->hasSentOrals()) {
                $score += 5;
            }
        } else {
            if ($this->publishedAnalytics) {
                $score += 10;
            }
        }

        return $score;
    }

    public function progressConclusions()
    {
        $score = 0;
        if ($this->hasConclusionFiles()) {
            $score += 5;
        }
        return $score;
    }






    /**
     * Returns the minimum Implementation cost of all the vendors in this Project
     *
     * @throws \Exception
     * @return int
     */
    public function minImplementationCost() : int
    {
        return $this->vendorApplications->map(function (VendorApplication $application) {
            return $application->averageImplementationCost();
        })->min();
    }

    /**
     * Returns the minimum Run cost of all the vendors in this Project
     *
     * @throws \Exception
     * @return int
     */
    public function minRunCost() : int
    {
        return $this->vendorApplications->map(function (VendorApplication $application) {
            return $application->averageRunCost();
        })->min();
    }












    public function publish()
    {
        $this->currentPhase = 'open';
        $this->save();

        return $this;
    }






    /**
     * Returns all projects in Open Phase
     *
     * @return Collection
     */
    public static function openProjects(): Collection
    {
        return self::where('currentPhase', 'open')
            ->get()
            ->filter(function (Project $project) {
                return $project->progress() != 100;
            });
    }

    /**
     * Returns all projects in Preparation Phase
     *
     * @return Collection
     */
    public static function preparationProjects(): Collection
    {
        return self::where('currentPhase', 'preparation')->get();
    }

    /**
     * Returns all projects in Old Phase
     *
     * @return Collection
     */
    public static function oldProjects(): Collection
    {
        return self::all()
            ->filter(function(Project $project){
                return $project->progress() == 100 || $project->currentPhase == 'old';
            });
    }
}
