<?php

namespace App\Exports;

use App\Exports\Sheets\AnalyticsExportFitgapSheet;
use App\Exports\Sheets\AnalyticsExportUseCasesSheet;
use App\Exports\Sheets\AnalyticsExportImplementationSheet;
use App\Exports\Sheets\AnalyticsExportSheet;
use App\Project;
use App\VendorApplication;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class AnalyticsExport implements WithMultipleSheets, WithStrictNullComparison
{
    /** @var Project $project */
    private $project;

    public function __construct(Project $project, array $vendorIds, bool $includeUseCases = false)
    {
        $this->project = $project;
        $this->vendorIds = $vendorIds;
        $this->includeUseCases = $includeUseCases;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new AnalyticsExportFitgapSheet($this->project, $this->vendorIds);
        $sheets[] = new AnalyticsExportSheet($this->project, $this->vendorIds, 'Vendor', ['vendor_corporate', 'vendor_market']);
        $sheets[] = new AnalyticsExportSheet($this->project, $this->vendorIds, 'Experience', ['experience']);
        $sheets[] = new AnalyticsExportSheet($this->project, $this->vendorIds, 'Innovation', ['innovation_digitalEnablers', 'innovation_alliances', 'innovation_product', 'innovation_sustainability']);
        $sheets[] = new AnalyticsExportImplementationSheet($this->project, $this->vendorIds);
        if ($this->includeUseCases) {
            $sheets[] = new AnalyticsExportUseCasesSheet($this->project, $this->vendorIds);
        }

        return $sheets;
    }
}
