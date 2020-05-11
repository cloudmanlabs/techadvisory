<?php

namespace App\Observers;

use App\VendorApplication;

class VendorApplicationObserver
{
    public function creating(VendorApplication $application)
    {
        $application->fitgapData = [
            [
                "Requirement Type" => "Functional",
                "Level 1" => "Transportation",
                "Level 2" => "Transport planning",
                "Level 3" => "Optimization",
                "Requirement" => "Requierement 1",
                "Client" => "Nice to have",
                "Comments" => ""
            ]
        ];
    }
}
