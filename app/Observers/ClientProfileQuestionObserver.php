<?php

namespace App\Observers;

use App\ClientProfileQuestion;
use App\ClientProfileQuestionResponse;

class ClientProfileQuestionObserver
{
    public function deleting(ClientProfileQuestion $question)
    {
        // Delete responses to this Question
        $responses = ClientProfileQuestionResponse::where('question_id', $question->id)->get();
        foreach ($responses as $key => $response) {
            $response->delete();
        }
    }

    public function saving(ClientProfileQuestion $question)
    {
        // Reset all responses with this question
        $responses = ClientProfileQuestionResponse::where('question_id', $question->id)->get();
        foreach ($responses as $key => $response) {
            $response->response = null;
            $response->save();
        }
    }
}
