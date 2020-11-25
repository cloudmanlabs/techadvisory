<?php

namespace App;

use Exception;
use Guimcaballero\LaravelFolders\Models\Folder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property string $phase One of invitation, applicating, pendingEvaluation, evaluated, submitted, disqualified, rejected
 * @property boolean $invitedToOrals
 * @property boolean $oralsCompleted
 *
 * @property array $fitgapVendorColumns
 *
 * @property array $solutionsUsed
 * @property array $deliverables
 * @property array $raciMatrix
 * @property array $staffingCost
 * @property array $travelCost
 * @property array $additionalCost
 * @property array $estimate5Years
 *
 * @property int $overallImplementationMax
 * @property int $overallImplementationMin
 *
 *  * @property double overall_score
 * @property double ranking_score
 *
 * @property double fitgap_score
 * @property double fitgap_functional_score
 * @property double fitgap_technical_score
 * @property double fitgap_service_score
 * @property double fitgap_others_score
 *
 * @property double vendor_score
 * @property double experience_score
 * @property double innovation_score
 *
 * @property double implementation_score
 * @property double implementation_implementation_score
 * @property double implementation_run_score
 *
 * @property Project $project
 * @property User $vendor
 */
class VendorApplication extends Model
{
    public $guarded = [];
    //public $phase = "";

    protected $casts = [
        'invitedToOrals' => 'boolean',
        'oralsCompleted' => 'boolean',

        'fitgapVendorColumns' => 'array',
        'fitgapVendorScores' => 'array',

        'solutionsUsed' => 'array',
        'deliverables' => 'array',
        'raciMatrix' => 'array',
        'staffingCost' => 'array',
        'travelCost' => 'array',
        'additionalCost' => 'array',
        'estimate5Years' => 'array',
    ];


    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function corporateFolder()
    {
        return $this->morphOne(Folder::class, 'folderable')->where('folderable_group', 'corporate');
    }

    public function experienceFolder()
    {
        return $this->morphOne(Folder::class, 'folderable')->where('folderable_group', 'experience');
    }

    public function progress(): int
    {
        $progressSetUp = $this->progressFitgap();
        $progressValue = $this->progressVendor();
        $progressResponse = $this->progressExperience();
        $progressAnalytics = $this->progressInnovation();
        $progressImplementation = $this->progressImplementation();
        $progressSubmit = $this->progressSubmit();

        return $progressSetUp +
            $progressValue +
            $progressResponse +
            $progressAnalytics +
            $progressImplementation +
            $progressSubmit;
    }

    public function progressFitgap(): int
    {
        $score = 0;

        if ($this->hasCompletedFitgap()) {
            $score += 30;
        }

        return $score;
    }

    public function progressVendor(): int
    {
        $score = 0;

        if ($this->hasCompletedVendorSelectionCriteriaIn(['vendor_corporate', 'vendor_market'])) {
            $score += 10;
        }

        return $score;
    }

    public function progressExperience(): int
    {
        $score = 0;
        if ($this->hasCompletedVendorSelectionCriteriaIn(['experience'])) {
            $score += 10;
        }
        return $score;
    }

    public function progressInnovation(): int
    {
        $score = 0;
        if ($this->hasCompletedVendorSelectionCriteriaIn(['innovation_digitalEnablers', 'innovation_alliances', 'innovation_product', 'innovation_sustainability'])) {
            $score += 10;
        }
        return $score;
    }

    public function progressImplementation(): int
    {
        $score = 0;
        if ($this->hasCompletedImplementation()) {
            $score += 30;
        }
        return $score;
    }

    public function progressSubmit(): int
    {
        $score = 0;
        if (in_array($this->phase, ['pendingEvaluation', 'evaluated', 'submitted'])) {
            $score += 10;
        }
        return $score;
    }

    function hasCompletedFitgap()
    {
        $fitgapResponses = FitgapVendorResponse::findByVendorApplication($this->id);
        foreach (($fitgapResponses ?? collect([])) as $key => $value) {
            if (!empty($value->response()) || $value->response() == null || $value->response() == '') return false;
        }
        return true;
    }

