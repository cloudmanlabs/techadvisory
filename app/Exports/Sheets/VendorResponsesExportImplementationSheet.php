<?php

namespace App\Exports\Sheets;

use App\SelectionCriteriaQuestionResponse;
use App\VendorApplication;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class VendorResponsesExportImplementationSheet implements FromCollection, WithTitle
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
        return $this->application->implementationCollectionExport();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Implementation';
    }
}
