<?php

namespace App\Exports;

use App\Project;
use App\VendorApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class AnalyticsExport implements FromCollection, WithStrictNullComparison
{
    /** @var Project $project */
    private $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $return = $this->project->vendorApplications->map(function (VendorApplication $application) {
            return [
                'Vendor Name' => $application->vendor->name,
                'Fitgap Score' => $application->fitgapScore(),
                'Vendor Score' => $application->vendorScore(),
                'Experience Score' => $application->experienceScore(),
                'Innovation Score' => $application->innovationScore(),
                'Implementation Score' => $application->implementationScore(),
                'Total Score' => $application->totalScore(),
            ];
        });

        $return->prepend([
            'Vendor Name' => 'Vendor Name',
            'Fitgap Score' => 'Fitgap Score',
            'Vendor Score' => 'Vendor Score',
            'Experience Score' => 'Experience Score',
            'Innovation Score' => 'Innovation Score',
            'Implementation Score' => 'Implementation Score',
            'Total Score' => 'Total Score',
        ]);

        return $return;
    }
}
