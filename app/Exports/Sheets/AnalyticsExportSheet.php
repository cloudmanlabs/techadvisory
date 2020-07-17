<?php

namespace App\Exports\Sheets;

use App\SelectionCriteriaQuestionResponse;
use App\Project;
use App\SelectionCriteriaQuestion;
use App\VendorApplication;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class AnalyticsExportSheet implements FromCollection, WithTitle
{
    /** @var Project $project */
    private $project;
    /** @var array $vendorIds */
    private $vendorIds;
    private $title;
    private $pages;

    public function __construct(Project $project, array $vendorIds, string $title, array $pages)
    {
        $this->project = $project;
        $this->vendorIds = $vendorIds;
        $this->title = $title;
        $this->pages = $pages;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // What a fucking mess this is. Sorry :)

        $vendorIds = $this->vendorIds;
        $applications = $this
            ->project
            ->vendorApplications
            ->filter(function(VendorApplication $application) use ($vendorIds) {
                return in_array($application->vendor->id, $vendorIds);
            })
            ->sortBy(function ($application, $key) {
                return $application->vendor->id;
            });

        $firstRow = [
            'Question' => 'Question'
        ];
        foreach ($applications as $key => $application) {
            $firstRow[] = $application->vendor->name . ' Response';
            $firstRow[] = $application->vendor->name . ' Score';
        }

        $rows = [];

        $questionsByPage = $this->project->selectionCriteriaQuestions
            ->filter(function (SelectionCriteriaQuestionResponse $response) {
                return in_array($response->originalQuestion->page, $this->pages);
            })
            ->groupBy(function (SelectionCriteriaQuestionResponse $response, $key) {
                return $response->originalQuestion->page;
            });

        foreach ($questionsByPage as $page => $questions) {
            $rows[] = [
                SelectionCriteriaQuestion::pagesSelect[$page] ?? ''
            ];
            $rows[] = $firstRow;

            $questionsGrouped = $questions->groupBy(function ($question) {
                return $question->originalQuestion->id;
            });

            foreach ($questionsGrouped as $key => $responses) {
                $return = [
                    $responses[0]->originalQuestion->label,
                ];

                foreach ($applications as $key => $application) {
                    $response = $responses->filter(function($response) use ($application){
                        return $response->vendor->is($application->vendor);
                    })->first();
                    if($response == null){
                        $return[] = '';
                        $return[] = '';
                    }
                    $return[] = $response->response ?? '';
                    $return[] = $response->score ?? '';
                }

                $rows[] = $return;
            }

            $rows[] = [''];
        }

        return collect($rows);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }
}
