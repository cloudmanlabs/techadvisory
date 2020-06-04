<?php

namespace App\Exports\Sheets;

use App\SelectionCriteriaQuestionResponse;
use App\Project;
use App\VendorApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class AnalyticsExportSheet implements FromCollection, WithTitle
{
    /** @var Project $project */
    private $project;
    private $title;
    private $pages;

    public function __construct(Project $project, string $title, array $pages)
    {
        $this->project = $project;
        $this->title = $title;
        $this->pages = $pages;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // What a fucking mess this is. Sorry :)

        $vendors = $this->project->vendorApplications;

        $firstRow = $vendors
            ->sortBy(function ($application, $key) {
                return $application->vendor->id;
            })
            ->map(function (VendorApplication $application) {
                return [
                    'Vendor Response' => $application->vendor->name . ' Response',
                    'Vendor Score' => $application->vendor->name . ' Score',
                ];
            })
            ->prepend([
                'Question' => 'Question',
            ])
            ->flatten();

        $rows = $this->project->selectionCriteriaQuestions
                ->filter(function (SelectionCriteriaQuestionResponse $response) {
                    return in_array($response->originalQuestion->page, $this->pages);
                })
                ->groupBy(function (SelectionCriteriaQuestionResponse $response, $key) {
                    return $response->originalQuestion->id;
                })
                ->filter(function($arrayOfResponses){
                    return count($arrayOfResponses) > 0;
                })
                ->map(function($arrayOfResponses){
                    return collect($arrayOfResponses)
                            ->sortBy(function (SelectionCriteriaQuestionResponse $response, $key) {
                                return $response->vendor->id;
                            })
                            ->map(function(SelectionCriteriaQuestionResponse $response){
                                return [
                                    'Vendor Response' => $response->response,
                                    'Vendor Score' => $response->score,
                                ];
                            })
                            ->flatten()
                            ->prepend($arrayOfResponses[0]->originalQuestion->label)
                            ->toArray();
                });

        $rows->prepend($firstRow);

        return $rows;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }
}