    function hasCompletedImplementation(): bool
    {
        if ($this->project->isBinding) {
            if (
                $this->staffingCost === null ||
                $this->travelCost === null ||
                $this->additionalCost === null ||
                $this->estimate5Years === null
            ) {
                return false;
            }
        } else {
            if (
                $this->overallImplementationMin === null ||
                $this->overallImplementationMax === null ||
                $this->averageYearlyCostMin === null ||
                $this->averageYearlyCostMax === null
            ) {
                return false;
            }
        }

        return true;
    }

    function hasCompletedVendorSelectionCriteriaIn(array $pages = []): bool
    {
        $vendorQuestions = $this->project
            ->selectionCriteriaQuestionsOriginals()
            ->whereIn('page', $pages)
            ->where('required', true)
            ->pluck('id')
            ->toArray();

        $answeredQuestions = $this->project
            ->selectionCriteriaQuestionsForVendor($this->vendor)
            ->get()
            ->filter(function (SelectionCriteriaQuestionResponse $response) {
                return
                    $response->response != null
                    && $response->response != ""
                    && $response->response != "[]";
            })
            ->map(function ($response) {
                return $response->originalQuestion;
            })
            ->filter(function ($question) use ($pages) {
                return in_array($question->page, $pages);
            })
            ->pluck('id')
            ->toArray();

        foreach ($vendorQuestions as $key => $question) {
            if (!in_array($question, $answeredQuestions)) {
                return false;
            }
        }

        return true;
    }

    function getScoreFromResponse($response)
    {
        if (!empty($response)) {
            $responseFromVendor = $response->response();
            if ($responseFromVendor == 'Product fully supports the functionality') return $this->project->fitgapWeightFullySupports ?? 3;
            if ($responseFromVendor == 'Product partially supports the functionality') return $this->project->fitgapWeightPartiallySupports ?? 2;
            if ($responseFromVendor == 'Functionality planned for a future release') return $this->project->fitgapWeightPlanned ?? 1;

            return $this->project->fitgapWeightNotSupported ?? 0;

        }

    }

    function getClientMultiplierInRow($question)
    {
        //$response = $this->project->fitgapClientColumns[$row]['Client'] ?? '';
        $responseClient = $question->client() ?? '';

        if ($responseClient == 'Must') return $this->project->fitgapWeightMust ?? 10;
        if ($responseClient == 'Required') return $this->project->fitgapWeightRequired ?? 5;
        if ($responseClient == 'Nice to have') return $this->project->fitgapWeightNiceToHave ?? 1;

        return 1;
    }

    public function ranking()
    {
        $score = 0;
        if (!empty($this->project)) {
            if ($this->project == null) {
                $score = 0;
            }

            $applications = $this->project->vendorApplications->sortByDesc(function ($application) {
                return $application->totalScore();
            });

            $rank = 1;
            foreach ($applications as $key => $app) {
                if ($app->is($this)) {
                    $score = $rank;
                } else {
                    $score = $rank++;
                }
            }
        }
        return $score;

        //throw new Exception('This exception is literally impossible to reach. VendorApplication::ranking');
    }

    public function totalScore()
    {
        $score = 0;
        if (!empty($this->project)) {
            $weights = collect($this->project->scoringValues ?? [0, 0, 0, 0, 0])
                ->map(function ($times) {
                    // We save the number of blocks, not the actual percentage
                    return $times * 5;
                });

            $totalWeight = $weights->sum();

            // If they haven't set the weights, just do the average
            if ($totalWeight == 0) {
                return collect([
                    $this->fitgapScore(),
                    $this->vendorScore(),
                    $this->experienceScore(),
                    $this->innovationScore(),
                    $this->implementationScore(),
                ])->avg();
            }
            $score = $this->fitgapScore() * ($weights[0] / $totalWeight) +
                $this->vendorScore() * ($weights[1] / $totalWeight) +
                $this->experienceScore() * ($weights[2] / $totalWeight) +
                $this->innovationScore() * ($weights[3] / $totalWeight) +
                $this->implementationScore() * ($weights[4] / $totalWeight);
        }

        return $score;

    }

