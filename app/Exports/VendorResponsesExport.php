<?php

namespace App\Exports;

use App\Exports\Sheets\VendorResponsesExportFitgapSheet;
use App\Exports\Sheets\VendorResponsesExportSheet;
use App\SelectionCriteriaQuestionResponse;
use App\VendorApplication;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class VendorResponsesExport implements WithMultipleSheets, WithStrictNullComparison
{
    use Exportable;

    /** @var VendorApplication $application */
    private $application;

    public function __construct(VendorApplication $application)
    {
        $this->application = $application;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new VendorResponsesExportFitgapSheet($this->application);
        $sheets[] = new VendorResponsesExportSheet($this->application, 'Vendor', [ 'vendor_corporate', 'vendor_market' ]);
        $sheets[] = new VendorResponsesExportSheet($this->application, 'Innovation', ['innovation_digitalEnablers','innovation_alliances','innovation_product','innovation_sustainability']);
        $sheets[] = new VendorResponsesExportSheet($this->application, 'Implementation', ['implementation_implementation','implementation_run']);

        return $sheets;
    }
}
