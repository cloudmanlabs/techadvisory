<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $phase One of invitation, applicating, pendingEvaluation, evaluated, submitted, disqualified, rejected
 */
class VendorApplication extends Model
{
    public $guarded = [];

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