    /**
     * Returns average of all fitgap scores
     *
     * @return float
     */
    public function fitgapScore()
    {
        $score = 0;
        if (!empty($this->project)) {
            $functionalScore = $this->fitgapFunctionalScore();
            $technicalScore = $this->fitgapTechnicalScore();
            $serviceScore = $this->fitgapServiceScore();
            $otherScore = $this->fitgapOtherScore();

            $score = (($this->project->fitgapFunctionalWeight ?? 60) / 100) * $functionalScore +
                (($this->project->fitgapTechnicalWeight ?? 20) / 100) * $technicalScore +
                (($this->project->fitgapServiceWeight ?? 10) / 100) * $serviceScore +
                (($this->project->fitgapOthersWeight ?? 10) / 100) * $otherScore;
        }

        return $score;
    }

    public function fitgapFunctionalScore()
    {
        return $this->averageScoreOfType('Functional');
    }

    public function fitgapTechnicalScore()
    {
        return $this->averageScoreOfType('Technical');
    }

    public function fitgapServiceScore()
    {
        return $this->averageScoreOfType('Service');
    }

    public function fitgapOtherScore()
    {
        return $this->averageScoreOfType('Others');
    }

    // Only for Fitgap Types
    function averageScoreOfType(string $type): float
    {

        $score = 0;
        if (!empty($this->project)) {
            $fitgapQuestions = FitgapQuestion::findByProject($this->project_id);

            $scores = [];
            $maxScores = [];
            if (!empty($fitgapQuestions)) {
                foreach ($fitgapQuestions as $key => $value) {
                    if ($value->requirementType() == $type) {
                        //$response = $this->fitgapVendorColumns[$key]['Vendor Response'] ?? '';
                        $response = FitgapVendorResponse::findByFitgapQuestionFromTheApplication(
                            $this->id, $value->id);
                        $multiplier = $this->getClientMultiplierInRow($value);

                        $scores[] = $this->getScoreFromResponse($response) * $multiplier;
                        $maxScores[] = ($this->project->fitgapWeightFullySupports ?? 3) * $multiplier;
                    }
                }
                if (count($scores) == 0 || count($maxScores) == 0) {
                    $score = 0;
                }

                $num = array_sum($scores);
                $denom = array_sum($maxScores);

                if ($denom == 0) {
                    $score = 0;
                } else {
                    $score = 10 * ($num / $denom);
                }
            }
        }

        return $score;
    }

    public function vendorScore()
    {
        $score = 0;
        if (!empty($this->project)) {
            $corp = $this->project->selectionCriteriaQuestionsForVendor($this->vendor)
                    ->whereHas('originalQuestion', function ($query) {
                        $query->where('page', 'vendor_corporate');
                    })
                    ->whereHas('originalQuestion', function ($query) {
                        $query->whereNull('linked_question_id');
                    })->avg('score') ?? 0;

            $market = $this->project->selectionCriteriaQuestionsForVendor($this->vendor)
                    ->whereHas('originalQuestion', function ($query) {
                        $query->where('page', 'vendor_market');
                    })
                    ->whereHas('originalQuestion', function ($query) {
                        $query->whereNull('linked_question_id');
                    })->avg('score') ?? 0;
            $score = collect([$corp, $market])->avg();
        }

        return $score;
    }

    public function experienceScore()
    {
        $score = 0;
        if (!empty($this->project)) {
            $score = $this->project->selectionCriteriaQuestionsForVendor($this->vendor)->whereHas('originalQuestion', function ($query) {
                    $query->where('page', 'experience');
                })
                    ->whereHas('originalQuestion', function ($query) {
                        $query->whereNull('linked_question_id');
                    })->avg('score') ?? 0;
        }

        return $score;
    }

