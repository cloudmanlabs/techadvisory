<?php

namespace App\Exports;

use App\Exports\Sheets\AnalyticsExportSheet;
use App\Project;
use App\VendorApplication;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class AnalyticsExport implements WithMultipleSheets, WithStrictNullComparison
{
    /** @var Project $project */
    private $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new AnalyticsExportSheet($this->project, 'Fitgap', ['fitgap']);
        $sheets[] = new AnalyticsExportSheet($this->project, 'Vendor', ['vendor_corporate', 'vendor_market']);
        $sheets[] = new AnalyticsExportSheet($this->project, 'Innovation', ['innovation_digitalEnablers', 'innovation_alliances', 'innovation_product', 'innovation_sustainability']);
        $sheets[] = new AnalyticsExportSheet($this->project, 'Implementation', ['implementation_implementation', 'implementation_run']);

        return $sheets;
    }
}
