<?php

namespace App\Nova;

use App\Project;
use App\SizingQuestionResponse as AppSizingQuestionResponse;
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

class SizingQuestionResponse extends Resource
{
    public static $displayInNavigation = false;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\SizingQuestionResponse';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'response';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'response'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            BelongsTo::make('Project', 'project', 'App\Nova\Project'),
            BelongsTo::make('Question', 'originalQuestion', 'App\Nova\SizingQuestion')
                ->hideWhenUpdating(),

            Text::make('Practice', function () {
                return optional(optional($this->originalQuestion)->practice)->name;
            }),

            Text::make('Response', 'response')
                ->hideWhenCreating(),
            Boolean::make('Should show', 'shouldShow'),
        ];
    }

    public static function relatableSizingQuestions(NovaRequest $request, $query)
    {
        if ($request->viaResource) {
            $selectedAgendaItems = Project::find($request->viaResourceId)->sizingQuestions()->pluck('question_id');
            return $query->whereNotIn('id', $selectedAgendaItems);
        } else {
            return $query;
        }
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