    public function innovationScore()
    {
        $score = 0;
        if (!empty($this->project)) {
            $digital = $this->project->selectionCriteriaQuestionsForVendor($this->vendor)->whereHas('originalQuestion', function ($query) {
                    $query
                        ->where('page', 'innovation_digitalEnablers');
                })->whereHas('originalQuestion', function ($query) {
                    $query->whereNull('linked_question_id');
                })->avg('score') ?? 0;

            $alliances = $this->project->selectionCriteriaQuestionsForVendor($this->vendor)->whereHas('originalQuestion', function ($query) {
                    $query
                        ->where('page', 'innovation_alliances');
                })->whereHas('originalQuestion', function ($query) {
                    $query->whereNull('linked_question_id');
                })->avg('score') ?? 0;

            $product = $this->project->selectionCriteriaQuestionsForVendor($this->vendor)->whereHas('originalQuestion', function ($query) {
                    $query
                        ->where('page', 'innovation_product');
                })->whereHas('originalQuestion', function ($query) {
                    $query->whereNull('linked_question_id');
                })->avg('score') ?? 0;

            $sustainability = $this->project->selectionCriteriaQuestionsForVendor($this->vendor)->whereHas('originalQuestion', function ($query) {
                    $query
                        ->where('page', 'innovation_sustainability');
                })->whereHas('originalQuestion', function ($query) {
                    $query->whereNull('linked_question_id');
                })->avg('score') ?? 0;

            $score = collect([$digital, $alliances, $product, $sustainability])->avg();
        }

        return $score;
    }

    public function implementationScore()
    {
        $score = 0;
        if (!empty($this->project)) {
            $impScore = $this->implementationImplementationScore();

            $runScore = $this->implementationRunScore();

            $score = (($this->project->implementationImplementationWeight ?? 20) / 100) * $impScore +
                (($this->project->implementationRunWeight ?? 80) / 100) * $runScore;
        }

        return $score;
    }

    public function implementationImplementationScore()
    {
        $delta = $this->implementationCostDelta();

        if ($delta == 0) return 10;
        if ($delta <= 5) return 9;
        if ($delta <= 10) return 8;
        if ($delta <= 15) return 7;
        if ($delta <= 20) return 6;
        if ($delta <= 25) return 5;
        if ($delta <= 30) return 4;
        if ($delta <= 35) return 3;
        if ($delta <= 40) return 2;
        if ($delta <= 45) return 1;
        return 0;
    }

    public function implementationRunScore()
    {
        $delta = $this->runCostDelta();

        if ($delta == 0) return 10;
        if ($delta <= 5) return 9;
        if ($delta <= 10) return 8;
        if ($delta <= 15) return 7;
        if ($delta <= 20) return 6;
        if ($delta <= 25) return 5;
        if ($delta <= 30) return 4;
        if ($delta <= 35) return 3;
        if ($delta <= 40) return 2;
        if ($delta <= 45) return 1;
        return 0;
    }

    public function averageImplementationCost()
    {
        if (!empty($this->project)) {
            if ($this->project->isBinding) {
                return collect([
                    collect($this->staffingCost ?? ['cost' => '0',])
                        ->map(function ($el) {
                            return $el['cost'] ?? 0;
                        })
                        ->avg(),
                    collect($this->travelCost ?? ['cost' => '0',])
                        ->map(function ($el) {
                            return $el['cost'] ?? 0;
                        })
                        ->avg(),
                    collect($this->additionalCost ?? ['cost' => '0',])
                        ->map(function ($el) {
                            return $el['cost'] ?? 0;
                        })
                        ->avg(),
                ])
                    ->avg();
            } else {
                return collect([
                    $this->overallImplementationMin ?? 0,
                    $this->overallImplementationMax ?? 0,
                ])->average();
            }
        }
    }

    public function implementationCost()
    {
        if (!empty($this->project)) {
            if ($this->project->isBinding) {
                return collect([
                    collect($this->staffingCost ?? ['cost' => '0',])
                        ->map(function ($el) {
                            return $el['cost'] ?? 0;
                        })
                        ->sum(),
                    collect($this->travelCost ?? ['cost' => '0',])
                        ->map(function ($el) {
                            return $el['cost'] ?? 0;
                        })
                        ->sum(),
                    collect($this->additionalCost ?? ['cost' => '0',])
                        ->map(function ($el) {
                            return $el['cost'] ?? 0;
                        })
                        ->sum(),
                ])
                    ->sum();
            } else {
                return collect([
                    $this->overallImplementationMin ?? 0,
                    $this->overallImplementationMax ?? 0,
                ])->average();
            }
        }
    }

