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
 */
class VendorApplication extends Model
{
    public $guarded = [];

    protected $casts = [
        'invitedToOrals' => 'boolean',
        'oralsCompleted' => 'boolean',

        'fitgapVendorColumns' => 'array',
        'fitgapVendorScores' => 'array'
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

        if ($this->hasCompletedVendorSelectionCriteria()) {
            $score += 10;
        }

        return $score;
    }

    public function progressExperience() : int
    {
        $score = 0;
        if ($this->hasCompletedFitgap()) {
            $score += 10;
        }
        return $score;
    }

    public function progressInnovation() : int
    {
        $score = 0;
        if ($this->hasCompletedFitgap()) {
            $score += 10;
        }
        return $score;
    }

    public function progressImplementation() : int
    {
        $score = 0;
        if ($this->hasCompletedFitgap()) {
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

    function hasCompletedVendorSelectionCriteria(): bool
    {
        $vendorQuestions = $this->project
                                ->selectionCriteriaQuestionsOriginals()
                                ->whereIn('page', ['vendor_corporate', 'vendor_market'])
                                ->pluck('selection_criteria_questions.id')
                                ->toArray();

        $answeredQuestions = $this->project
                                ->selectionCriteriaQuestionsForVendor($this->vendor)
                                ->get()
                                ->map(function($response){
                                    return $response->originalQuestion;
                                })
                                ->filter(function($question){
                                    return in_array($question->page, ['vendor_corporate', 'vendor_market']);
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
        return collect([
            $this->fitgapScore(),
            $this->vendorScore(),
            $this->experienceScore(),
            $this->innovationScore(),
            $this->implementationScore(),
        ])->avg();
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
        if($response == 'Product fully supports the functionality') return 3;
        if($response == 'Product partially supports the functionality') return 2;
        if($response == 'Functionality planned for a future release') return 1;
        return 0;
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
        return $this->project->selectionCriteriaQuestionsForVendor($this->vendor)->whereHas('originalQuestion', function ($query) {
            $query
                ->where('page', 'implementation_implementation')
                ->orWhere('page', 'implementation_run');
        })->avg('score') ?? 0;
    }

    public function implementationMoney()
    {
        return 350000 + $this->id * 10000;
    }

    public function runMoney()
    {
        return 1250000 + $this->id * 25004;
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
