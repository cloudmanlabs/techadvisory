<?php

namespace App\Observers;

use App\VendorSolution;
use App\VendorSolutionQuestion;
use App\VendorSolutionQuestionResponse;

class VendorSolutionObserver
{
    public function created(VendorSolution $solution)
    {
        foreach (VendorSolutionQuestion::all() as $key => $question) {
            $response = new VendorSolutionQuestionResponse([
                'question_id' => $question->id,
                'solution_id' => $solution->id,
            ]);
            $response->save();
        }
    }
}