    public function implementationCostDelta()
    {
        $minCost = $this->project->minImplementationCost();
        $cost = $this->implementationCost();

        if ($minCost == 0) {
            // If the min and this vendors cost is 0, the delta is 0
            if ($cost == 0) return 0;
            // If not, it means that this vendor has a cost, but there is a vendor with cost 0, so delta is "infinite"
            return 100000000;
        }

        $difference = $cost - $minCost;

        if ($difference < 0) $difference = 0;

        return ($difference / $minCost) * 100;
    }

    public function runCost()
    {
        if ($this->project->isBinding) {
            return collect($this->estimate5Years ?? [0, 0, 0, 0, 0])
                    ->filter(function ($el) {
                        return $el != 0;
                    })
                    ->average() ?? 0;
        }

        return collect([
            $this->averageYearlyCostMin ?? 0,
            $this->averageYearlyCostMax ?? 0,
        ])->average();
    }

    public function averageRunCost()
    {
        if ($this->project->isBinding) {
            return collect($this->estimate5Years ?? [0, 0, 0, 0, 0])
                    ->filter(function ($el) {
                        return $el != 0;
                    })
                    ->average() ?? 0;
        }

        return collect([
            $this->averageYearlyCostMin ?? 0,
            $this->averageYearlyCostMax ?? 0,
        ])->average();
    }

    public function runCostDelta()
    {
        $minCost = $this->project->minRunCost();
        $cost = $this->averageRunCost();

        if ($minCost == 0) {
            // If the min and this vendors cost is 0, the delta is 0
            if ($cost == 0) return 0;
            // If not, it means that this vendor has a cost, but there is a vendor with cost 0, so delta is "infinite"
            return 100000000;
        }

        $difference = $cost - $minCost;

        if ($difference < 0) $difference = 0;

        return ($difference / $minCost) * 100;
    }

    /**
     * Calculate the scores and saves on DB.
     */
    public function updateMyScores()
    {
        $this->overall_score = $this->totalScore();
        $this->ranking_score = $this->ranking();

        $this->fitgap_score = $this->fitgapScore();
        $this->fitgap_functional_score = $this->fitgapFunctionalScore();
        $this->fitgap_technical_score = $this->fitgapTechnicalScore();
        $this->fitgap_service_score = $this->fitgapServiceScore();
        $this->fitgap_others_score = $this->fitgapOtherScore();

        $this->vendor_score = $this->vendorScore();
        $this->experience_score = $this->experienceScore();
        $this->innovation_score = $this->innovationScore();

        $this->implementation_score = $this->implementationScore();
        $this->implementation_implementation_score = $this->implementationImplementationScore();
        $this->implementation_run_score = $this->implementationRunScore();

        $this->save();

    }

    public function checkIfAllSelectionCriteriaQuestionsWereAnswered(): bool
    {
        if ($this->project->isBinding) {
            if ($this->staffingCost == null) return false;
            if ($this->travelCost == null) return false;
            if ($this->additionalCost == null) return false;
        } else {
            if ($this->staffingCostNonBinding == null) return false;
            if ($this->travelCostNonBinding == null) return false;
            if ($this->additionalCostNonBinding == null) return false;
        }

        $questionsFinished = $this->project->selectionCriteriaQuestionsForVendor($this->vendor)
                ->whereHas('originalQuestion', function ($query) {
                    $query->where('required', 'true');
                })
                ->get()
                ->filter(function ($response) {
                    return $response->response == null;
                })
                ->count() > 0;

        return $questionsFinished;
    }


    public function setApplicating(): VendorApplication
    {
        $this->phase = 'applicating';
        $this->save();

        return $this;
    }

    public function setPendingEvaluation(): VendorApplication
    {
        $this->phase = 'pendingEvaluation';
        $this->save();

        return $this;
    }

    public function setEvaluated(): VendorApplication
    {
        $this->phase = 'evaluated';
        $this->save();

        return $this;
    }

