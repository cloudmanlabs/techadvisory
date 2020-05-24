<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property string $phase One of invitation, applicating, pendingEvaluation, evaluated, submitted, disqualified, rejected
 * @property boolean $invitedToOrals
 * @property boolean $oralsCompleted
 *
 * @property array $fitgapVendorColumns
 * @property array $fitgapVendorScores
 *
 * @property array $deliverables
 * @property array $raciMatrix
 * @property array $staffingCost
 * @property array $travelCost
 * @property array $additionalCost
 *
 * @property Project $project
 * @property User $vendor
 */
class VendorApplication extends Model
{
    public $guarded = [];

    protected $casts = [
        'invitedToOrals' => 'boolean',
        'oralsCompleted' => 'boolean',

        'fitgapVendorColumns' => 'array',
        'fitgapVendorScores' => 'array',

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









    public function progressFitgap() : int
    {
        $score = 0;

        if($this->hasCompletedFitgap()){
            $score += 30;
        }

        return $score;
    }

    public function progressVendor() : int
    {
        $score = 0;

        if ($this->hasCompletedVendorSelectionCriteriaIn(['vendor_corporate', 'vendor_market'])) {
            $score += 10;
        }

        return $score;
    }

    public function progressExperience() : int
    {
        $score = 0;
        if ($this->hasCompletedVendorSelectionCriteriaIn(['experience'])) {
            $score += 10;
        }
        return $score;
    }

    public function progressInnovation() : int
    {
        $score = 0;
        if ($this->hasCompletedVendorSelectionCriteriaIn(['innovation_digitalEnablers', 'innovation_alliances', 'innovation_product', 'innovation_sustainability'])) {
            $score += 10;
        }
        return $score;
    }

    public function progressImplementation() : int
    {
        $score = 0;
        if ($this->hasCompletedVendorSelectionCriteriaIn(['implementation_implementation', 'implementation_run'])) {
            $score += 30;
        }
        return $score;
    }

    public function progressSubmit() : int
    {
        $score = 0;
        if (in_array($this->phase, ['pendingEvaluation', 'evaluated', 'submitted'])) {
            $score += 10;
        }
        return $score;
    }

    function hasCompletedFitgap()
    {
        foreach (($this->fitgapVendorColumns ?? []) as $key => $value) {
            if (!isset($value['Vendor Response']) || $value['Vendor Response'] == null || $value['Vendor Response'] == '') return false;
        }
        return true;
    }

    function hasCompletedVendorSelectionCriteriaIn(array $pages = []): bool
    {
        $vendorQuestions = $this->project
                                ->selectionCriteriaQuestionsOriginals()
                                ->whereIn('page', $pages)
                                ->pluck('selection_criteria_questions.id')
                                ->toArray();

        $answeredQuestions = $this->project
                                ->selectionCriteriaQuestionsForVendor($this->vendor)
                                ->get()
                                ->map(function($response){
                                    return $response->originalQuestion;
                                })
                                ->filter(function($question) use ($pages) {
                                    return in_array($question->page, $pages);
                                })
                                ->pluck('id')
                                ->toArray();

        foreach ($vendorQuestions as $key => $question) {
            if(!in_array($question, $answeredQuestions)){
                return false;
            }
        }

        return true;
    }






    public function ranking()
    {
        $applications = $this->project->vendorApplications->sortByDesc(function($application){
            return $application->totalScore();
        });

        $rank = 1;
        foreach ($applications as $key => $app) {
            if($app->is($this)){
                return $rank;
            } else {
                $rank++;
            }
        }

        throw new Exception('This exception is literally impossible to reach. VendorApplication::ranking');
    }

    public function totalScore()
    {
        $weights = $this->project->scoringValues ?? [0, 0, 0, 0, 0];

        // If they haven't set the weights, just do the average
        if(array_sum($weights) == 0){
            return collect([
                $this->fitgapScore(),
                $this->vendorScore(),
                $this->experienceScore(),
                $this->innovationScore(),
                $this->implementationScore(),
            ])->avg();
        }

        return
                $this->fitgapScore() * ($weights[0] / 100) +
                $this->vendorScore() * ($weights[1] / 100) +
                $this->experienceScore() * ($weights[2] / 100) +
                $this->innovationScore() * ($weights[3] / 100) +
                $this->implementationScore() * ($weights[4] / 100);
    }

    /**
     * Returns average of all fitgap scores
     *
     * @return void
     */
    public function fitgapScore()
    {
        $scores = [];
        foreach ($this->fitgapVendorScores as $key => $value) {
            $multiplier = $this->fitgapVendorColumns[$key]['Vendor Response'] ?? '';

            $scores[] = $value * $this->getVendorMultiplier($multiplier);
        }

        return array_sum($scores) / (count($scores) * 3);
    }

    function getVendorMultiplier(string $response){
        if($response == 'Product fully supports the functionality') return $this->project->fitgapWeightFullySupports ?? 3;
        if($response == 'Product partially supports the functionality') return $this->project->fitgapWeightPartiallySupports ?? 2;
        if($response == 'Functionality planned for a future release') return $this->project->fitgapWeightPlanned ?? 1;
        return $this->project->fitgapWeightNotSupported ?? 0;
    }

    function averageScoreOfType(string $type) : float{
        $fitgap5cols = $this->project->fitgap5Columns;

        $scores = [];
        foreach ($fitgap5cols as $key => $value) {
            if ($value['Requirement Type'] == $type) {
                $multiplier = $this->fitgapVendorColumns[$key]['Vendor Response'] ?? '';

                $scores[] = $this->fitgapVendorScores[$key] * $this->getVendorMultiplier($multiplier);
            }
        }

        return array_sum($scores) / (count($scores) * 3);
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




    public function vendorScore()
    {
        return $this->project->selectionCriteriaQuestionsForVendor($this->vendor)->whereHas('originalQuestion', function ($query) {
            $query
                ->where('page', 'vendor_corporate')
                ->orWhere('page', 'vendor_market');
        })->avg('score') ?? 0;
    }

    public function experienceScore()
    {
        return $this->project->selectionCriteriaQuestionsForVendor($this->vendor)->whereHas('originalQuestion', function ($query) {
            $query
                ->where('page', 'experience');
        })->avg('score') ?? 0;
    }

    public function innovationScore()
    {
        return $this->project->selectionCriteriaQuestionsForVendor($this->vendor)->whereHas('originalQuestion', function ($query) {
            $query
                ->where('page', 'innovation_digitalEnablers')
                ->orWhere('page', 'innovation_alliances')
                ->orWhere('page', 'innovation_product')
                ->orWhere('page', 'innovation_sustainability');
        })->avg('score') ?? 0;
    }

    public function implementationScore()
    {
        $impScore = $this->project->selectionCriteriaQuestionsForVendor($this->vendor)->whereHas('originalQuestion', function ($query) {
            $query
                ->where('page', 'implementation_implementation');
        })->avg('score') ?? 0;

        $runScore = $this->project->selectionCriteriaQuestionsForVendor($this->vendor)->whereHas('originalQuestion', function ($query) {
            $query
                ->where('page', 'implementation_run');
        })->avg('score') ?? 0;

        return 0.2 * $impScore + 0.8 * $runScore;
    }

    public function implementationMoney()
    {
        if($this->project->isBinding){
            return collect([
                $this->staffingCost ?? [0],
                $this->travelCost ?? [0],
                $this->additionalCost ?? [0],
            ])
            ->flatten()
            ->average();
        } else {
            return collect([
                $this->staffingCostNonBinding ?? 0,
                $this->travelCostNonBinding ?? 0,
                $this->additionalCostNonBinding ?? 0,
            ])->average();
        }
    }

    public function runMoney()
    {
        return collect($this->estimate5Years ?? [0, 0, 0, 0, 0])->average();
    }






    public function checkIfAllSelectionCriteriaQuestionsWereAnswered(): bool
    {
        if($this->project->isBinding){
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
                ->filter(function($response){
                    return $response->response == null;
                })
                ->count() > 0;

        return $questionsFinished;
    }



    public function setApplicating() : VendorApplication
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
}
