<?php

namespace App\Exports\Sheets;

use App\SelectionCriteriaQuestionResponse;
use App\VendorApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class VendorResponsesExportSheet implements FromCollection, WithTitle
{
    /** @var VendorApplication $application */
    private $application;
    private $title;
    private $pages;

    public function __construct(VendorApplication $application, string $title, array $pages)
    {
        $this->application = $application;
        $this->title = $title;
        $this->pages = $pages;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $responses = $this
                        ->application
                        ->project
                        ->selectionCriteriaQuestionsForVendor($this->application->vendor)
                        ->get();

        $return = $responses
                    ->filter(function (SelectionCriteriaQuestionResponse $response){
                        return in_array($response->originalQuestion->page, $this->pages);
                    })
                    ->map(function (SelectionCriteriaQuestionResponse $response) {
                        if ($response->originalQuestion->type == 'selectMultiple') {
                            $answer = implode(', ', json_decode($response->response ?? '[]', true));
                        } else {
                            $answer =  $response->response ?? '';
                        }
                        return [
                            'Question' => $response->originalQuestion->label,
                            'Response' => $answer,
                            'Score' => $response->score ?? 0
                        ];
                    });

        $return->prepend([
            'Question' => 'Question',
            'Response' => 'Response',
            'Score' => 'Score',
        ]);

        return $return;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }
}