    public function setSubmitted(): VendorApplication
    {
        $this->phase = 'submitted';
        $this->save();

        return $this;
    }

    public function setDisqualified(): VendorApplication
    {
        $this->phase = 'disqualified';
        $this->save();

        return $this;
    }

    public function setRejected(): VendorApplication
    {
        $this->phase = 'rejected';
        $this->save();

        return $this;
    }

    public function doRollback(): VendorApplication
    {
        switch ($this->phase) {
            case "invitation":
                break;
            case "rejected":
            case "applicating":
                $this->phase = "invitation";
                break;
            case "disqualified":
            case "pendingEvaluation":
                $this->phase = "applicating";
                break;
            case "evaluated":
                $this->phase = "pendingEvaluation";
                break;
            case "submitted":
                $this->phase = "evaluated";
                break;
            default:
                $this->phase = "invitation";
        }
        return $this;
    }


    public function fitgapCollectionExport(): \Illuminate\Support\Collection
    {
        $fitgapQuestions = FitgapQuestion::findByProject($this->project_id);
        $fitgapResponses = FitgapVendorResponse::findByVendorApplication($this->id);

        $result = $fitgapQuestions->map(function ($fitgapQuestion) use ($fitgapResponses) {
            $fitgapResponseFound = $fitgapResponses->where('fitgap_question_id', $fitgapQuestion->id)->first();
            return [
                'ID' => $fitgapQuestion->id(),
                'Type' => $fitgapQuestion->requirementType(),
                'Level 1' => $fitgapQuestion->level1(),
                'Level 2' => $fitgapQuestion->level2(),
                'Level 3' => $fitgapQuestion->level3(),
                'Requirement' => $fitgapQuestion->requirement(),
                'Client' => $fitgapQuestion->client(),
                'Business Opportunity' => $fitgapQuestion->businessOpportunity(),
                'Vendor response' => $fitgapResponseFound ? $fitgapResponseFound->response() : '',
                'Comments' => $fitgapResponseFound ? $fitgapResponseFound->comments() : '',
            ];
        });

        $result = collect($result);

        $result->prepend([
            'ID',
            'Requirement Type',
            'Level 1',
            'Level 2',
            'Level 3',
            'Requirement',
            'Client',
            'Business Opportunity',
            'Vendor Response',
            'Comments',
        ]);

        return $result;
    }

