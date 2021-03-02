<?php

namespace App\Observers;

use App\SelectionCriteriaQuestionProjectPivot;
use App\SelectionCriteriaQuestionResponse;
use Illuminate\Support\Facades\Log;

class SelectionCriteriaQuestionProjectPivotObserver
{

//    public function deleting(SelectionCriteriaQuestionProjectPivot $projectQuestion)
//    {
//        // Delete responses to this Question
//        $responses = SelectionCriteriaQuestionResponse::where('question_id', $projectQuestion->question_id)
//            ->where('project_id', $projectQuestion->project_id)->get();
//        foreach ($responses as $key => $response) {
//            $response->delete();
//        }
//    }

}
