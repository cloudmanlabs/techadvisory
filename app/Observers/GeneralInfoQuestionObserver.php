<?php

namespace App\Observers;

use App\GeneralInfoQuestion;
use App\GeneralInfoQuestionResponse;

class GeneralInfoQuestionObserver
{
    public function deleting(GeneralInfoQuestion $question)
    {
        // Delete responses to this Question
        $responses = GeneralInfoQuestionResponse::where('question_id', $question->id)->get();
        foreach ($responses as $key => $response) {
            $response->delete();
        }
    }

    public function saving(GeneralInfoQuestion $question)
    {
        // Reset all responses with this question
        $responses = GeneralInfoQuestionResponse::where('question_id', $question->id)->get();
        foreach ($responses as $key => $response) {
            $response->response = null;
            $response->save();
        }
    }
}
