<?php

namespace App\Nova;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Project extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Project';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name'
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
            Text::make('Name', 'name')
                ->rules('required')
                ->required(),


            Text::make('Current Phase', 'currentPhase')
                ->sortable()
                ->exceptOnForms(),

            DateTime::make('Deadline', 'deadline')
                ->sortable(),

            Boolean::make('Orals', 'hasOrals'),
            Boolean::make('Value Targeting', 'hasValueTargeting'),

            Boolean::make('Accenture finished Selection Criteria', 'step4FinishedAccenture')
                ->hideFromIndex(),
            Boolean::make('Client finished Selection Criteria', 'step4FinishedClient')
                ->hideFromIndex(),

            Number::make('Set Up Progress', 'progressSetUp')
                ->exceptOnForms()
                ->hideFromIndex(),
            Number::make('Value Progress', 'progressValue')
                ->exceptOnForms()
                ->hideFromIndex(),
            Number::make('Response Progress', 'progressResponse')
                ->exceptOnForms()
                ->hideFromIndex(),
            Number::make('Analytics Progress', 'progressAnalytics')
                ->exceptOnForms()
                ->hideFromIndex(),
            Number::make('Conclusions Progress', 'progressConclusions')
                ->exceptOnForms()
                ->hideFromIndex(),

            BelongsTo::make('Client', 'client', 'App\Nova\User')
                ->sortable(),
            BelongsTo::make('Practice', 'practice', 'App\Nova\Practice')
                ->sortable(),

            HasMany::make('General Info Questions', 'generalInfoQuestions', 'App\Nova\GeneralInfoQuestionResponse'),
            HasMany::make('Sizing Questions', 'sizingQuestions', 'App\Nova\SizingQuestionResponse'),
            BelongsToMany::make('Subpractices', 'subpractices', 'App\Nova\Subpractice'),
        ];
    }

    public static function relatableUsers(NovaRequest $request, $query)
    {
        return $query->whereIn('userType', User::clientTypes);
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
