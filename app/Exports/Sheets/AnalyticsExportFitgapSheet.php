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
    /** @var array $vendorIds */
    private $vendorIds;

    public function __construct(Project$project, array $vendorIds)
    {
        $this->project = $project;
        $this->vendorIds = $vendorIds;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $vendorIds = $this->vendorIds;
        $appliactions = $this->project
            ->vendorApplications
            ->filter(function (VendorApplication $application) use ($vendorIds) {
                return in_array($application->vendor->id, $vendorIds);
            });

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
