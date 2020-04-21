<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $phase
 */
class VendorApplication extends Model
{
    public $guarded = [];


    public function setStarted() : VendorApplication
    {
        $this->phase = 'started';
        $this->save();

        return $this;
    }

    public function setSubmitted(): VendorApplication
    {
        $this->phase = 'submitted';
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
