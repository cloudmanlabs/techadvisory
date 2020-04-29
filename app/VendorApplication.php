<?php

namespace App;

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









    public function totalScore()
    {
        // TODO Implement the calculations here
        return random_int(3, 8);
    }

    public function fitgapScore()
    {
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
        return random_int(3, 8);
    }

    public function experienceScore()
    {
        return random_int(3, 8);
    }

    public function innovationScore()
    {
        return random_int(3, 8);
    }

    public function implementationScore()
    {
        return random_int(3, 8);
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
