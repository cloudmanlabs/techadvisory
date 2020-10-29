<?php

namespace App\Nova;

use App\Nova\Filters\FixedTypeSelectionCriteriaOnProject;
use App\Nova\Filters\PageTypeSelectionCriteriaOnProject;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;

class SelectionCriteriaQuestionProjectPivot extends Resource
{
    public static $displayInNavigation = false;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\SelectionCriteriaQuestionProjectPivot';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        $common = [
            // ID::make()->sortable(),

            BelongsTo::make('Project', 'project', '\App\Nova\Project'),
            BelongsTo::make('Questions', 'question', '\App\Nova\SelectionCriteriaQuestion')
                ->hideWhenUpdating()
                ->hideWhenCreating()
            ,
        ];

        $other = [];

        //  Here we assume we are on a form from a Project to Selection criteria Question project Pivot
        if (!empty($request->viaResourceId)) {
            // viaResourceId is a id from project.
            $projectId = intval($request->viaResourceId);
            $project = \App\Project::find($projectId);
            $options = $project->selectionCriteriaQuestionsAvailablesForMe();

            array_push($other,
                Select::make('Question', 'question_id')
                    ->options($options)
                    ->nullable()
                    ->hideFromIndex()
                    ->displayUsingLabels()
            );
        }

        return array_merge($common, $other);
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new PageTypeSelectionCriteriaOnProject,
            new FixedTypeSelectionCriteriaOnProject
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
