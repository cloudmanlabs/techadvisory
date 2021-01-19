<?php

namespace App\Observers;

use App\UseCaseQuestion;
use App\UseCaseTemplateQuestionResponse;
use App\UseCaseTemplate;

class UseCaseTemplateObserver
{
    public function created(UseCaseTemplate $useCaseTemplate)
    {
        // Add all UseCaseQuestions by default
        foreach (UseCaseQuestion::all() as $key => $question) {
            $response = new UseCaseTemplateQuestionResponse([
                'use_case_questions_id' => $question->id,
                'use_case_templates_id' => $useCaseTemplate->id,
            ]);
            $response->save();
        }
    }
}
