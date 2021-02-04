<?php

namespace App\Observers;

use App\UseCaseQuestion;
use App\UseCaseTemplateQuestionResponse;
use App\UseCaseTemplate;

class UseCaseTemplateObserver
{
    public function created(UseCaseTemplate $useCaseTemplate)
    {
        // Add all UseCaseQuestions with the same practice by default
        $questions = UseCaseQuestion::where('practice_id', '=', $useCaseTemplate->practice_id)
            ->get();
        foreach ($questions as $question) {
            $response = new UseCaseTemplateQuestionResponse([
                'use_case_questions_id' => $question->id,
                'use_case_templates_id' => $useCaseTemplate->id,
            ]);
            $response->save();
        }
    }
}
