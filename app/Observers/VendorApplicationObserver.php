<?php

namespace App\Observers;

use App\VendorApplication;

class VendorApplicationObserver
{
    public function created(VendorApplication $application)
    {
        // TODO Change some stuff here or smth
        $application->fitgapData = $application->project->fitgapData;
    }
}
