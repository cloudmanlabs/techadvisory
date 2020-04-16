<?php

namespace App\Observers;

use App\VendorProfileQuestion;
use App\VendorProfileQuestionResponse;

class VendorProfileQuestionObserver
{
    public function deleting(VendorProfileQuestion $question)
    {
        // Delete responses to this Question
        $responses = VendorProfileQuestionResponse::where('question_id', $question->id)->get();
        foreach ($responses as $key => $response) {
            $response->delete();
        }
    }

    public function saving(VendorProfileQuestion $question)
    {
        // Reset all responses with this question
        $responses = VendorProfileQuestionResponse::where('question_id', $question->id)->get();
        foreach ($responses as $key => $response) {
            $response->response = null;
            $response->save();
        }
    }
}
