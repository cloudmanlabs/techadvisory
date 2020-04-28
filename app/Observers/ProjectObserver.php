<?php

namespace App\Observers;

use App\GeneralInfoQuestion;
use App\GeneralInfoQuestionResponse;
use App\Project;
use App\SelectionCriteriaQuestion;
use App\SelectionCriteriaQuestionProjectPivot;
use App\SelectionCriteriaQuestionResponse;
use App\SizingQuestion;
use App\SizingQuestionResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProjectObserver
{
    public function creating(Project $project)
    {
        if($project->scoringValues == null){
            $project->scoringValues = [0, 0, 0, 0, 0];
        }

        if ($project->deadline == null) {
            $project->deadline = Carbon::now()->addYear();
        }
    }

    public function created(Project $project)
    {
        // Add all GeneralInfoQuestions by default
        foreach (GeneralInfoQuestion::all() as $key => $question) {
            $response = new GeneralInfoQuestionResponse([
                'question_id' => $question->id,
                'project_id' => $project->id,
            ]);
            $response->save();
        }

        // Add all SizingQuestions by default
        foreach (SizingQuestion::all() as $key => $question) {
            $response = new SizingQuestionResponse([
                'question_id' => $question->id,
                'project_id' => $project->id,
            ]);
            $response->save();
        }

        foreach (SelectionCriteriaQuestion::all() as $key2 => $question) {
            $response = new SelectionCriteriaQuestionProjectPivot([
                'question_id' => $question->id,
                'project_id' => $project->id,
            ]);
            $response->save();
        }
    }

    // public function deleting(Project $project)
    // {
    //     foreach ($project->generalInfoQuestions as $key => $question) {
    //         $question->delete();
    //     }
    // }
}
