<?php

namespace App\Observers;

use App\VendorApplication;

class VendorApplicationObserver
{
    public function created(VendorApplication $application)
    {
        // TODO Change some stuff here or smth
        $result = [];

        foreach ($application->project->fitgapData as $key => $row) {
            $row['Score'] = 0;
            $result[] = $row;
        }

        $application->fitgapData = $result;
        $application->save();
    }
}
