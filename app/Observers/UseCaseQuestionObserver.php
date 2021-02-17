<?php

namespace App\Observers;

use App\UseCaseQuestion;
use App\UseCaseTemplate;
use App\UseCaseTemplateQuestionResponse;

class UseCaseQuestionObserver
{
//    public function created(UseCaseQuestion $question)
//    {
//        // Add the question to all UseCaseTemplates by default
//        foreach (UseCaseTemplate::all() as $key => $useCaseTemplate) {
//            $response = new UseCaseTemplateQuestionResponse([
//                'use_case_questions_id' => $question->id,
//                'use_case_templates_id' => $useCaseTemplate->id,
//            ]);
//            $response->save();
//        }
//    }

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
