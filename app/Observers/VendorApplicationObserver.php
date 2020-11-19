<?php

namespace App\Observers;

use App\VendorApplication;
use Guimcaballero\LaravelFolders\Models\Folder;

class VendorApplicationObserver
{
    public function created(VendorApplication $application)
    {
        $application->corporateFolder()->save(Folder::createNewRandomFolder('corporate'));
        $application->experienceFolder()->save(Folder::createNewRandomFolder('experience'));
    }
}
