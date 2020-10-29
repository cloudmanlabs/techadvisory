<?php

namespace App\Observers;

use App\VendorApplication;
use Guimcaballero\LaravelFolders\Models\Folder;

class VendorApplicationObserver
{
    public function created(VendorApplication $application)
    {
        // We add a row for each one on the fitgap
        $fitgapColumns = [];
        $scores = [];
        foreach ($application->project->fitgap5Columns as $key => $row) {
            $fitgapColumns[] = [
                'Vendor Response' => '',
                'Comments' => '',
            ];
            $scores[] = 5;
        }

        $application->fitgapVendorColumns = $fitgapColumns;
        $application->fitgapVendorColumnsOld = $fitgapColumns;
        $application->fitgapVendorColumnsOld2 = $fitgapColumns;
        $application->fitgapVendorColumnsOld3 = $fitgapColumns;
        $application->fitgapVendorColumnsOld4 = $fitgapColumns;
        $application->fitgapVendorColumnsOld5 = $fitgapColumns;
        $application->fitgapVendorColumnsOld6 = $fitgapColumns;
        $application->fitgapVendorColumnsOld7 = $fitgapColumns;
        $application->fitgapVendorColumnsOld8 = $fitgapColumns;
        $application->fitgapVendorColumnsOld9 = $fitgapColumns;
        $application->fitgapVendorColumnsOld10 = $fitgapColumns;
        $application->fitgapVendorScores = $scores;
        $application->save();

        $application->corporateFolder()->save(Folder::createNewRandomFolder('corporate'));
        $application->experienceFolder()->save(Folder::createNewRandomFolder('experience'));
    }
}