    public function implementationCollectionExport(): \Illuminate\Support\Collection
    {
        $result = [
            [
                'Implementation'
            ],
            [
                'Solutions used',
                implode(', ', $this->solutionsUsed ?? []) // TODO Change this to display the names
            ],
        ];

        if ($this->deliverables != null) {
            $result[] = [''];
            $result[] = [
                'Deliverables per phase',
                'Title',
                'Deliverable'
            ];
            foreach ($this->deliverables as $key => $deliverable) {
                Log::debug($deliverable);
                $result[] = [
                    (intval($key) + 1),
                    $deliverable['title'] ?? '',
                    $deliverable['deliverable'] ?? ''
                ];
            }
        }


        if ($this->raciMatrix != null) {
            $result[] = [''];
            $result[] = [
                'RACI Matrix'
            ];
            $result[] = [
                '',
                'Title',
                'Client',
                'Vendor',
                'Accenture'
            ];
            foreach ($this->raciMatrix as $key => $row) {
                $result[] = [
                    (intval($key) + 1),
                    $row['title'] ?? '',
                    $row['client'] ?? '',
                    $row['vendor'] ?? '',
                    $row['accenture'] ?? ''
                ];
            }
        }

        $result[] = [''];
        $result[] = [
            'Implementation Cost',
        ];
        if ($this->project->isBinding) {
            if ($this->staffingCost != null) {
                $result[] = [''];
                $result[] = [
                    'Staffing Cost',
                ];
                $result[] = [
                    'Title',
                    'Estimated number of hours',
                    'Hourly rate',
                    'Staffing cost'
                ];
                $totalStaffing = 0;
                foreach ($this->staffingCost as $key => $row) {
                    $result[] = [
                        $row['title'] ?? '',
                        $row['hours'] ?? '',
                        $row['rate'] ?? '',
                        $row['cost'] ?? ''
                    ];
                    $totalStaffing += $row['cost'] ?? 0;
                }
                $result[] = [
                    '',
                    '',
                    '',
                    $totalStaffing
                ];
            }
            if ($this->travelCost != null) {
                $result[] = [''];
                $result[] = [
                    'Travel Cost',
                ];
                $result[] = [
                    'Title',
                    'Monthly travel cost',
                ];
                $totalStaffing = 0;
                foreach ($this->travelCost as $key => $row) {
                    $result[] = [
                        $row['title'] ?? '',
                        $row['cost'] ?? '',
                    ];
                    $totalStaffing += $row['cost'] ?? 0;
                }
                $result[] = [
                    '',
                    $totalStaffing
                ];
            }
            if ($this->additionalCost != null) {
                $result[] = [''];
                $result[] = [
                    'Additional Cost',
                ];
                $result[] = [
                    'Title',
                    'Cost',
                ];
                $totalAdditional = 0;
                foreach ($this->additionalCost as $key => $row) {
                    $result[] = [
                        $row['title'] ?? '',
                        $row['cost'] ?? '',
                    ];
                    $totalAdditional += $row['cost'] ?? 0;
                }
                $result[] = [
                    '',
                    $totalAdditional
                ];
            }

            $result[] = [''];
            $result[] = [
                'Overall Implementation Cost',
                $this->implementationCost()
            ];
        } else {
            $result[] = [''];
            $result[] = ['Overall Implementation Cost'];
            $result[] = [
                'Min',
                $this->overallImplementationMin ?? ''
            ];
            $result[] = [
                'Max',
                $this->overallImplementationMax ?? ''
            ];

            $result[] = ['Total Staffing cost (%)'];
            $result[] = [
                'Percentage',
                $this->staffingCostNonBinding ?? ''
            ];
            $result[] = [
                'Comments',
                $this->staffingCostNonBindingComments ?? ''
            ];


            $result[] = ['Total Travel cost (%)'];
            $result[] = [
                'Percentage',
                $this->travelCostNonBinding ?? ''
            ];
            $result[] = [
                'Comments',
                $this->travelCostNonBindingComments ?? ''
            ];


            $result[] = ['Total Additional cost (%)'];
            $result[] = [
                'Percentage',
                $this->additionalCostNonBinding ?? ''
            ];
            $result[] = [
                'Comments',
                $this->additionalCostNonBindingComments ?? ''
            ];
        }

        $result[] = [''];
        $result[] = [''];
        $result[] = [
            'Run',
        ];

        if ($this->project->isBinding) {
            if ($this->estimate5Years != null) {
                $result[] = [''];
                $result[] = [
                    'Estimate first 5 years billing plan',
                ];
                $totalRun = 0;
                foreach ($this->estimate5Years as $key => $value) {
                    $result[] = [
                        'Year ' . (intval($key) + 1),
                        $value,
                    ];
                    $totalRun += $value;
                }

                $result[] = [
                    'Total Run Cost',
                    $totalRun,
                ];
                $result[] = [
                    'Average Yearly Cost',
                    $this->averageRunCost(),
                ];
            }
        } else {
            $result[] = ['Average yearly cost'];
            $result[] = [
                'Min',
                $this->averageYearlyCostMin ?? ''
            ];
            $result[] = [
                'Max',
                $this->averageYearlyCostMax ?? ''
            ];

            $result[] = ['Total run cost'];
            $result[] = [
                'Min',
                $this->totalRunCostMin ?? ''
            ];
            $result[] = [
                'Max',
                $this->totalRunCostMax ?? ''
            ];

            if ($this->estimate5Years != null) {
                $result[] = [''];
                $result[] = [
                    'Estimate first 5 years billing plan',
                ];
                foreach ($this->estimate5Years as $key => $value) {
                    $result[] = [
                        'Year ' . (intval($key) + 1) . ' (% out of total run cost)',
                        $value,
                    ];
                }

                $result[] = [
                    'Average Yearly Cost',
                    $this->averageRunCost(),
                ];
            }
        }

        return collect($result);
    }

}
