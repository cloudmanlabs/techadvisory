<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $phase One of invitation, applicating, pendingEvaluation, evaluated, submitted, disqualified, rejected
 */
class VendorApplication extends Model
{
    public $guarded = [];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
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

    public function fitgapScore()
    {
        // TODO Implement this after we do the actual fitgap
        return random_int(3, 8);
    }

    public function fitgapFunctionalScore()
    {
        return random_int(3, 8);
    }

    public function fitgapTechnicalScore()
    {
        return random_int(3, 8);
    }

    public function fitgapServiceScore()
    {
        return random_int(3, 8);
    }

    public function fitgapOtherScore()
    {
        return random_int(3, 8);
    }

    public function vendorScore()
    {
        return $this->project->selectionCriteriaQuestionsForVendor($this->vendor)->whereHas('original', function ($query) {
            $query
                ->where('page', 'vendor_corporate')
                ->orWhere('page', 'vendor_market');
        })->avg('score') ?? 0;
    }

    public function experienceScore()
    {
        return $this->project->selectionCriteriaQuestionsForVendor($this->vendor)->whereHas('original', function ($query) {
            $query
                ->where('page', 'experience');
        })->avg('score') ?? 0;
    }

    public function innovationScore()
    {
        return $this->project->selectionCriteriaQuestionsForVendor($this->vendor)->whereHas('original', function ($query) {
            $query
                ->where('page', 'innovation_digitalEnablers')
                ->orWhere('page', 'innovation_alliances')
                ->orWhere('page', 'innovation_product')
                ->orWhere('page', 'innovation_sustainability');
        })->avg('score') ?? 0;
    }

    public function implementationScore()
    {
        return $this->project->selectionCriteriaQuestionsForVendor($this->vendor)->whereHas('original', function ($query) {
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
