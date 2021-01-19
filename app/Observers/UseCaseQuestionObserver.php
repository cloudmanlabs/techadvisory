<?php

namespace App\Observers;

use App\UseCaseQuestion;
use App\UseCaseTemplateQuestionResponse;

class UseCaseQuestionObserver
{
    public function deleting(UseCaseQuestion $question)
    {
        // Delete responses to this Question
        $responses = UseCaseTemplateQuestionResponse::where('use_case_questions_id', $question->id)->get();
        foreach ($responses as $key => $response) {
            $response->delete();
        }
    }

    public function saving(UseCaseQuestion $question)
    {
        // Reset all responses with this question
        $responses = UseCaseTemplateQuestionResponse::where('use_case_questions_id', $question->id)->get();
        foreach ($responses as $key => $response) {
            $response->response = null;
            $response->save();
        }
    }
}
