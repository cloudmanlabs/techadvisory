<?php

namespace App;

use Guimcaballero\LaravelFolders\Models\Folder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * @property string $name
 *
 * @property User|null $client
 * @property Collection $generalInfoQuestions
 *
 * @property boolean $hasOrals
 * @property boolean $hasValueTargeting
 * @property boolean $isBinding
 *
 * @property boolean $publishedAnalytics
 *
 * @property array $regions
 * @property string $industry
 * @property string $currency
 *
 * @property string $currentPhase
 *
 * @property boolean $step3SubmittedAccenture
 * @property boolean $step3SubmittedClient
 * @property boolean $step4SubmittedAccenture
 * @property boolean $step4SubmittedClient
 *
 * @property bool $hasUploadedFitgap
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
 *
 * @property string $useCases
 * @property string $useCasesPhase
 * @property string $fitgapLevelWeights
 */
class Project extends Model
{
    public $guarded = [];

    protected $dates = [
        'deadline',
        'oralsFromDate',
        'oralsToDate',
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

    public $attributes = [
        'timezone' => 'UTC',
        'currency' => 'USD',

        'fitgapWeightMust' => 10,
        'fitgapWeightRequired' => 5,
        'fitgapWeightNiceToHave' => 1,
        'fitgapWeightFullySupports' => 3,
        'fitgapWeightPartiallySupports' => 2,
        'fitgapWeightPlanned' => 1,
        'fitgapWeightNotSupported' => 0,

        'fitgapFunctionalWeight' => 60,
        'fitgapTechnicalWeight' => 20,
        'fitgapServiceWeight' => 10,
        'fitgapOthersWeight' => 10,

        'implementationImplementationWeight' => 20,
        'implementationRunWeight' => 80,
    ];

    /**
     * Get the owner from this project.
     */
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'id')->first();
    }

    /**
     * @return BelongsTo
     */
    public function owners()
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'id');
    }

    // Alias for Owner
    public function organization()
    {
        return $this->owner();
    }

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
        $fitgapQuestions = FitgapQuestion::findByProject($this->project_id);
        foreach (($fitgapQuestions) as $key => $value) {
            if (!empty($value->businessOpportunity()) || $value->businessOpportunity() == null || $value->businessOpportunity() == '') {
                return false;
            }
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
     * @param  string[]|null  $phase
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

    /**
     * @return mixed
     */
    public function selectionCriteriaQuestionsOriginals()
    {
        $questionIds = SelectionCriteriaQuestionProjectPivot::where('project_id', $this->id)
            ->pluck('question_id')->toArray();
        $uniqueIds = array_values(array_unique($questionIds));

        return SelectionCriteriaQuestion::find($uniqueIds);
    }

    public function useCases()
    {
        return $this->hasMany(UseCase::class, 'project_id');
    }

    public function fitgapLevelWeights()
    {
        return $this->hasMany(FitgapLevelWeight::class, 'project_id');
    }

    /**
     * WARNING: THIS FKN METHOD RETURNS THE RESPONSES, NOT THE QUESTIONS...
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function selectionCriteriaQuestions()
    {
        return $this->hasMany(SelectionCriteriaQuestionResponse::class, 'project_id');
    }

    public function fitgapQuestions()
    {
        return $this->hasMany(FitgapQuestion::class, 'project_id');
    }

    public function fitgapQuestionsOrderByPosition()
    {
        $fitgapQuestions = $this->hasMany(FitgapQuestion::class, 'project_id');
        $fitgapQuestions = $fitgapQuestions->orderBy('position', 'asc');

        return $fitgapQuestions;
    }

    /**
     * METHOD FOR NOVA
     * The questions that are NOT linked to the project yet, in order to select them.
     * @return array Array of questions: [question id] => question label
     */
    public function selectionCriteriaQuestionsAvailablesForMe()
    {
        $allQuestionsIDasArray =
            SelectionCriteriaQuestion::all('id')->pluck('id')->toArray();
        $mySelectionCriteriaQuestionsIDs =
            $this->selectionCriteriaQuestionsOriginals()->pluck('id')->toArray();

        if ($allQuestionsIDasArray) {
            foreach ($allQuestionsIDasArray as $key => $question) {
                if (in_array($question, $mySelectionCriteriaQuestionsIDs)) {
                    // Question repetida. Delete
                    unset($allQuestionsIDasArray[$key]);
                }
            }
        }

        // Only for Nova Structure: [question id] => question label
        $questionsStructureForNova = [];
        foreach ($allQuestionsIDasArray as $question) {
            $selectionCriteriaQuestion = SelectionCriteriaQuestion::find($question);
            $questionsStructureForNova[$selectionCriteriaQuestion->id] = $selectionCriteriaQuestion->label;
        }

        return $questionsStructureForNova;
    }

    public function selectionCriteriaQuestionsForVendor(User $vendor)
    {
        return $this->hasMany(SelectionCriteriaQuestionResponse::class, 'project_id')->where('vendor_id', $vendor->id);
    }

    public function getVendorCorporateResponses($vendor)
    {
        $questions_ids = $this->hasMany(SelectionCriteriaQuestionResponse::class, 'project_id')
            ->where('vendor_id', $vendor->id);
    }

    // Sorry for this ??????
    public function shortDescription()
    {
        return optional($this->generalInfoQuestions()->whereHas('originalQuestion', function ($query) {
            return $query->where('label', 'Short Description');
        })->first())->response;
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
        if ($this->step3SubmittedAccenture) {
            $score += 5;
        }
        if ($this->step4SubmittedAccenture) {
            $score += 10;
        }
        if ($this->step3SubmittedClient) {
            $score += 10;
        }
        if ($this->step4SubmittedClient) {
            $score += 10;
        }
        if ($this->currentPhase == 'open' || $this->currentPhase == 'old') {
            if ($this->hasValueTargeting) {
                $score += 5;
            } else {
                $score += 25;
            }
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

        if ($this->hasOrals) {
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

    public function getResponsesFromQuestionsOfSimilarProjectOfSameVendor()
    {
        $responses = $this->select('selection_criteria_question_responses.response', 'projects.id')
            ->join('selection_criteria_question_responses as scqr', 'scqr.project_id', 'projects.id')
            ->get();

        return $responses;
    }

    /**
     * Returns the minimum Implementation cost of all the vendors in this Project
     *
     * @return float
     * @throws \Exception
     */
    public function minImplementationCost(): float
    {
        return $this->vendorApplications
                ->filter(function (VendorApplication $application) {
                    return $application->phase == 'submitted';
                })
                ->map(function (VendorApplication $application) {
                    return $application->implementationCost();
                })
                ->min() ?? 0;
    }

    /**
     * Returns the minimum Run cost of all the vendors in this Project
     *
     * @return float
     * @throws \Exception
     */
    public function minRunCost(): float
    {
        return $this->vendorApplications
                ->filter(function (VendorApplication $application) {
                    return $application->phase == 'submitted';
                })
                ->map(function (VendorApplication $application) {
                    return $application->averageRunCost();
                })
                ->min() ?? 0;
    }

    public function publish()
    {
        $this->currentPhase = 'open';
        $this->save();

        return $this;
    }

    public function setInEvaluationPhase()
    {
        $this->useCasesPhase = 'evaluation';
        $this->save();

        return $this;
    }

    public function markCompleted()
    {
        $this->currentPhase = 'old';
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
        return self::where('currentPhase', 'open')->get();
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
        return self::where('currentPhase', 'old')->get();
    }

    public static function projectsFromMyRegion($myRegion, $currentPhase): Collection
    {
        $myRegionAsText = config('arrays.regions')[$myRegion];

        return self::where('currentPhase', $currentPhase)
            ->where('regions', 'like', '%'.$myRegionAsText.'%')->get();
    }

    /**
     * @param $currentPhase String Project phase. 'old','preparation' or 'open'
     * @param $owner_id int
     * @return Collection
     */
    public static function organizationProjectsInPhase(string $currentPhase, int $owner_id): Collection
    {
        return Project::where('currentPhase', $currentPhase)
            ->where('owner_id', '=', $owner_id)->get();
    }

    // Methods for benchmark *******************************************************************

    /**
     * Returns an object collection as
     *  'years' => year (as string),
     *  'projectCount' => Number of projects from this year. Can search by null industry too.
     * @param  array  $regions
     * @param  array  $years
     * @return Collection
     */
    public static function calculateProjectsPerYears()
    {
        return collect(range(2017, intval(date('Y'))))->map(function ($year) {
            return (object) [
                'year' => $year,
                'projectCount' => Project::all()->filter(function ($project) use ($year) {
                    return $project->created_at->year == $year;
                })->count(),
            ];
        });
    }

    /**
     * Returns an object collection as
     *  'years' => year (as string),
     *  'projectCount' => Number of projects from this year. Can search by null industry too.
     * Supports Historical Filters
     * @param  array  $industries
     * @param  array  $regions
     * @param  array  $practices
     * @return Collection
     */
    public static function calculateProjectsPerYearsHistoricalFiltered($industries = [], $regions = [])
    {
        return collect(range(2017, intval(date('Y'))))
            ->map(function ($year) use ($industries, $regions) {
                return (object) [
                    'year' => $year,
                    'projectCount' => Project::getProjectCountfromYear($year, $industries, $regions),
                ];
            });
    }

    private static function getProjectCountfromYear($year, $industries = [], $regions = [])
    {
        $query = Project::select('id', 'currentPhase', 'industry', 'practice_id', 'regions', 'created_at');
        $query = Project::benchmarkOverviewHistoricalFilters($query, $industries, $regions);

        $query = $query->get()
            ->filter(function ($project) use ($year) {
                return $project->created_at->year == $year;
            })->count();

        return $query;
    }

    /**
     * Returns an object collection as
     *  'years' => year (as string),
     *  'projectCount' => Number of projects from this year with the practice provided.
     * Supports Historical Filters
     * @param $practiceId
     * @param  array  $industries
     * @param  array  $regions
     * @return Collection
     */
    public static function calculateProjectsPerYearsHistoricalFilteredByPractice(
        $practiceId,
        $industries = [],
        $regions = []
    ) {
        return collect(range(2017, intval(date('Y'))))
            ->map(function ($year) use ($practiceId, $industries, $regions) {
                return (object) [
                    'year' => $year,
                    'projectCount' =>
                        Project::getProjectCountFromYearByPractice($practiceId, $year, $industries, $regions),
                ];
            });
    }

    private static function getProjectCountFromYearByPractice($practiceId, $year, $industries = [], $regions = [])
    {
        $query = Project::select('id', 'currentPhase', 'industry', 'practice_id', 'regions', 'created_at');
        $query = Project::benchmarkOverviewHistoricalFilters($query, $industries, $regions, $practiceId);

        $query = $query->get()
            ->filter(function ($project) use ($year) {
                return $project->created_at->year == $year;
            })->count();

        return $query;
    }

    /**
     * Returns an object collection as
     *  'name' => industry name,
     *  'projectCount' => Number of projects with this industry. Can search by null industry too.
     * Supports possible filters by region and years.
     * @param  array  $regions
     * @param  array  $years
     * @return Collection
     */
    public static function calculateProjectsPerIndustry($regions = [], $years = [])
    {
        return collect(config('arrays.industryExperience'))->map(function ($industry)
        use ($regions, $years) {
            return (object) [
                'name' => $industry,
                'projectCount' => Project::getProjectCountFromIndustry($industry, $regions, $years),
            ];
        });
    }

    private static function getProjectCountFromIndustry($industry, $regions = [], $years = [])
    {
        $query = Project::select('id', 'currentPhase', 'industry', 'practice_id', 'regions', 'created_at');
        $query = $query->where('currentPhase', '=', 'old');
        $query = $query->whereHas('vendorApplications', function (Builder $query) {
            $query->where('phase', 'submitted');
        });
        $query = Project::benchmarkOverviewFilters($query, $regions, $years);

        $query = $query->get()->filter(function (Project $project) use ($industry) {
            return $project->industry == $industry;
        })->count();

        return $query;
    }

    // Encapsulate the filters for graphics from view: Overview - general
    private static function benchmarkOverviewFilters($query, $regions = [], $years = [])
    {
        //$query = $query->where('currentPhase','=','old');

        if ($regions) {
            $query = $query->where(function ($query) use ($regions) {
                for ($i = 0; $i < count($regions); $i++) {
                    $query = $query->where('regions', 'like', '%'.$regions[$i].'%');
                }
            });
        }

        if ($years) {
            $query = $query->where(function ($query) use ($years) {
                for ($i = 0; $i < count($years); $i++) {
                    $query = $query->orWhere('created_at', 'like', '%'.$years[$i].'%');
                }
            });
        }

        return $query;
    }

    // Encapsulate the filters for graphics from view: Overview - Historical
    private static function benchmarkOverviewHistoricalFilters($query, $industries = [], $regions = [], $practice = [])
    {
        $query = $query->where('currentPhase', '=', 'old');

        if ($industries) {
            $query = $query->where(function ($query) use ($industries) {
                for ($i = 0; $i < count($industries); $i++) {
                    $query = $query->orWhere('industry', '=', $industries[$i]);
                }
            });
        }

        if ($regions) {
            $query = $query->where(function ($query) use ($regions) {
                for ($i = 0; $i < count($regions); $i++) {
                    $query = $query->where('regions', 'like', '%'.$regions[$i].'%');
                }
            });
        }

        // Single type select.
        if ($practice) {
            $practice = intval($practice);
            $query = $query->where(function ($query) use ($practice) {
                $query = $query->orWhere('practice_id', '=', $practice);
            });
        }

        return $query;
    }

    // Encapsulate the filters for graphics from all views from project results
    public static function benchmarkProjectResultsFilters(
        $query,
        $practicesID = [],
        $subpracticesID = [],
        $years = [],
        $industries = [],
        $regions = []
    ) {
        // Applying user filters to projects
        if ($practicesID) {
            $query = $query->where(function ($query) use ($practicesID) {
                for ($i = 0; $i < count($practicesID); $i++) {
                    $query = $query->orWhere('practice_id', '=', $practicesID[$i]);
                }
            });
        }
        /*        if (is_array($subpracticesID)) {
                    $query = $query->where(function ($query) use ($subpracticesID) {
                        for ($i = 0; $i < count($subpracticesID); $i++) {
                            $query = $query->orWhere('sub.subpractice_id', '=', $subpracticesID[$i]);
                        }
                    });
                }*/

        /*       if ($years) {
                   $query = $query->where(function ($query) use ($years) {
                       for ($i = 0; $i < count($years); $i++) {
                           $query = $query->orWhere('p.created_at', 'like', '%' . $years[$i] . '%');
                       }
                   });
               }
               if ($industries) {
                   $query = $query->where(function ($query) use ($industries) {
                       for ($i = 0; $i < count($industries); $i++) {
                           $query = $query->orWhere('p.industry', '=', $industries[$i]);
                       }
                   });
               }
               if ($regions) {
                   $query = $query->where(function ($query) use ($regions) {
                       for ($i = 0; $i < count($regions); $i++) {
                           $query = $query->orWhere('p.regions', 'like', '%' . $regions[$i] . '%');
                       }
                   });
               }*/

        return $query;
    }

    public function getVendorCorporateQuestions(User $vendor)
    {
        return $this->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) {
                $query->where('practice_id', '=', $this->practice_id)->orWhere('practice_id', '=', null);
            })
            ->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'vendor_corporate';
            });
    }

    public function getVendorMarketQuestions(User $vendor)
    {
        return $this->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) {
                $query->where('practice_id', '=', $this->practice_id)
                    ->orWhere('practice_id', '=', null);
            })
            ->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'vendor_market';
            });
    }

    public function getExperienceQuestions(User $vendor)
    {
        return $this->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) {
                $query->where('practice_id', '=', $this->practice_id)
                    ->orWhere('practice_id', '=', null);
            })
            ->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'experience';
            });
    }

    public function getInnovationDigitalEnablersQuestions(User $vendor)
    {
        return $this->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) {
                $query->where('practice_id', '=', $this->practice_id)
                    ->orWhere('practice_id', '=', null);
            })
            ->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'innovation_digitalEnablers';
            });
    }

    public function getInnovationAlliancesQuestions(User $vendor)
    {
        return $this->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) {
                $query->where('practice_id', '=', $this->practice_id)
                    ->orWhere('practice_id', '=', null);
            })
            ->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'innovation_alliances';
            });
    }

    public function getInnovationProductQuestions(User $vendor)
    {
        return $this->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) {
                $query->where('practice_id', '=', $this->practice_id)
                    ->orWhere('practice_id', '=', null);
            })
            ->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'innovation_product';
            });
    }

    public function getInnovationSustainabilityQuestions(User $vendor)
    {
        return $this->selectionCriteriaQuestionsForVendor($vendor)
            ->whereHas('originalQuestion', function ($query) {
                $query->where('practice_id', '=', $this->practice_id)
                    ->orWhere('practice_id', '=', null);
            })
            ->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'innovation_sustainability';
            });
    }

    public function getImplementationImplementationQuestions(User $vendor)
    {
        return $this->selectionCriteriaQuestionsForVendor($vendor)
            ->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'implementation_implementation';
            });
    }

    public function getImplementationRunQuestions(User $vendor)
    {
        return $this->selectionCriteriaQuestionsForVendor($vendor)
            ->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'implementation_run';
            });
    }

    public function getFitGapQuestions(User $vendor)
    {
        return $this->selectionCriteriaQuestionsForVendor($vendor)
            ->get()
            ->filter(function ($question) {
                return $question->originalQuestion->page == 'fitgap';
            });
    }

    public function getFitGapLevel1() {

        $level1s = [];
        foreach ($this->fitgapQuestions as $el) {
            array_push($level1s, $el->level_1);
        }
        $level1s = array_values(array_unique(array_filter($level1s)));

        return $level1s;
    }


    public function getFitGapLevel1Weights()
    {
        $weights = [];
        foreach ($this->fitgapLevelWeights as $el) {
            array_push($weights, $el->name);
        }
        $weights = array_unique($weights);

        return $weights;
    }

    public function getLevelWeight($level)
    {
        return $this->fitgapLevelWeights->where('name', $level)->first()->weight;
    }
}
