<?php

namespace App\Exports\Sheets;

use App\SelectionCriteriaQuestionResponse;
use App\VendorApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class VendorResponsesExportFitgapSheet implements FromCollection, WithTitle
{
    /** @var VendorApplication $application */
    private $application;

    public function __construct(VendorApplication $application)
    {
        $this->application = $application;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $fitgap5Columns = $this->application->project->fitgap5Columns;
        $fitgapClientColumns = $this->application->project->fitgapClientColumns;
        $fitgapVendorColumns = $this->application->fitgapVendorColumns;

        $result = [];
        foreach ($fitgap5Columns as $key => $something) {
            $result[] =
                array_merge(
                    $fitgap5Columns[$key],
                    $fitgapClientColumns[$key] ?? [
                        'Client' => '',
                        'Business Opportunity' => '',
                    ],
                    $fitgapVendorColumns[$key] ?? [
                        'Vendor Response' => '',
                        'Comments' => '',
                    ]
                );
        }

        $result = collect($result);

        $result->prepend([
            'Requirement Type',
            'Level 1',
            'Level 2',
            'Level 3',
            'Requirement',
            'Client',
            'Business Opportunity',
            'Vendor Response',
            'Comments',
        ]);

        return $result;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Fitgap';
    }
}
