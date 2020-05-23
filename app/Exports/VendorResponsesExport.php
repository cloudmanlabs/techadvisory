<?php

namespace App\Exports;

use App\SelectionCriteriaQuestionResponse;
use App\VendorApplication;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class VendorResponsesExport implements FromCollection, WithStrictNullComparison
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
        $responses = $this->application->project->selectionCriteriaQuestionsForVendor($this->application->vendor)->get();

        $return = $responses->map(function(SelectionCriteriaQuestionResponse $response){
            if($response->originalQuestion->type == 'selectMultiple'){
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
}
