<?php

namespace App\Exports\Sheets;

use App\SelectionCriteriaQuestion;
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

        $questionsByPage = $responses
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
                            'question' => $response->originalQuestion->label,
                            'response' => $answer,
                            'score' => $response->score ?? 0,
                            'page' => $response->originalQuestion->page
                        ];
                    })
                    ->groupBy('page')
                    ->toArray();

        $return = [
            [
                'Question' => 'Question',
                'Response' => 'Response',
                'Score' => 'Score',
            ]
        ];

        foreach ($this->pages as $key => $page) {
            $return[] = [ SelectionCriteriaQuestion::pagesSelect[$page] ?? '' ];
            foreach ($questionsByPage[$page] as $key => $question) {
                $return[] = [
                    'Question' => $question['question'] ?? '',
                    'Response' => $question['response'] ?? '',
                    'Score' => $question['score'] ?? '',
                ];
            }
        }

        return collect($return);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }
}
