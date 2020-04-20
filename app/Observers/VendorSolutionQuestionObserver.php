<?php

namespace App\Observers;

use App\VendorSolutionQuestion;
use App\VendorSolutionQuestionResponse;

class VendorSolutionQuestionObserver
{
    public function deleting(VendorSolutionQuestion $question)
    {
        // Delete responses to this Question
        $responses = VendorSolutionQuestionResponse::where('question_id', $question->id)->get();
        foreach ($responses as $key => $response) {
            $response->delete();
        }
    }

    public function saving(VendorSolutionQuestion $question)
    {
        // Reset all responses with this question
        $responses = VendorSolutionQuestionResponse::where('question_id', $question->id)->get();
        foreach ($responses as $key => $response) {
            $response->response = null;
            $response->save();
        }
    }
}
