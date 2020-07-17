<?php

namespace App\Exports\Sheets;

use App\SelectionCriteriaQuestionResponse;
use App\Project;
use App\VendorApplication;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class AnalyticsExportFitgapSheet implements FromCollection, WithTitle
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
        $appliactions = $this->project->vendorApplications;

        $return = [];

        foreach ($appliactions as $key => $application) {
            $return[] = [$application->vendor->name];
            $smth = $application->fitgapCollectionExport();
            foreach ($smth as $key => $row) {
                $return[] = $row;
            }

            $return[] = [''];
        }

        return collect($return);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Fitgap';
    }
}
