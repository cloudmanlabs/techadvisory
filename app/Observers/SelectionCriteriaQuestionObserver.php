<?php

namespace App\Observers;

use App\SelectionCriteriaQuestion;
use App\SelectionCriteriaQuestionResponse;
use App\SelectionCriteriaQuestionProjectPivot;
use Illuminate\Support\Facades\Log;

class SelectionCriteriaQuestionObserver
{
    public function deleting(SelectionCriteriaQuestion $question)
    {
        // Delete responses to this Question
        $responses = SelectionCriteriaQuestionResponse::where('question_id', $question->id)->get();
        foreach ($responses as $key => $response) {
            $response->delete();
        }

        // Delete responses to this Question
        $pivots = SelectionCriteriaQuestionProjectPivot::where('question_id', $question->id)->get();
        foreach ($pivots as $key => $pivot) {
            $pivot->delete();
        }
    }

    public function saving(SelectionCriteriaQuestion $question)
    {
        // Reset all responses with this question
        $responses = SelectionCriteriaQuestionResponse::where('question_id', $question->id)->get();
        foreach ($responses as $key => $response) {
            $response->response = null;
            $response->save();
        }
    }

}
