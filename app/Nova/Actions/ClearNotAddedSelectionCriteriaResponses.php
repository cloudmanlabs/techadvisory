<?php

namespace App\Nova\Actions;

use App\SelectionCriteriaQuestionProjectPivot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class ClearNotAddedSelectionCriteriaResponses extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = "Remove not added Selection Criteria Responses";

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $key => $project) {
            $questionIds = SelectionCriteriaQuestionProjectPivot::where('project_id', $project->id)->pluck('question_id')->toArray();
            $uniqueIds = array_values(array_unique($questionIds));
            foreach ($project->selectionCriteriaQuestions as $key => $response) {
                if (!in_array($response->question_id, $uniqueIds)) {
                    $response->delete();
                }
            }
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
