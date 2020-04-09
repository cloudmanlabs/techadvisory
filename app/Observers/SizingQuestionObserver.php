<?php

namespace App\Observers;

use App\SizingQuestion;
use App\SizingQuestionResponse;

class SizingQuestionObserver
{
    public function deleting(SizingQuestion $question)
    {
        // Delete responses to this Question
        $responses = SizingQuestionResponse::where('question_id', $question->id)->get();
        foreach ($responses as $key => $response) {
            $response->delete();
        }
    }

    public function saving(SizingQuestion $question)
    {
        // Reset all responses with this question
        $responses = SizingQuestionResponse::where('question_id', $question->id)->get();
        foreach ($responses as $key => $response) {
            $response->response = null;
            $response->save();
        }
    }
}
