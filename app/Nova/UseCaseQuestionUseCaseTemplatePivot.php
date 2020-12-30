<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class UseCaseQuestionUseCaseTemplatePivot extends Resource
{
    public static $displayInNavigation = false;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\UseCaseQuestionUseCaseTemplatePivot';

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
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $common = [
            // ID::make()->sortable(),

            BelongsTo::make('Use Case Template', 'template', '\App\Nova\UseCaseTemplate'),
            BelongsTo::make('Template Questions', 'question', '\App\Nova\UseCaseQuestion')
                ->hideWhenUpdating()
                ->hideWhenCreating()
            ,
        ];

        $other = [];

        //  Here we assume we are on a form from a Project to Selection criteria Question project Pivot
        if (!empty($request->viaResourceId)) {
            // viaResourceId is a id from project.
            $useCaseTemplateId = intval($request->viaResourceId);
            $useCaseTemplate = \App\UseCaseTemplate::find($useCaseTemplateId);
            $options = $useCaseTemplate->useCaseQuestionsAvailablesForMe();

            array_push($other,
                Select::make('Question', 'use_case_questions_id')
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
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
